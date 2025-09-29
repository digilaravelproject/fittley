<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\FitLiveSession;
use App\Models\User;
use Carbon\Carbon;

class CreateDailyFitLiveSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fitlive:create-daily-sessions {--date= : Create sessions for specific date (Y-m-d format)} {--dry-run : Show what would be created without saving}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create daily FitLive sessions for Fit Daily Live category with predefined schedules';

    /**
     * Daily schedules for each subcategory
     * Times in 24-hour format
     */
    private array $schedules = [
        'Yoga' => ['05:00', '06:00', '07:00', '08:00', '17:00', '18:00', '19:00', '20:00'],
        'Strength &  conditioning' => ['06:00', '07:00', '08:00', '09:00', '10:00', '16:00', '17:00', '18:00', '19:00', '20:00'],
        'HIIT' => ['06:00', '07:00', '08:00', '09:00', '10:00', '16:00', '17:00', '18:00', '19:00', '20:00'],
        'Zumba' => ['06:00', '07:00', '08:00', '18:00', '19:00', '20:00'],
        'Meditation' => ['05:00', '06:00', '07:00', '08:00', '20:00', '20:30', '21:00', '21:30']
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Starting Daily FitLive Sessions Creation...');
        $this->newLine();

        // Get target date
        $dateOption = $this->option('date');
        $targetDate = $dateOption ? Carbon::createFromFormat('Y-m-d', $dateOption) : Carbon::today();
        
        $dryRun = $this->option('dry-run');
        
        if ($dryRun) {
            $this->warn('🧪 DRY RUN MODE - No sessions will be saved');
            $this->newLine();
        }

        $this->info("Creating sessions for: {$targetDate->format('Y-m-d (l)')}");
        $this->newLine();

        // Get Fit Daily Live category
        $category = Category::where('name', 'Fit Daily Live')->first();
        
        if (!$category) {
            $this->error('❌ "Fit Daily Live" category not found!');
            return 1;
        }

        $this->info("✅ Found category: {$category->name} (ID: {$category->id})");

        // Get subcategories
        $subCategories = $category->subCategories()->get()->keyBy('name');
        
        if ($subCategories->isEmpty()) {
            $this->error('❌ No subcategories found for Fit Daily Live!');
            return 1;
        }

        $this->info("✅ Found {$subCategories->count()} subcategories");

        // Get admin user as the host for all daily sessions
        $admin = User::whereHas('roles', function($query) {
            $query->where('name', 'admin');
        })->first();

        if (!$admin) {
            $this->error('❌ No admin user found!');
            return 1;
        }

        $this->info("✅ Found admin host: {$admin->name} (ID: {$admin->id})");
        $this->newLine();

        $totalSessions = 0;
        $createdSessions = 0;
        $skippedSessions = 0;

        // Create sessions for each subcategory
        foreach ($this->schedules as $subCategoryName => $times) {
            $subCategory = $subCategories->get($subCategoryName);
            
            if (!$subCategory) {
                $this->warn("⚠️  Subcategory '{$subCategoryName}' not found, skipping...");
                continue;
            }

            $this->info("📅 Processing {$subCategoryName} ({$subCategory->id}) - " . count($times) . " sessions");

            foreach ($times as $time) {
                $totalSessions++;
                
                $scheduledDateTime = $targetDate->copy()->setTimeFromTimeString($time);
                
                // Check if session already exists
                $existingSession = FitLiveSession::where('category_id', $category->id)
                    ->where('sub_category_id', $subCategory->id)
                    ->where('scheduled_at', $scheduledDateTime)
                    ->where('session_type', 'daily')
                    ->first();

                if ($existingSession) {
                    $this->line("  ⏩ {$time} - Already exists (ID: {$existingSession->id})");
                    $skippedSessions++;
                    continue;
                }

                // Use admin as the host for all daily sessions
                $instructor = $admin;

                $sessionData = [
                    'category_id' => $category->id,
                    'sub_category_id' => $subCategory->id,
                    'instructor_id' => $instructor->id,
                    'title' => "Daily {$subCategoryName} Session",
                    'description' => "Daily {$subCategoryName} session from {$scheduledDateTime->format('H:i')}. Join us for an energizing {$subCategoryName} workout!",
                    'banner_image' => '/storage/app/public/default-profile1.png',
                    'scheduled_at' => $scheduledDateTime,
                    'status' => 'scheduled',
                    'chat_mode' => 'during',
                    'session_type' => 'daily',
                    'visibility' => 'public',
                    'recording_enabled' => true,
                ];

                if (!$dryRun) {
                    try {
                        $session = FitLiveSession::create($sessionData);
                        $this->line("  ✅ {$time} - Created (ID: {$session->id}) - Host: {$instructor->name}");
                        $createdSessions++;
                    } catch (\Exception $e) {
                        $this->error("  ❌ {$time} - Failed: " . $e->getMessage());
                    }
                } else {
                    $this->line("  🔸 {$time} - Would create - Host: {$instructor->name}");
                    $createdSessions++;
                }
            }
            
            $this->newLine();
        }

        // Summary
        $this->info('📊 SUMMARY');
        $this->info("Date: {$targetDate->format('Y-m-d (l)')}");
        $this->info("Total sessions processed: {$totalSessions}");
        
        if ($dryRun) {
            $this->info("Sessions that would be created: {$createdSessions}");
        } else {
            $this->info("Sessions created: {$createdSessions}");
        }
        
        $this->info("Sessions skipped (already exist): {$skippedSessions}");
        
        if ($createdSessions > 0 && !$dryRun) {
            $this->newLine();
            $this->info('🎉 Daily FitLive sessions created successfully!');
        }

        return 0;
    }
}
