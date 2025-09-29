<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\FitDoc;
use App\Models\FitDocEpisode;
use App\Models\FitLiveSession;
use App\Models\FitSeries;
use App\Models\FgSeriesEpisode;
use App\Models\FgCategory;
use App\Models\FgSubCategory;
use App\Models\FitCast;
use App\Models\FitNews;
use App\Models\FitInsight;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FittellyContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $this->createFitDocContent(); // Temporarily disabled due to type column constraint
        $this->createFitLiveSessions();
        $this->createFitGuideContent();
        $this->createFitCastContent();
        $this->createFitNewsContent();
        $this->createFitInsightContent();
    }

    /**
     * Create FitDoc content (movies and series)
     */
    private function createFitDocContent(): void
    {
        $fitDocs = [
            [
                'title' => 'The Science of Strength Training',
                'type' => 'M',
                'description' => 'An in-depth documentary exploring the science behind effective strength training and muscle building.',
                'language' => 'English',
                'cost' => 0,
                'release_date' => '2024-01-15',
                'duration_minutes' => 120,
                'feedback' => 4.8,
                'is_published' => true,
                'is_active' => true,
            ],
            [
                'title' => 'Yoga Masters: Ancient Wisdom',
                'type' => 'S',
                'description' => 'A comprehensive series featuring renowned yoga masters sharing ancient wisdom and modern practices.',
                'language' => 'English',
                'cost' => 299,
                'release_date' => '2024-02-01',
                'duration_minutes' => 0,
                'total_episodes' => 8,
                'feedback' => 4.9,
                'is_published' => true,
                'is_active' => true,
            ],
            [
                 'title' => 'HIIT Revolution',
                 'type' => 'M',
                'description' => 'Discover how High-Intensity Interval Training is revolutionizing fitness and transforming lives.',
                'language' => 'English',
                'cost' => 199,
                'release_date' => '2024-03-10',
                'duration_minutes' => 95,
                'feedback' => 4.7,
                'is_published' => true,
                'is_active' => true,
            ],
            [
                 'title' => 'Nutrition Decoded',
                 'type' => 'S',
                'description' => 'Unraveling the mysteries of nutrition science and its impact on athletic performance.',
                'language' => 'English',
                'cost' => 399,
                'release_date' => '2024-04-05',
                'duration_minutes' => 0,
                'total_episodes' => 6,
                'feedback' => 4.6,
                'is_published' => true,
                'is_active' => true,
            ],
            [
                 'title' => 'Mindful Movement',
                  'type' => 'M',
                'description' => 'Exploring the connection between mind and body through various movement practices.',
                'language' => 'English',
                'cost' => 0,
                'release_date' => '2024-05-20',
                'duration_minutes' => 110,
                'feedback' => 4.5,
                'is_published' => true,
                'is_active' => true,
            ],
            [
                 'title' => 'CrossFit Chronicles',
                  'type' => 'S',
                'description' => 'Following elite CrossFit athletes as they prepare for the ultimate fitness competition.',
                'language' => 'English',
                'cost' => 499,
                'release_date' => '2024-06-15',
                'duration_minutes' => 0,
                'total_episodes' => 10,
                'feedback' => 4.8,
                'is_published' => true,
                'is_active' => true,
            ],
            [
                 'title' => 'Recovery and Regeneration',
                  'type' => 'M',
                'description' => 'The importance of recovery in athletic performance and overall health.',
                'language' => 'English',
                'cost' => 149,
                'release_date' => '2024-07-01',
                'duration_minutes' => 85,
                'feedback' => 4.4,
                'is_published' => true,
                'is_active' => true,
            ],
            [
                 'title' => 'Functional Fitness Fundamentals',
                  'type' => 'S',
                'description' => 'Master the basics of functional movement patterns for everyday life.',
                'language' => 'English',
                'cost' => 299,
                'release_date' => '2024-07-20',
                'duration_minutes' => 0,
                'total_episodes' => 5,
                'feedback' => 4.7,
                'is_published' => true,
                'is_active' => true,
            ],
            [
                 'title' => 'The Psychology of Peak Performance',
                  'type' => 'M',
                'description' => 'Understanding the mental aspects that separate good athletes from great ones.',
                'language' => 'English',
                'cost' => 249,
                'release_date' => '2024-08-10',
                'duration_minutes' => 105,
                'feedback' => 4.9,
                'is_published' => true,
                'is_active' => true,
            ],
            [
                 'title' => 'Endurance Legends',
                  'type' => 'S',
                'description' => 'Stories of legendary endurance athletes and their training methodologies.',
                'language' => 'English',
                'cost' => 399,
                'release_date' => '2024-08-25',
                'duration_minutes' => 0,
                'total_episodes' => 7,
                'feedback' => 4.8,
                'is_published' => true,
                'is_active' => true,
            ],
        ];

        foreach ($fitDocs as $fitDocData) {
            $fitDoc = FitDoc::updateOrCreate(
                ['title' => $fitDocData['title']],
                $fitDocData
            );

            // Create episodes for shows
            if ($fitDoc->type === 'S' && $fitDoc->total_episodes > 0) {
                $this->createFitDocEpisodes($fitDoc);
            }
        }
    }

    /**
     * Create FitLive sessions for August 30th, 2024
     */
    private function createFitLiveSessions(): void
    {
        $baseDate = Carbon::create(2024, 8, 30); // August 30th, 2024
        
        $sessions = [
            [
                'title' => 'Morning Yoga Flow',
                'description' => 'Start your day with energizing yoga poses and breathing exercises.',
                'time' => '06:00',
                'duration' => 60,
                'chat_mode' => '1'
            ],
            [
                'title' => 'HIIT Cardio Blast',
                'description' => 'High-intensity interval training to boost your metabolism.',
                'time' => '07:30',
                'duration' => 45,
                'chat_mode' => '1'
            ],
            [
                'title' => 'Strength Training Fundamentals',
                'description' => 'Learn proper form and technique for basic strength exercises.',
                'time' => '09:00',
                'duration' => 50,
                 'chat_mode' => '1'
            ],
            [
                'title' => 'Pilates Core Power',
                'description' => 'Strengthen your core with targeted Pilates movements.',
                'time' => '10:30',
                'duration' => 45,
                 'chat_mode' => '1'
            ],
            [
                'title' => 'Functional Movement Patterns',
                'description' => 'Master everyday movements for better daily life performance.',
                'time' => '12:00',
                'duration' => 40,
                 'chat_mode' => '1'
            ],
            [
                'title' => 'Lunch Break Stretch',
                'description' => 'Quick stretching session perfect for your lunch break.',
                'time' => '13:00',
                'duration' => 30,
                 'chat_mode' => '1'
            ],
            [
                'title' => 'CrossFit WOD',
                'description' => 'Workout of the Day featuring varied functional movements.',
                'time' => '14:30',
                'duration' => 60,
                 'chat_mode' => '1'
            ],
            [
                'title' => 'Mindful Meditation',
                'description' => 'Guided meditation session for mental clarity and relaxation.',
                'time' => '16:00',
                'duration' => 30,
                'chat_mode' => '0'
            ],
            [
                'title' => 'Dance Fitness Party',
                'description' => 'Fun dance workout combining cardio with popular music.',
                'time' => '17:30',
                'duration' => 45,
                'chat_mode' => '1'
            ],
            [
                'title' => 'Olympic Weightlifting',
                'description' => 'Learn the technical lifts: snatch and clean & jerk.',
                'time' => '18:30',
                'duration' => 75,
                 'chat_mode' => '1'
            ],
            [
                'title' => 'Evening Yoga Restore',
                'description' => 'Gentle restorative yoga to unwind after a long day.',
                'time' => '19:45',
                'duration' => 60,
                'chat_mode' => '1'
            ],
            [
                'title' => 'Bodyweight Bootcamp',
                'description' => 'No equipment needed - full body workout using bodyweight.',
                'time' => '20:30',
                'duration' => 45,
                'chat_mode' => '1'
            ],
            [
                'title' => 'Flexibility & Mobility',
                'description' => 'Improve your range of motion and joint health.',
                'time' => '21:15',
                'duration' => 40,
                'chat_mode' => '1'
            ],
            [
                'title' => 'Late Night Calm Flow',
                'description' => 'Gentle movements to prepare your body for sleep.',
                'time' => '22:00',
                'duration' => 30,
                'chat_mode' => '0'
            ],
            [
                'title' => 'Nutrition Q&A Session',
                'description' => 'Interactive session about nutrition and healthy eating habits.',
                'time' => '15:30',
                'duration' => 45,
                'chat_mode' => '1'
            ]
        ];

        foreach ($sessions as $sessionData) {
            $scheduledAt = $baseDate->copy()->setTimeFromTimeString($sessionData['time']);
            
            FitLiveSession::updateOrCreate(
                [
                    'title' => $sessionData['title'],
                    'scheduled_at' => $scheduledAt
                ],
                [
                    'category_id' => $this->getRandomCategory()?->id,
                    'sub_category_id' => $this->getRandomSubCategory()?->id,
                    'instructor_id' => $this->getRandomInstructor()?->id,
                    'description' => $sessionData['description'],
                    'status' => 'scheduled',
                    'chat_mode' => $sessionData['chat_mode'],
                    'visibility' => 'public',
                    'recording_enabled' => true,
                    'livekit_room' => 'fitlive.' . Str::random(10)
                ]
            );
        }
    }

    /**
     * Create FitGuide series content
     */
    private function createFitGuideContent(): void
    {
        $fitGuideSeries = [
            [
                'title' => 'Beginner\'s Complete Fitness Journey',
                'description' => 'A comprehensive 12-week program designed for fitness beginners to build strength, endurance, and healthy habits.',
                'language' => 'English',
                'cost' => 199.00,
                'release_date' => '2024-01-01',
                'total_episodes' => 12,
                'feedback' => 4.8,
                'is_published' => true,
                'trailer_type' => 'youtube',
                'trailer_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'
            ],
            [
                'title' => 'Advanced Strength Training Mastery',
                'description' => 'Take your strength training to the next level with advanced techniques and progressive overload principles.',
                'language' => 'English',
                'cost' => 299.00,
                'release_date' => '2024-02-15',
                'total_episodes' => 10,
                'feedback' => 4.9,
                'is_published' => true,
                'trailer_type' => 'youtube',
                'trailer_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'
            ],
            [
                'title' => 'Yoga for Flexibility and Peace',
                'description' => 'Discover the transformative power of yoga through guided sessions focusing on flexibility and mental well-being.',
                'language' => 'English',
                'cost' => 149.00,
                'release_date' => '2024-03-01',
                'total_episodes' => 8,
                'feedback' => 4.7,
                'is_published' => true,
                'trailer_type' => 'youtube',
                'trailer_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'
            ],
            [
                'title' => 'HIIT Transformation Challenge',
                'description' => 'High-intensity interval training program designed to maximize fat loss and improve cardiovascular health.',
                'language' => 'English',
                'cost' => 249.00,
                'release_date' => '2024-04-10',
                'total_episodes' => 6,
                'feedback' => 4.6,
                'is_published' => true,
                'trailer_type' => 'youtube',
                'trailer_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'
            ],
            [
                'title' => 'Functional Movement Fundamentals',
                'description' => 'Learn essential movement patterns that translate to better performance in daily activities and sports.',
                'language' => 'English',
                'cost' => 179.00,
                'release_date' => '2024-05-05',
                'total_episodes' => 9,
                'feedback' => 4.8,
                'is_published' => true,
                'trailer_type' => 'youtube',
                'trailer_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'
            ],
            [
                'title' => 'Nutrition and Meal Planning Mastery',
                'description' => 'Complete guide to understanding nutrition science and creating sustainable meal plans for your fitness goals.',
                'language' => 'English',
                'cost' => 199.00,
                'release_date' => '2024-06-01',
                'total_episodes' => 7,
                'feedback' => 4.9,
                'is_published' => true,
                'trailer_type' => 'youtube',
                'trailer_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'
            ],
            [
                'title' => 'Mindfulness and Meditation for Athletes',
                'description' => 'Develop mental resilience and focus through mindfulness practices specifically designed for athletes.',
                'language' => 'English',
                'cost' => 129.00,
                'release_date' => '2024-07-15',
                'total_episodes' => 5,
                'feedback' => 4.5,
                'is_published' => true,
                'trailer_type' => 'youtube',
                'trailer_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'
            ],
            [
                'title' => 'Recovery and Injury Prevention',
                'description' => 'Essential strategies for recovery, injury prevention, and maintaining long-term fitness health.',
                'language' => 'English',
                'cost' => 169.00,
                'release_date' => '2024-08-01',
                'total_episodes' => 6,
                'feedback' => 4.7,
                'is_published' => true,
                'trailer_type' => 'youtube',
                'trailer_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'
            ]
        ];

        foreach ($fitGuideSeries as $seriesData) {
            $series = FitSeries::updateOrCreate(
                ['title' => $seriesData['title']],
                [
                    'slug' => Str::slug($seriesData['title']),
                    'fg_category_id' => 1, // Default category
                    'fg_sub_category_id' => 1, // Default subcategory
                    'description' => $seriesData['description'],
                    'language' => $seriesData['language'],
                    'cost' => $seriesData['cost'],
                    'release_date' => $seriesData['release_date'],
                    'total_episodes' => $seriesData['total_episodes'],
                    'feedback' => $seriesData['feedback'],
                    'is_published' => $seriesData['is_published'],
                    'trailer_type' => $seriesData['trailer_type'],
                    'trailer_url' => $seriesData['trailer_url']
                ]
            );

            // Create episodes for each series
            $this->createFitGuideEpisodes($series);
        }
    }

    /**
     * Create FitCast videos
     */
    private function createFitCastContent(): void
    {
        $fitCasts = [
            [
                'title' => '10-Minute Morning Energy Boost',
                'description' => 'Quick morning routine to energize your day with dynamic movements and stretches.',
                'duration' => 10,
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'is_active' => true,
                'is_featured' => true,
                'views_count' => rand(1000, 5000),
                'likes_count' => rand(100, 500),
                'published_at' => Carbon::now()->subDays(rand(1, 30))
            ],
            [
                'title' => 'Full Body HIIT Workout',
                'description' => 'Intense 20-minute high-intensity interval training session for maximum calorie burn.',
                'duration' => 20,
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'is_active' => true,
                'is_featured' => false,
                'views_count' => rand(2000, 8000),
                'likes_count' => rand(200, 800),
                'published_at' => Carbon::now()->subDays(rand(1, 30))
            ],
            [
                'title' => 'Beginner Yoga Flow',
                'description' => 'Gentle 15-minute yoga sequence perfect for beginners to improve flexibility.',
                'duration' => 15,
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'is_active' => true,
                'is_featured' => true,
                'views_count' => rand(1500, 6000),
                'likes_count' => rand(150, 600),
                'published_at' => Carbon::now()->subDays(rand(1, 30))
            ],
            [
                'title' => 'Core Strength Challenge',
                'description' => 'Targeted core workout to build abdominal strength and stability in just 12 minutes.',
                'duration' => 12,
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'is_active' => true,
                'is_featured' => false,
                'views_count' => rand(1200, 4500),
                'likes_count' => rand(120, 450),
                'published_at' => Carbon::now()->subDays(rand(1, 30))
            ],
            [
                'title' => 'Upper Body Strength Training',
                'description' => 'Build upper body strength with this comprehensive 25-minute workout routine.',
                'duration' => 25,
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'is_active' => true,
                'is_featured' => true,
                'views_count' => rand(2500, 7000),
                'likes_count' => rand(250, 700),
                'published_at' => Carbon::now()->subDays(rand(1, 30))
            ],
            [
                'title' => 'Cardio Dance Party',
                'description' => 'Fun and energetic dance workout that will get your heart pumping and spirits high.',
                'duration' => 18,
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'is_active' => true,
                'is_featured' => false,
                'views_count' => rand(3000, 9000),
                'likes_count' => rand(300, 900),
                'published_at' => Carbon::now()->subDays(rand(1, 30))
            ],
            [
                'title' => 'Lower Body Power Workout',
                'description' => 'Strengthen your legs and glutes with this intense lower body training session.',
                'duration' => 22,
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'is_active' => true,
                'is_featured' => true,
                'views_count' => rand(1800, 5500),
                'likes_count' => rand(180, 550),
                'published_at' => Carbon::now()->subDays(rand(1, 30))
            ],
            [
                'title' => 'Flexibility and Mobility',
                'description' => 'Improve your range of motion and reduce muscle tension with these mobility exercises.',
                'duration' => 14,
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'is_active' => true,
                'is_featured' => false,
                'views_count' => rand(1000, 4000),
                'likes_count' => rand(100, 400),
                'published_at' => Carbon::now()->subDays(rand(1, 30))
            ],
            [
                'title' => 'Pilates Core Fusion',
                'description' => 'Combine Pilates principles with core strengthening for a balanced workout.',
                'duration' => 16,
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'is_active' => true,
                'is_featured' => true,
                'views_count' => rand(1400, 4800),
                'likes_count' => rand(140, 480),
                'published_at' => Carbon::now()->subDays(rand(1, 30))
            ],
            [
                'title' => 'Functional Movement Training',
                'description' => 'Learn movement patterns that translate to better performance in daily activities.',
                'duration' => 19,
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'is_active' => true,
                'is_featured' => false,
                'views_count' => rand(1600, 5200),
                'likes_count' => rand(160, 520),
                'published_at' => Carbon::now()->subDays(rand(1, 30))
            ],
            [
                'title' => 'Meditation and Mindfulness',
                'description' => 'Guided meditation session to reduce stress and improve mental clarity.',
                'duration' => 12,
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'is_active' => true,
                'is_featured' => true,
                'views_count' => rand(2000, 6500),
                'likes_count' => rand(200, 650),
                'published_at' => Carbon::now()->subDays(rand(1, 30))
            ],
            [
                'title' => 'Recovery and Stretching',
                'description' => 'Essential recovery routine to help your muscles heal and prevent injury.',
                'duration' => 13,
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'is_active' => true,
                'is_featured' => false,
                'views_count' => rand(1100, 3800),
                'likes_count' => rand(110, 380),
                'published_at' => Carbon::now()->subDays(rand(1, 30))
            ]
        ];

        foreach ($fitCasts as $castData) {
            FitCast::updateOrCreate(
                ['title' => $castData['title']],
                [
                    'description' => $castData['description'],
                    'duration' => $castData['duration'],
                    'video_url' => $castData['video_url'],
                    'category_id' => $this->getRandomCategory()?->id,
                    'instructor_id' => $this->getRandomInstructor()?->id,
                    'is_active' => $castData['is_active'],
                    'is_featured' => $castData['is_featured'],
                    'views_count' => $castData['views_count'],
                    'likes_count' => $castData['likes_count'],
                    'published_at' => $castData['published_at']
                ]
            );
        }
    }

    /**
     * Create FitNews articles
     */
    private function createFitNewsContent(): void
    {
        $fitNews = [
            [
                'title' => 'Revolutionary Study Shows HIIT Benefits for Heart Health',
                'description' => 'New research reveals that high-intensity interval training can improve cardiovascular health more effectively than traditional cardio exercises.',
                'status' => 'ended',
                'started_at' => Carbon::now()->subDays(rand(1, 15)),
                'ended_at' => Carbon::now()->subDays(rand(1, 10)),
                'recording_enabled' => true,
                'recording_status' => 'completed'
            ],
            [
                'title' => 'Olympic Athletes Share Their Training Secrets',
                'description' => 'Exclusive interviews with Olympic gold medalists revealing their training methodologies and mental preparation techniques.',
                'status' => 'ended',
                'started_at' => Carbon::now()->subDays(rand(5, 20)),
                'ended_at' => Carbon::now()->subDays(rand(3, 15)),
                'recording_enabled' => true,
                'recording_status' => 'completed'
            ],
            [
                'title' => 'Breaking: New Fitness Technology Trends for 2024',
                'description' => 'Discover the latest fitness technology innovations that are revolutionizing how we approach health and wellness.',
                'status' => 'ended',
                'started_at' => Carbon::now()->subDays(rand(2, 12)),
                'ended_at' => Carbon::now()->subDays(rand(1, 8)),
                'recording_enabled' => true,
                'recording_status' => 'completed'
            ],
            [
                'title' => 'Nutrition Science: Plant-Based Diets for Athletes',
                'description' => 'Latest research on how plant-based nutrition can enhance athletic performance and recovery.',
                'status' => 'ended',
                'started_at' => Carbon::now()->subDays(rand(3, 18)),
                'ended_at' => Carbon::now()->subDays(rand(2, 12)),
                'recording_enabled' => true,
                'recording_status' => 'completed'
            ],
            [
                'title' => 'Mental Health and Fitness: The Connection Explained',
                'description' => 'Exploring the powerful relationship between physical exercise and mental well-being backed by scientific research.',
                'status' => 'ended',
                'started_at' => Carbon::now()->subDays(rand(4, 16)),
                'ended_at' => Carbon::now()->subDays(rand(2, 10)),
                'recording_enabled' => true,
                'recording_status' => 'completed'
            ],
            [
                'title' => 'Injury Prevention: Expert Tips from Sports Medicine',
                'description' => 'Leading sports medicine doctors share essential strategies for preventing common fitness-related injuries.',
                'status' => 'ended',
                'started_at' => Carbon::now()->subDays(rand(6, 22)),
                'ended_at' => Carbon::now()->subDays(rand(4, 18)),
                'recording_enabled' => true,
                'recording_status' => 'completed'
            ],
            [
                'title' => 'Fitness Industry Report: 2024 Trends and Predictions',
                'description' => 'Comprehensive analysis of current fitness industry trends and what to expect in the coming year.',
                'status' => 'ended',
                'started_at' => Carbon::now()->subDays(rand(1, 8)),
                'ended_at' => Carbon::now()->subDays(rand(1, 5)),
                'recording_enabled' => true,
                'recording_status' => 'completed'
            ],
            [
                'title' => 'Recovery Science: Sleep and Athletic Performance',
                'description' => 'New findings on how sleep quality directly impacts athletic performance and muscle recovery.',
                'status' => 'ended',
                'started_at' => Carbon::now()->subDays(rand(7, 25)),
                'ended_at' => Carbon::now()->subDays(rand(5, 20)),
                'recording_enabled' => true,
                'recording_status' => 'completed'
            ],
            [
                'title' => 'Functional Fitness: Training for Real Life',
                'description' => 'Why functional movement patterns are becoming the foundation of modern fitness programming.',
                'status' => 'ended',
                'started_at' => Carbon::now()->subDays(rand(3, 14)),
                'ended_at' => Carbon::now()->subDays(rand(2, 9)),
                'recording_enabled' => true,
                'recording_status' => 'completed'
            ],
            [
                'title' => 'Hydration and Performance: What Athletes Need to Know',
                'description' => 'Essential hydration strategies for optimal performance and recovery in different training conditions.',
                'status' => 'ended',
                'started_at' => Carbon::now()->subDays(rand(2, 11)),
                'ended_at' => Carbon::now()->subDays(rand(1, 7)),
                'recording_enabled' => true,
                'recording_status' => 'completed'
            ]
        ];

        foreach ($fitNews as $newsData) {
            FitNews::updateOrCreate(
                ['title' => $newsData['title']],
                [
                    'description' => $newsData['description'],
                    'status' => $newsData['status'],
                    'started_at' => $newsData['started_at'],
                    'ended_at' => $newsData['ended_at'],
                    'recording_enabled' => $newsData['recording_enabled'],
                    'recording_status' => $newsData['recording_status'],
                    'recording_duration' => rand(300, 1800), // 5-30 minutes
                    'recording_file_size' => rand(50000000, 200000000), // 50MB-200MB
                    'viewer_count' => rand(500, 5000),
                    'created_by' => $this->getRandomInstructor()?->id ?? 1
                ]
            );
        }
    }

    /**
     * Create FitInsight blog posts
     */
    private function createFitInsightContent(): void
    {
        $fitInsights = [
            [
                'title' => 'The Science Behind Progressive Overload',
                'excerpt' => 'Understanding how progressive overload drives muscle growth and strength gains.',
                'content' => 'Progressive overload is the fundamental principle that drives all fitness adaptations. This comprehensive guide explores the science behind why gradually increasing training demands leads to improved performance, muscle growth, and strength gains. We\'ll cover practical applications, common mistakes, and how to implement progressive overload in your training routine.',
                'reading_time' => 8,
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(rand(1, 30))
            ],
            [
                'title' => '10 Common Nutrition Myths Debunked',
                'excerpt' => 'Separating fact from fiction in the world of fitness nutrition.',
                'content' => 'The fitness industry is filled with nutrition myths that can derail your progress. From the myth that eating fat makes you fat to the belief that you need to eat every 2 hours to boost metabolism, we\'ll examine the science behind these claims and provide evidence-based recommendations for optimal nutrition.',
                'reading_time' => 12,
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(rand(1, 30))
            ],
            [
                'title' => 'Building Mental Resilience Through Fitness',
                'excerpt' => 'How physical training can strengthen your mental fortitude.',
                'content' => 'Physical fitness and mental resilience are deeply interconnected. This article explores how challenging workouts, goal setting, and overcoming physical barriers translate to improved mental toughness in all areas of life. Learn practical strategies to build both physical and mental strength simultaneously.',
                'reading_time' => 10,
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(rand(1, 30))
            ],
            [
                'title' => 'The Ultimate Guide to Recovery and Sleep',
                'excerpt' => 'Maximizing your gains through proper recovery protocols.',
                'content' => 'Recovery is where the magic happens. While training provides the stimulus for adaptation, it\'s during recovery that your body actually gets stronger. This comprehensive guide covers sleep optimization, active recovery techniques, nutrition for recovery, and how to structure your training to maximize adaptation.',
                'reading_time' => 15,
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(rand(1, 30))
            ],
            [
                'title' => 'Functional Movement Patterns for Daily Life',
                'excerpt' => 'Training movements that translate to real-world activities.',
                'content' => 'Functional fitness focuses on training movement patterns that directly translate to daily activities and sports performance. Learn about the seven fundamental movement patterns, how to assess your movement quality, and exercises to improve functional strength and mobility.',
                'reading_time' => 9,
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(rand(1, 30))
            ],
            [
                'title' => 'Understanding Your Metabolism: Facts vs Fiction',
                'excerpt' => 'The truth about metabolic rate and weight management.',
                'content' => 'Metabolism is one of the most misunderstood aspects of fitness and weight management. This article breaks down the components of metabolic rate, factors that influence it, and evidence-based strategies for optimizing your metabolism for your goals.',
                'reading_time' => 11,
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(rand(1, 30))
            ],
            [
                'title' => 'The Psychology of Habit Formation in Fitness',
                'excerpt' => 'How to build lasting fitness habits that stick.',
                'content' => 'Creating lasting change requires understanding the psychology of habit formation. This article explores the habit loop, how to design your environment for success, and practical strategies for building sustainable fitness habits that become second nature.',
                'reading_time' => 7,
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(rand(1, 30))
            ],
            [
                'title' => 'Injury Prevention: A Proactive Approach',
                'excerpt' => 'Strategies to stay healthy and injury-free in your fitness journey.',
                'content' => 'Prevention is always better than cure when it comes to injuries. This comprehensive guide covers movement screening, proper warm-up protocols, load management, and recovery strategies to keep you training consistently and injury-free.',
                'reading_time' => 13,
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(rand(1, 30))
            ],
            [
                'title' => 'The Role of Hydration in Athletic Performance',
                'excerpt' => 'How proper hydration impacts your training and recovery.',
                'content' => 'Hydration plays a crucial role in athletic performance, yet it\'s often overlooked. Learn about fluid balance, electrolyte needs, hydration strategies for different training conditions, and how to optimize your hydration for peak performance.',
                'reading_time' => 6,
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(rand(1, 30))
            ],
            [
                'title' => 'Strength Training for Beginners: A Complete Guide',
                'excerpt' => 'Everything you need to know to start your strength training journey.',
                'content' => 'Starting a strength training program can be intimidating, but it doesn\'t have to be. This beginner-friendly guide covers basic principles, essential exercises, program design, safety considerations, and how to progress systematically.',
                'reading_time' => 14,
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(rand(1, 30))
            ],
            [
                'title' => 'The Mind-Muscle Connection: Science and Application',
                'excerpt' => 'How focusing on muscle activation can improve your training.',
                'content' => 'The mind-muscle connection is more than just a bodybuilding concept. Research shows that focusing on the target muscle during exercise can improve activation and potentially enhance training outcomes. Learn how to develop and apply this skill.',
                'reading_time' => 8,
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(rand(1, 30))
            ],
            [
                'title' => 'Periodization: Planning Your Training for Success',
                'excerpt' => 'How to structure your training for optimal long-term progress.',
                'content' => 'Periodization is the systematic planning of athletic training. This article covers different periodization models, how to plan training phases, and how to adjust your program based on your goals and life circumstances.',
                'reading_time' => 12,
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(rand(1, 30))
            ],
            [
                'title' => 'Flexibility vs Mobility: Understanding the Difference',
                'excerpt' => 'Why both flexibility and mobility matter for optimal movement.',
                'content' => 'Flexibility and mobility are often used interchangeably, but they\'re different qualities that both contribute to optimal movement. Learn the distinctions, how to assess each, and targeted strategies for improvement.',
                'reading_time' => 9,
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(rand(1, 30))
            ],
            [
                'title' => 'The Science of Muscle Protein Synthesis',
                'excerpt' => 'Understanding how your body builds muscle at the cellular level.',
                'content' => 'Muscle protein synthesis is the process by which your body builds new muscle tissue. This deep dive explores the mechanisms involved, factors that influence the process, and practical applications for optimizing muscle growth.',
                'reading_time' => 11,
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(rand(1, 30))
            ],
            [
                'title' => 'Creating a Sustainable Fitness Lifestyle',
                'excerpt' => 'Building a fitness routine that fits your life long-term.',
                'content' => 'Sustainability is the key to long-term fitness success. This article provides practical strategies for creating a fitness routine that adapts to your changing life circumstances while maintaining consistency and progress toward your goals.',
                'reading_time' => 10,
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(rand(1, 30))
            ]
        ];

        foreach ($fitInsights as $insightData) {
            FitInsight::updateOrCreate(
                ['title' => $insightData['title']],
                [
                    'excerpt' => $insightData['excerpt'],
                    'content' => $insightData['content'],
                    'category_id' => $this->getRandomCategory()?->id,
                    'author_id' => $this->getRandomInstructor()?->id ?? 1,
                    'is_published' => $insightData['is_published'],
                    'published_at' => $insightData['published_at'],
                    'reading_time' => $insightData['reading_time'],
                    'views_count' => rand(500, 5000),
                    'likes_count' => rand(50, 500),
                    'shares_count' => rand(10, 100)
                ]
            );
        }
    }

    /**
     * Get random instructor user
     */
    private function getRandomInstructor()
    {
        return User::role('instructor')->inRandomOrder()->first() ?? User::first();
    }

    /**
     * Get random category
     */
    private function getRandomCategory()
    {
        return Category::inRandomOrder()->first();
    }

    /**
     * Get random subcategory
     */
    private function getRandomSubCategory()
    {
        return SubCategory::inRandomOrder()->first();
    }

    /**
     * Create episodes for FitDoc series
     */
    private function createFitDocEpisodes($fitDoc)
    {
        $episodeTitles = [
            'Yoga Masters: Ancient Wisdom' => [
                'Introduction to Ancient Yoga',
                'Breathing Techniques Mastery',
                'Asana Fundamentals',
                'Meditation and Mindfulness',
                'Advanced Poses and Transitions',
                'Yoga Philosophy and Ethics',
                'Healing Through Yoga',
                'The Modern Yoga Practice'
            ],
            'Nutrition Decoded' => [
                'Macronutrients Explained',
                'Micronutrients and Vitamins',
                'Pre and Post Workout Nutrition',
                'Hydration Science',
                'Supplements: What Works',
                'Meal Planning for Athletes'
            ],
            'CrossFit Chronicles' => [
                'The CrossFit Methodology',
                'Olympic Lifting Basics',
                'Metabolic Conditioning',
                'Gymnastics Movements',
                'Competition Preparation',
                'Recovery and Mobility',
                'Mental Toughness Training',
                'Nutrition for CrossFit',
                'Injury Prevention',
                'The CrossFit Games'
            ],
            'Functional Fitness Fundamentals' => [
                'Movement Patterns Basics',
                'Core Stability Training',
                'Balance and Coordination',
                'Strength Through Range of Motion',
                'Real-World Applications'
            ],
            'Endurance Legends' => [
                'Marathon Legends',
                'Cycling Champions',
                'Swimming Superstars',
                'Triathlon Titans',
                'Ultra-Endurance Athletes',
                'Training Methodologies',
                'Mental Endurance'
            ]
        ];

        $episodes = $episodeTitles[$fitDoc->title] ?? [];
        
        foreach ($episodes as $index => $episodeTitle) {
            FitDocEpisode::updateOrCreate(
                [
                    'fit_doc_id' => $fitDoc->id,
                    'episode_number' => $index + 1
                ],
                [
                    'title' => $episodeTitle,
                    'description' => 'Episode ' . ($index + 1) . ' of ' . $fitDoc->title . ': ' . $episodeTitle,
                    'duration_minutes' => rand(25, 45),
                    'is_published' => true,
                    'is_active' => true,
                    'video_type' => 'youtube',
                    'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'
                ]
            );
        }
    }

    /**
     * Create episodes for FitGuide series
     */
    private function createFitGuideEpisodes($series)
    {
        $episodeTitles = [
            'Beginner\'s Complete Fitness Journey' => [
                'Week 1: Foundation Building',
                'Week 2: Basic Strength Training',
                'Week 3: Cardio Introduction',
                'Week 4: Flexibility Focus',
                'Week 5: Compound Movements',
                'Week 6: Endurance Building',
                'Week 7: Core Strengthening',
                'Week 8: Balance and Coordination',
                'Week 9: Progressive Overload',
                'Week 10: Advanced Techniques',
                'Week 11: Goal Setting',
                'Week 12: Maintenance and Beyond'
            ],
            'Advanced Strength Training Mastery' => [
                'Progressive Overload Principles',
                'Periodization Strategies',
                'Advanced Compound Movements',
                'Accessory Exercise Selection',
                'Recovery and Deload Weeks',
                'Competition Preparation',
                'Plateau Breaking Techniques',
                'Advanced Programming',
                'Injury Prevention Strategies',
                'Peak Performance Protocols'
            ],
            'Yoga for Flexibility and Peace' => [
                'Foundation Poses and Breathing',
                'Sun Salutation Sequences',
                'Hip Opening Flow',
                'Backbend Progression',
                'Arm Balance Fundamentals',
                'Restorative Yoga Practice',
                'Meditation and Mindfulness',
                'Advanced Flow Sequences'
            ]
        ];

        $defaultEpisodes = [];
        for ($i = 1; $i <= $series->total_episodes; $i++) {
            $defaultEpisodes[] = 'Episode ' . $i . ': ' . $series->title;
        }

        $episodes = $episodeTitles[$series->title] ?? $defaultEpisodes;
        
        foreach ($episodes as $index => $episodeTitle) {
            if ($index >= $series->total_episodes) break;
            
            FgSeriesEpisode::updateOrCreate(
                [
                    'fg_series_id' => $series->id,
                    'episode_number' => $index + 1
                ],
                [
                    'title' => $episodeTitle,
                    'description' => 'Episode ' . ($index + 1) . ' of ' . $series->title . ': ' . $episodeTitle,
                    'duration_minutes' => rand(20, 60),
                    'is_published' => true,
                    'video_type' => 'youtube',
                    'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'
                ]
            );
        }
    }
}