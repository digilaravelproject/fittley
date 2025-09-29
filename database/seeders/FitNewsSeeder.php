<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FitNews;
use App\Models\User;

class FitNewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user
        $admin = User::where('email', 'admin@fitlley.com')->first();
        
        if (!$admin) {
            $this->command->error('Admin user not found. Please run AdminSeeder first.');
            return;
        }

        $newsStreams = [
            [
                'title' => 'Morning Fitness News Update',
                'description' => 'Get the latest fitness news, trends, and health updates to start your day right. Join us for breaking news in the fitness industry.',
                'status' => 'draft',
                'recording_enabled' => true,
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Weekly Nutrition Roundup',
                'description' => 'Comprehensive weekly nutrition news covering the latest research, diet trends, and healthy eating tips from experts worldwide.',
                'status' => 'scheduled',
                'scheduled_at' => now()->addHours(2),
                'recording_enabled' => true,
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Live: Breaking Fitness Industry News',
                'description' => 'Breaking news coverage of major developments in the fitness industry. Stay updated with real-time information.',
                'status' => 'live',
                'started_at' => now()->subMinutes(30),
                'viewer_count' => 45,
                'recording_enabled' => true,
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Sports Science Weekly',
                'description' => 'Deep dive into the latest sports science research, performance optimization techniques, and athletic training innovations.',
                'status' => 'ended',
                'started_at' => now()->subHours(2),
                'ended_at' => now()->subHour(),
                'viewer_count' => 0,
                'recording_enabled' => true,
                'recording_url' => 'https://example.com/recordings/sports-science-weekly.mp4',
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Fitness Equipment Reviews Live',
                'description' => 'Live reviews and demonstrations of the latest fitness equipment, gear recommendations, and buyer guides.',
                'status' => 'draft',
                'recording_enabled' => false,
                'created_by' => $admin->id,
            ],
        ];

        foreach ($newsStreams as $streamData) {
            $fitNews = FitNews::create($streamData);
            
            // Generate channel name
            $fitNews->update([
                'channel_name' => $fitNews->generateChannelName()
            ]);
            
            $this->command->info("Created FitNews stream: {$fitNews->title}");
        }

        $this->command->info('FitNews seeder completed successfully!');
    }
}
