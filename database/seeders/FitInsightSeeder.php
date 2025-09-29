<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FitInsight;
use App\Models\User;
use App\Models\Category;
use Carbon\Carbon;

class FitInsightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first user as author (or create one if none exists)
        $author = User::first();
        if (!$author) {
            $author = User::create([
                'name' => 'Admin User',
                'email' => 'admin@fitlley.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now()
            ]);
        }

        // Get or create a category for insights
        $category = Category::where('type', 'insight')->first();
        if (!$category) {
            $category = Category::create([
                'name' => 'Health & Wellness',
                'slug' => 'health-wellness',
                'type' => 'insight',
                'is_active' => true,
                'sort_order' => 1
            ]);
        }

        $insights = [
            [
                'title' => '10 Essential Tips for a Healthy Lifestyle',
                'excerpt' => 'Discover the fundamental principles of maintaining a healthy and balanced lifestyle.',
                'content' => 'Living a healthy lifestyle is more than just eating right and exercising. It encompasses a holistic approach to wellness that includes mental health, proper sleep, stress management, and building meaningful relationships. In this comprehensive guide, we will explore ten essential tips that can transform your daily routine and help you achieve optimal health and wellness.',
                'reading_time' => 5
            ],
            [
                'title' => 'The Science Behind Effective Workouts',
                'excerpt' => 'Understanding the physiological principles that make workouts truly effective.',
                'content' => 'Exercise science has evolved significantly over the past decades, providing us with valuable insights into how our bodies respond to different types of physical activity. This article delves into the scientific principles behind effective workouts, including the role of progressive overload, the importance of recovery, and how to optimize your training for maximum results.',
                'reading_time' => 8
            ],
            [
                'title' => 'Nutrition Myths Debunked: What Really Works',
                'excerpt' => 'Separating fact from fiction in the world of nutrition and diet advice.',
                'content' => 'The nutrition industry is filled with conflicting advice and misleading claims. From fad diets to miracle supplements, it can be challenging to distinguish between evidence-based recommendations and marketing hype. This article examines common nutrition myths and provides science-backed insights into what truly works for optimal health and performance.',
                'reading_time' => 6
            ],
            [
                'title' => 'Mental Health and Physical Fitness: The Connection',
                'excerpt' => 'Exploring the powerful relationship between mental well-being and physical activity.',
                'content' => 'The connection between mental health and physical fitness is profound and well-documented. Regular exercise has been shown to reduce symptoms of depression and anxiety, improve cognitive function, and enhance overall quality of life. This article explores the mechanisms behind this connection and provides practical strategies for using physical activity to support mental wellness.',
                'reading_time' => 7
            ],
            [
                'title' => 'Building Sustainable Fitness Habits',
                'excerpt' => 'Learn how to create lasting fitness routines that stick for the long term.',
                'content' => 'Creating sustainable fitness habits is one of the biggest challenges people face when trying to improve their health. Many start with enthusiasm but struggle to maintain consistency over time. This guide provides evidence-based strategies for building fitness habits that last, including goal setting, habit stacking, and overcoming common obstacles.',
                'reading_time' => 4
            ]
        ];

        foreach ($insights as $insightData) {
            FitInsight::create([
                'title' => $insightData['title'],
                'slug' => \Illuminate\Support\Str::slug($insightData['title']),
                'excerpt' => $insightData['excerpt'],
                'content' => $insightData['content'],
                'category_id' => $category->id,
                'author_id' => $author->id,
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(rand(1, 30)),
                'views_count' => rand(100, 1000),
                'likes_count' => rand(10, 100),
                'comments_count' => rand(5, 50),
                'shares_count' => rand(2, 25),
                'reading_time' => $insightData['reading_time']
            ]);
        }
    }
}
