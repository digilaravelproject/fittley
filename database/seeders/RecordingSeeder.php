<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FitNews;
use App\Models\FitLiveSession;
use App\Models\User;
use Carbon\Carbon;

class RecordingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin and instructor users
        $admin = User::where('email', 'admin@fitlley.com')->first();
        $instructor = User::role('instructor')->first();

        if (!$admin || !$instructor) {
            $this->command->warn('Admin or instructor user not found. Please run UserSeeder first.');
            return;
        }

        // Create FitNews recordings
        $fitNewsRecordings = [
            [
                'title' => 'Morning Fitness News Update',
                'description' => 'Daily fitness tips and workout routines for a healthy morning start.',
                'status' => 'ended',
                'recording_enabled' => true,
                'recording_status' => 'completed',
                'recording_id' => 'rec_fitnews_001_' . time(),
                'recording_url' => storage_path('recordings/fitnews_morning_update.mp4'),
                'recording_duration' => 1800, // 30 minutes
                'recording_file_size' => 256000000, // 256 MB
                'viewer_count' => 145,
                'scheduled_at' => Carbon::now()->subDays(2)->setTime(8, 0),
                'started_at' => Carbon::now()->subDays(2)->setTime(8, 0),
                'ended_at' => Carbon::now()->subDays(2)->setTime(8, 30),
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Weekly Nutrition Guide',
                'description' => 'Comprehensive guide to healthy eating and meal planning.',
                'status' => 'ended',
                'recording_enabled' => true,
                'recording_status' => 'completed',
                'recording_id' => 'rec_fitnews_002_' . time(),
                'recording_url' => storage_path('recordings/fitnews_nutrition_guide.mp4'),
                'recording_duration' => 2700, // 45 minutes
                'recording_file_size' => 384000000, // 384 MB
                'viewer_count' => 89,
                'scheduled_at' => Carbon::now()->subDays(5)->setTime(15, 0),
                'started_at' => Carbon::now()->subDays(5)->setTime(15, 0),
                'ended_at' => Carbon::now()->subDays(5)->setTime(15, 45),
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Fitness Equipment Reviews',
                'description' => 'In-depth review of the latest fitness equipment and gear.',
                'status' => 'ended',
                'recording_enabled' => true,
                'recording_status' => 'completed',
                'recording_id' => 'rec_fitnews_003_' . time(),
                'recording_url' => storage_path('recordings/fitnews_equipment_reviews.mp4'),
                'recording_duration' => 3600, // 60 minutes
                'recording_file_size' => 512000000, // 512 MB
                'viewer_count' => 203,
                'scheduled_at' => Carbon::now()->subDays(7)->setTime(19, 0),
                'started_at' => Carbon::now()->subDays(7)->setTime(19, 0),
                'ended_at' => Carbon::now()->subDays(7)->setTime(20, 0),
                'created_by' => $admin->id,
            ],
        ];

        foreach ($fitNewsRecordings as $recording) {
            $fitNews = FitNews::create($recording);
            $fitNews->update(['channel_name' => $fitNews->generateChannelName()]);
        }

        // Get categories for FitLive sessions
        $categories = \App\Models\Category::with('subCategories')->get();
        
        if ($categories->isEmpty()) {
            $this->command->warn('No categories found. Please run FitLiveSeeder first.');
            return;
        }

        // Create FitLive session recordings
        $fitLiveRecordings = [
            [
                'title' => 'High-Intensity Interval Training',
                'description' => 'Full-body HIIT workout for maximum calorie burn and strength building.',
                'category_id' => $categories->first()->id,
                'sub_category_id' => $categories->first()->subCategories->first()?->id,
                'instructor_id' => $instructor->id,
                'status' => 'ended',
                'chat_mode' => 'during',
                'visibility' => 'public',
                'recording_enabled' => true,
                'recording_status' => 'completed',
                'recording_id' => 'rec_fitlive_001_' . time(),
                'recording_url' => storage_path('recordings/fitlive_hiit_workout.mp4'),
                'recording_duration' => 2400, // 40 minutes
                'recording_file_size' => 320000000, // 320 MB
                'viewer_peak' => 67,
                'scheduled_at' => Carbon::now()->subDays(3)->setTime(18, 0),
                'started_at' => Carbon::now()->subDays(3)->setTime(18, 0),
                'ended_at' => Carbon::now()->subDays(3)->setTime(18, 40),
            ],
            [
                'title' => 'Yoga Flow for Beginners',
                'description' => 'Gentle yoga flow perfect for beginners and stress relief.',
                'category_id' => $categories->skip(1)->first()?->id ?? $categories->first()->id,
                'sub_category_id' => null,
                'instructor_id' => $instructor->id,
                'status' => 'ended',
                'chat_mode' => 'during',
                'visibility' => 'public',
                'recording_enabled' => true,
                'recording_status' => 'completed',
                'recording_id' => 'rec_fitlive_002_' . time(),
                'recording_url' => storage_path('recordings/fitlive_yoga_flow.mp4'),
                'recording_duration' => 3000, // 50 minutes
                'recording_file_size' => 400000000, // 400 MB
                'viewer_peak' => 124,
                'scheduled_at' => Carbon::now()->subDays(6)->setTime(7, 0),
                'started_at' => Carbon::now()->subDays(6)->setTime(7, 0),
                'ended_at' => Carbon::now()->subDays(6)->setTime(7, 50),
            ],
            [
                'title' => 'Strength Training Fundamentals',
                'description' => 'Learn proper form and technique for basic strength training exercises.',
                'category_id' => $categories->first()->id,
                'sub_category_id' => $categories->first()->subCategories->skip(1)->first()?->id,
                'instructor_id' => $instructor->id,
                'status' => 'ended',
                'chat_mode' => 'during',
                'visibility' => 'public',
                'recording_enabled' => true,
                'recording_status' => 'completed',
                'recording_id' => 'rec_fitlive_003_' . time(),
                'recording_url' => storage_path('recordings/fitlive_strength_training.mp4'),
                'recording_duration' => 2700, // 45 minutes
                'recording_file_size' => 360000000, // 360 MB
                'viewer_peak' => 98,
                'scheduled_at' => Carbon::now()->subDays(8)->setTime(16, 30),
                'started_at' => Carbon::now()->subDays(8)->setTime(16, 30),
                'ended_at' => Carbon::now()->subDays(8)->setTime(17, 15),
            ],
            [
                'title' => 'Cardio Dance Party',
                'description' => 'Fun and energetic dance workout to your favorite beats.',
                'category_id' => $categories->skip(2)->first()?->id ?? $categories->first()->id,
                'sub_category_id' => null,
                'instructor_id' => $instructor->id,
                'status' => 'ended',
                'chat_mode' => 'during',
                'visibility' => 'public',
                'recording_enabled' => true,
                'recording_status' => 'completed',
                'recording_id' => 'rec_fitlive_004_' . time(),
                'recording_url' => storage_path('recordings/fitlive_cardio_dance.mp4'),
                'recording_duration' => 1800, // 30 minutes
                'recording_file_size' => 240000000, // 240 MB
                'viewer_peak' => 156,
                'scheduled_at' => Carbon::now()->subDays(10)->setTime(20, 0),
                'started_at' => Carbon::now()->subDays(10)->setTime(20, 0),
                'ended_at' => Carbon::now()->subDays(10)->setTime(20, 30),
            ],
        ];

        foreach ($fitLiveRecordings as $recording) {
            FitLiveSession::create($recording);
        }

        // Create recordings directory if it doesn't exist
        $recordingsPath = storage_path('recordings');
        if (!file_exists($recordingsPath)) {
            mkdir($recordingsPath, 0755, true);
        }

        // Create placeholder video files (empty files for demo)
        $videoFiles = [
            'fitnews_morning_update.mp4',
            'fitnews_nutrition_guide.mp4',
            'fitnews_equipment_reviews.mp4',
            'fitlive_hiit_workout.mp4',
            'fitlive_yoga_flow.mp4',
            'fitlive_strength_training.mp4',
            'fitlive_cardio_dance.mp4',
        ];

        foreach ($videoFiles as $file) {
            $filePath = $recordingsPath . '/' . $file;
            if (!file_exists($filePath)) {
                file_put_contents($filePath, ''); // Create empty file
            }
        }

        $this->command->info('Recording seeder completed successfully!');
        $this->command->info('Created ' . count($fitNewsRecordings) . ' FitNews recordings');
        $this->command->info('Created ' . count($fitLiveRecordings) . ' FitLive session recordings');
        $this->command->info('Created placeholder video files in storage/recordings/');
    }
}
