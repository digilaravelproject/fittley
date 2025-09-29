<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CommissionTier;
use App\Models\User;
use App\Models\InfluencerProfile;

class UpdateInfluencerTiers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'influencer:update-tiers {--dry-run : Show what would be updated without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update influencer commission tiers based on their performance metrics';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Starting Influencer Tier Update Process...');
        $this->newLine();

        $dryRun = $this->option('dry-run');
        
        if ($dryRun) {
            $this->warn('🧪 DRY RUN MODE - No changes will be saved');
            $this->newLine();
        }

        // Get all influencers
        $influencers = User::whereHas('influencerProfile', function($query) {
            $query->where('status', 'approved');
        })->with(['influencerProfile', 'currentCommissionTier'])->get();

        if ($influencers->isEmpty()) {
            $this->warn('No approved influencers found.');
            return 0;
        }

        $this->info("Found {$influencers->count()} approved influencers to evaluate");
        $this->newLine();

        // Create progress bar
        $progressBar = $this->output->createProgressBar($influencers->count());
        $progressBar->setFormat('very_verbose');

        $updates = [];
        $errors = [];

        foreach ($influencers as $influencer) {
            try {
                $oldTier = $influencer->currentCommissionTier;
                $oldTierName = $oldTier ? $oldTier->name : 'None';
                
                // Calculate new tier
                $newTier = CommissionTier::calculateTierForUser($influencer);
                $newTierName = $newTier ? $newTier->name : 'None';
                
                // Check if tier changed
                if ($oldTier?->id !== $newTier?->id) {
                    $updates[] = [
                        'user' => $influencer,
                        'old_tier' => $oldTier,
                        'new_tier' => $newTier,
                        'old_tier_name' => $oldTierName,
                        'new_tier_name' => $newTierName,
                    ];

                    // Update if not dry run
                    if (!$dryRun && CommissionTier::updateUserTier($influencer)) {
                        // Tier updated successfully
                    }
                }

            } catch (\Exception $e) {
                $errors[] = [
                    'user' => $influencer->name,
                    'error' => $e->getMessage()
                ];
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        // Display results
        if (!empty($updates)) {
            $this->info('📊 Tier Updates:');
            $this->table(
                ['Influencer', 'Email', 'Old Tier', 'New Tier', 'Commission Change'],
                collect($updates)->map(function($update) {
                    $oldCommission = $update['old_tier'] ? $update['old_tier']->getTotalCommission() : 0;
                    $newCommission = $update['new_tier'] ? $update['new_tier']->getTotalCommission() : 0;
                    $commissionChange = $newCommission - $oldCommission;
                    
                    return [
                        $update['user']->name,
                        $update['user']->email,
                        $update['old_tier_name'],
                        $update['new_tier_name'],
                        ($commissionChange > 0 ? '+' : '') . number_format($commissionChange, 2) . '%'
                    ];
                })->toArray()
            );
        } else {
            $this->info('✅ No tier updates needed - all influencers are in their correct tiers');
        }

        // Display errors
        if (!empty($errors)) {
            $this->newLine();
            $this->error('❌ Errors encountered:');
            $this->table(
                ['Influencer', 'Error'],
                collect($errors)->map(function($error) {
                    return [$error['user'], $error['error']];
                })->toArray()
            );
        }

        // Summary
        $this->newLine();
        $this->info("📈 Summary:");
        $this->line("• Total influencers evaluated: {$influencers->count()}");
        $this->line("• Tier updates needed: " . count($updates));
        $this->line("• Errors: " . count($errors));
        
        if ($dryRun && !empty($updates)) {
            $this->newLine();
            $this->warn('🧪 This was a dry run. To apply changes, run:');
            $this->line('php artisan influencer:update-tiers');
        } elseif (!$dryRun && !empty($updates)) {
            $this->newLine();
            $this->info('✅ Tier updates have been applied successfully!');
        }

        return 0;
    }

    /**
     * Display detailed metrics for a user (helper method)
     */
    private function displayUserMetrics(User $user): void
    {
        $metrics = CommissionTier::calculateUserMetrics($user);
        
        $this->line("Metrics for {$user->name}:");
        $this->line("• Total visits: " . number_format($metrics['total_visits']));
        $this->line("• Total conversions: " . number_format($metrics['total_conversions']));
        $this->line("• Total revenue: $" . number_format($metrics['total_revenue'], 2));
        $this->line("• Active days: " . number_format($metrics['active_days']));
        $this->line("• Monthly visits: " . number_format($metrics['monthly_visits']));
        $this->line("• Monthly conversions: " . number_format($metrics['monthly_conversions']));
        $this->line("• Monthly revenue: $" . number_format($metrics['monthly_revenue'], 2));
    }
}
