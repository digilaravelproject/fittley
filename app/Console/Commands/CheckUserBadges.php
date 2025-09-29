<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Services\BadgeService;

class CheckUserBadges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'badges:check {--user-id= : Check badges for specific user} {--dry-run : Show what would be awarded without saving}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and award badges for users';

    protected $badgeService;

    /**
     * Create a new command instance.
     */
    public function __construct(BadgeService $badgeService)
    {
        parent::__construct();
        $this->badgeService = $badgeService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🏆 Starting Badge Check Process...');
        $this->newLine();

        $userId = $this->option('user-id');
        $dryRun = $this->option('dry-run');
        
        if ($dryRun) {
            $this->warn('🧪 DRY RUN MODE - No badges will be awarded');
            $this->newLine();
        }

        if ($userId) {
            $user = User::find($userId);
            if (!$user) {
                $this->error("❌ User with ID {$userId} not found!");
                return 1;
            }
            
            $this->checkUserBadges($user, $dryRun);
        } else {
            $this->checkAllUsers($dryRun);
        }

        return 0;
    }

    protected function checkUserBadges(User $user, bool $dryRun = false)
    {
        $this->info("👤 Checking badges for: {$user->name} (ID: {$user->id})");
        
        $activeBadges = \App\Models\Badge::active()->get();
        $eligibleBadges = [];
        
        foreach ($activeBadges as $badge) {
            // Skip if user already has this badge
            if ($user->userBadges()->where('badge_id', $badge->id)->exists()) {
                continue;
            }
            
            // Check if user meets criteria
            if ($this->badgeService->userMeetsCriteria($user, $badge)) {
                $eligibleBadges[] = $badge;
            }
        }
        
        if (empty($eligibleBadges)) {
            $this->line("  ✅ No new badges eligible");
            return;
        }
        
        $this->info("  🎯 Found " . count($eligibleBadges) . " eligible badges:");
        
        foreach ($eligibleBadges as $badge) {
            $this->line("    - {$badge->name} ({$badge->type}) - {$badge->points} points");
            
            if (!$dryRun) {
                $this->badgeService->awardBadge($user, $badge);
                $this->line("      ✅ Awarded!");
            } else {
                $this->line("      🔸 Would be awarded");
            }
        }
    }

    protected function checkAllUsers(bool $dryRun = false)
    {
        $users = User::all();
        $this->info("👥 Checking badges for {$users->count()} users");
        $this->newLine();

        $totalAwarded = 0;
        $usersWithBadges = 0;

        $progressBar = $this->output->createProgressBar($users->count());
        $progressBar->start();

        foreach ($users as $user) {
            $newlyAwarded = $this->badgeService->checkAndAwardBadges($user);
            
            if (!empty($newlyAwarded)) {
                $totalAwarded += count($newlyAwarded);
                $usersWithBadges++;
            }
            
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        $this->info("📊 SUMMARY");
        $this->info("Total users processed: {$users->count()}");
        $this->info("Users with new badges: {$usersWithBadges}");
        $this->info("Total badges awarded: {$totalAwarded}");
        
        if ($totalAwarded > 0 && !$dryRun) {
            $this->info('🎉 Badge check completed successfully!');
        }
    }
}
