<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\ReferralCode;

class CreateUserReferralCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create-referral-codes {--force : Force update existing codes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create referral codes for all users who do not have them';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating referral codes for users...');
        
        $force = $this->option('force');
        
        $users = User::when(!$force, function ($query) {
            return $query->whereDoesntHave('referralCode');
        })->get();
        
        if ($users->isEmpty()) {
            $this->info('All users already have referral codes.');
            return;
        }
        
        $this->info("Processing {$users->count()} users...");
        
        $bar = $this->output->createProgressBar($users->count());
        $bar->start();
        
        $created = 0;
        $updated = 0;
        
        foreach ($users as $user) {
            try {
                if ($force && $user->referralCode) {
                    // Update existing code
                    $user->updateReferralDiscount();
                    $updated++;
                } else {
                    // Create new code
                    $user->createDefaultReferralCode();
                    $created++;
                }
            } catch (\Exception $e) {
                $this->error("Failed to process user {$user->id}: " . $e->getMessage());
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        
        $this->info("Created {$created} new referral codes.");
        if ($force) {
            $this->info("Updated {$updated} existing referral codes.");
        }
        
        $this->info('Done!');
    }
}
