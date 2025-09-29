<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FitArenaEvent;
use App\Models\FitLiveSession;
use App\Models\Category;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds for dummy data
     */
    public function run(): void
    {
        // Create FitArena Events (for fit_arena_live)
        $this->createFitArenaEvents();
        
        // Create categories if they don't exist
        $this->createCategories();
        
        // Create live sessions for FitExpert Live
        $this->createExpertLiveSessions();
        
        // Create recorded sessions for Fit Guide
        $this->createFitGuideSessions();
    }

    private function createFitArenaEvents(): void
    {
        $events = [
            [
                'title' => 'Summer Fitness Challenge 2024',
                'description' => 'A 7-day intensive fitness challenge featuring top trainers from around the world.',
                'start_date' => Carbon::now()->addDays(2),
                'end_date' => Carbon::now()->addDays(9),
                'banner_image' => 'https://picsum.photos/800/400?random=1',
                'location' => 'Virtual - Global',
                'status' => 'upcoming',
                'visibility' => 'public',
                'organizers' => [
                    ['name' => 'FitArena Team', 'role' => 'Event Host'],
                    ['name' => 'Mike Fitness Pro', 'role' => 'Lead Trainer']
                ],
                'expected_viewers' => 5000,
                'is_featured' => true,
            ],
            [
                'title' => 'Live Yoga Marathon',
                'description' => '24-hour continuous yoga sessions with different instructors.',
                'start_date' => Carbon::now()->subDays(1),
                'end_date' => Carbon::now()->addDays(1),
                'banner_image' => 'https://picsum.photos/800/400?random=2',
                'location' => 'Virtual - Worldwide',
                'status' => 'live',
                'visibility' => 'public',
                'organizers' => [
                    ['name' => 'Zen Masters', 'role' => 'Yoga Collective']
                ],
                'expected_viewers' => 3000,
                'peak_viewers' => 2500,
                'is_featured' => true,
            ],
            [
                'title' => 'HIIT Championship',
                'description' => 'High-intensity interval training competition with cash prizes.',
                'start_date' => Carbon::now()->addDays(7),
                'end_date' => Carbon::now()->addDays(8),
                'banner_image' => 'https://picsum.photos/800/400?random=3',
                'location' => 'Virtual Arena',
                'status' => 'upcoming',
                'visibility' => 'public',
                'organizers' => [
                    ['name' => 'HIIT Masters', 'role' => 'Competition Organizer']
                ],
                'expected_viewers' => 8000,
                'is_featured' => false,
            ]
        ];

        foreach ($events as $eventData) {
            FitArenaEvent::firstOrCreate(
                ['title' => $eventData['title']],
                $eventData
            );
        }
    }

    private function createCategories(): void
    {
        $categories = [
            ['name' => 'Fitness', 'slug' => 'fitness'],
            ['name' => 'Yoga', 'slug' => 'yoga'],
            ['name' => 'HIIT', 'slug' => 'hiit'],
            ['name' => 'Cardio', 'slug' => 'cardio'],
            ['name' => 'Strength Training', 'slug' => 'strength-training'],
            ['name' => 'Nutrition', 'slug' => 'nutrition'],
            ['name' => 'Mental Health', 'slug' => 'mental-health'],
        ];

        foreach ($categories as $index => $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                [
                    'name' => $category['name'],
                    'sort_order' => $index + 1,
                ]
            );
        }
    }

    private function createExpertLiveSessions(): void
    {
        $fitnessCategory = Category::where('slug', 'fitness')->first();
        
        if (!$fitnessCategory) {
            return;
        }

        $expertSessions = [
            [
                'title' => 'Expert Nutrition Masterclass',
                'description' => 'Advanced nutrition strategies with certified nutritionist.',
                'category_id' => $fitnessCategory->id,
                'instructor_id' => 1, // Assuming instructor exists
                'scheduled_at' => Carbon::now()->addHours(2),
                'status' => 'scheduled',
                'visibility' => 'public',
                'chat_mode' => 'during',
                'banner_image' => 'https://picsum.photos/600/300?random=4',
            ],
            [
                'title' => 'Advanced Strength Training Techniques',
                'description' => 'Professional strength training methods for advanced athletes.',
                'category_id' => $fitnessCategory->id,
                'instructor_id' => 1,
                'scheduled_at' => Carbon::now()->addDays(1),
                'status' => 'scheduled',
                'visibility' => 'public',
                'chat_mode' => 'during',
                'banner_image' => 'https://picsum.photos/600/300?random=5',
            ]
        ];

        foreach ($expertSessions as $sessionData) {
            FitLiveSession::firstOrCreate(
                ['title' => $sessionData['title']],
                $sessionData
            );
        }
    }

    private function createFitGuideSessions(): void
    {
        $yogaCategory = Category::where('slug', 'yoga')->first();
        
        if (!$yogaCategory) {
            return;
        }

        $guideSessions = [
            [
                'title' => 'Beginner Yoga Flow Guide',
                'description' => 'Complete beginner guide to yoga flow sequences.',
                'category_id' => $yogaCategory->id,
                'instructor_id' => 1,
                'scheduled_at' => Carbon::now()->subDays(7),
                'started_at' => Carbon::now()->subDays(7),
                'ended_at' => Carbon::now()->subDays(7)->addHour(),
                'status' => 'ended',
                'visibility' => 'public',
                'recording_enabled' => true,
                'recording_url' => 'https://example.com/recordings/yoga-guide-1.mp4',
                'mp4_path' => '/storage/recordings/yoga-guide-1.mp4',
                'banner_image' => 'https://picsum.photos/600/300?random=6',
            ],
            [
                'title' => 'Core Strength Building Guide',
                'description' => 'Step-by-step guide to building core strength.',
                'category_id' => $fitnessCategory->id ?? $yogaCategory->id,
                'instructor_id' => 1,
                'scheduled_at' => Carbon::now()->subDays(5),
                'started_at' => Carbon::now()->subDays(5),
                'ended_at' => Carbon::now()->subDays(5)->addMinutes(45),
                'status' => 'ended',
                'visibility' => 'public',
                'recording_enabled' => true,
                'recording_url' => 'https://example.com/recordings/core-guide-1.mp4',
                'mp4_path' => '/storage/recordings/core-guide-1.mp4',
                'banner_image' => 'https://picsum.photos/600/300?random=7',
            ],
            [
                'title' => 'Flexibility and Mobility Guide',
                'description' => 'Comprehensive guide to improving flexibility and mobility.',
                'category_id' => $yogaCategory->id,
                'instructor_id' => 1,
                'scheduled_at' => Carbon::now()->subDays(3),
                'started_at' => Carbon::now()->subDays(3),
                'ended_at' => Carbon::now()->subDays(3)->addMinutes(50),
                'status' => 'ended',
                'visibility' => 'public',
                'recording_enabled' => true,
                'recording_url' => 'https://example.com/recordings/flexibility-guide-1.mp4',
                'mp4_path' => '/storage/recordings/flexibility-guide-1.mp4',
                'banner_image' => 'https://picsum.photos/600/300?random=8',
            ]
        ];

        foreach ($guideSessions as $sessionData) {
            FitLiveSession::firstOrCreate(
                ['title' => $sessionData['title']],
                $sessionData
            );
        }
    }
}
