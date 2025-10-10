<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\FitNews;
use Carbon\Carbon;

class CreateDailyFitNewsSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * Usage:
     *  php artisan fitnews:create-daily-news
     *  php artisan fitnews:create-daily-news --date=2025-10-06
     *  php artisan fitnews:create-daily-news --dry-run
     */
    protected $signature = 'fitnews:create-daily-news
        {--date= : Create Fit News for specific date (Y-m-d format)}
        {--dry-run : Show what would be created without saving}';

    /**
     * The console command description.
     */
    protected $description = 'Create daily Fit News sessions at 09:00 and 18:00 with scheduled status';

    /**
     * Fixed daily times for Fit News (24-hour format).
     */
    private array $times = ['09:00', '18:00'];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🗞  Starting Daily Fit News Sessions Creation...');
        $this->newLine();

        // Target date (default today)
        $dateOpt = $this->option('date');
        $targetDate = $dateOpt ? Carbon::createFromFormat('Y-m-d', $dateOpt) : Carbon::today();

        $dryRun = (bool) $this->option('dry-run');
        if ($dryRun) {
            $this->warn('🧪 DRY RUN MODE — no records will be saved');
            $this->newLine();
        }

        $this->info("Creating Fit News for: {$targetDate->format('Y-m-d (l)')}");
        $this->newLine();

        // Get Admin as creator
        $admin = User::whereHas('roles', fn($q) => $q->where('name', 'admin'))->first();
        if (!$admin) {
            $this->error('❌ No admin user found!');
            return 1;
        }

        $this->info("✅ Using admin: {$admin->name} (ID: {$admin->id})");
        $this->newLine();

        $total = 0;
        $created = 0;
        $skipped = 0;

        foreach ($this->times as $k => $time) {
            $total++;
            $scheduledAt = $targetDate->copy()->setTimeFromTimeString($time);

            // Skip if already exists for the same datetime
            $exists = FitNews::where('scheduled_at', $scheduledAt)->first();
            if ($exists) {
                $this->line("  ⏩ {$time} — Already exists (ID: {$exists->id})");
                $skipped++;
                continue;
            }

            // Prepare payload (make sure your FitNews model has $fillable for these)
            if ($k == 0) {
                $title = "Live at 9AM";
                $news_img = 'fitnews/thumbnails/MndlIdUxwR7bsWZSAuRbdD4hwIHxvlOVXgNlUj9q.jpg';
            } else {
                $title = "Live at 6PM";
                $news_img = 'fitnews/thumbnails/jnMaFDW2FU54TAUo4GWlCIlGUwWK7ZNjiMRwPwW1.jpg';
            }

            $payload = [
                'title'            => $title,
                'description'      => "Your daily Fit News bulletin scheduled at {$scheduledAt->format('h:i A')}.",
                'thumbnail'        => $news_img,
                'status'           => 'scheduled', // enum: draft|scheduled|live|ended
                'channel_name'     => FitNews::generateChannelName($scheduledAt),
                'is_published'     => 1,
                'published_at'     => $scheduledAt,
                'scheduled_at'     => $scheduledAt,
                'recording_enabled' => false,
                'viewer_count'     => 0,
                'views_count'      => 0,
                'likes_count'      => 0,
                'comments_count'   => 0,
                'shares_count'     => 0,
                'created_by'       => $admin->id,
            ];

            if ($dryRun) {
                $this->line("  🔸 {$time} — Would create Fit News (creator: {$admin->name})");
                $created++;
                continue;
            }

            try {
                $news = FitNews::create($payload);
                $this->line("  ✅ {$time} — Created (ID: {$news->id})");
                $created++;
            } catch (\Throwable $e) {
                $this->error("  ❌ {$time} — Failed: " . $e->getMessage());
            }
        }

        $this->newLine();
        $this->info('📊 SUMMARY');
        $this->info("Date: {$targetDate->format('Y-m-d (l)')}");
        $this->info("Total times processed: {$total}");
        $this->info(($dryRun ? 'Would create' : 'Created') . ": {$created}");
        $this->info("Skipped (already exist): {$skipped}");

        if ($created > 0 && !$dryRun) {
            $this->newLine();
            $this->info('🎉 Daily Fit News sessions created successfully!');
        }

        return 0;
    }
}
