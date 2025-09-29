<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CommunityCategory;
use App\Models\CommunityGroup;
use App\Models\Badge;
use App\Models\CommunityPost;
use App\Models\User;
use App\Models\GroupMember;
use App\Models\UserProfile;
use Illuminate\Support\Str;

class CommunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Community Categories
        $categories = [
            [
                'name' => 'Fitness Tips',
                'description' => 'Share your best fitness tips and advice',
                'color' => '#FF6B6B',
                'icon' => '💪',
                'order' => 1
            ],
            [
                'name' => 'Nutrition',
                'description' => 'Healthy eating and nutrition discussions',
                'color' => '#4ECDC4',
                'icon' => '🥗',
                'order' => 2
            ],
            [
                'name' => 'Workout Routines',
                'description' => 'Share and discover workout routines',
                'color' => '#45B7D1',
                'icon' => '🏋️',
                'order' => 3
            ],
            [
                'name' => 'Mental Health',
                'description' => 'Mental wellness and mindfulness discussions',
                'color' => '#96CEB4',
                'icon' => '🧘',
                'order' => 4
            ],
            [
                'name' => 'Success Stories',
                'description' => 'Share your fitness journey and achievements',
                'color' => '#FECA57',
                'icon' => '🏆',
                'order' => 5
            ],
        ];

        foreach ($categories as $categoryData) {
            CommunityCategory::create([
                'name' => $categoryData['name'],
                'slug' => Str::slug($categoryData['name']),
                'description' => $categoryData['description'],
                'color' => $categoryData['color'],
                'icon' => $categoryData['icon'],
                'order' => $categoryData['order'],
                'is_active' => true,
            ]);
        }

        $fitnessCategory = CommunityCategory::where('name', 'Fitness Tips')->first();
        $nutritionCategory = CommunityCategory::where('name', 'Nutrition')->first();
        $workoutCategory = CommunityCategory::where('name', 'Workout Routines')->first();

        // Create Community Groups
        $groups = [
            [
                'name' => 'Beginner Fitness Club',
                'description' => 'A welcoming space for fitness beginners to ask questions and share experiences.',
                'category_id' => $fitnessCategory->id,
                'is_private' => false,
                'rules' => 'Be supportive and encouraging. No judgment allowed.',
            ],
            [
                'name' => 'HIIT Warriors',
                'description' => 'High-intensity interval training enthusiasts unite!',
                'category_id' => $workoutCategory->id,
                'is_private' => false,
                'rules' => 'Share HIIT workouts, progress photos, and motivation.',
            ],
            [
                'name' => 'Plant-Based Athletes',
                'description' => 'Vegan and vegetarian fitness enthusiasts sharing plant-powered nutrition.',
                'category_id' => $nutritionCategory->id,
                'is_private' => false,
                'rules' => 'Focus on plant-based nutrition and fitness. Respect all dietary choices.',
            ],
        ];

        $adminUser = User::first();
        foreach ($groups as $groupData) {
            $group = CommunityGroup::create([
                'name' => $groupData['name'],
                'slug' => Str::slug($groupData['name']),
                'description' => $groupData['description'],
                'community_category_id' => $groupData['category_id'],
                'is_private' => $groupData['is_private'],
                'is_active' => true,
                'rules' => $groupData['rules'],
                'created_by' => $adminUser->id,
                'members_count' => 1,
            ]);

            // Add admin as group admin
            GroupMember::create([
                'community_group_id' => $group->id,
                'user_id' => $adminUser->id,
                'role' => 'admin',
                'joined_at' => now(),
            ]);
        }

        // Create Badges
        $badges = [
            [
                'name' => 'First Post',
                'description' => 'Created your first community post',
                'category' => 'community',
                'type' => 'first_action',
                'criteria' => ['action' => 'first_post'],
                'points' => 10,
                'rarity' => 'common',
            ],
            [
                'name' => 'Social Butterfly',
                'description' => 'Made 10 friends in the community',
                'category' => 'community',
                'type' => 'friend_count',
                'criteria' => ['count' => 10],
                'points' => 50,
                'rarity' => 'uncommon',
            ],
            [
                'name' => 'Conversation Starter',
                'description' => 'Created 5 posts that got community engagement',
                'category' => 'community',
                'type' => 'post_count',
                'criteria' => ['count' => 5],
                'points' => 25,
                'rarity' => 'common',
            ],
            [
                'name' => 'Beloved Member',
                'description' => 'Received 100 likes on your posts',
                'category' => 'community',
                'type' => 'like_count',
                'criteria' => ['count' => 100],
                'points' => 100,
                'rarity' => 'rare',
            ],
            [
                'name' => 'Group Leader',
                'description' => 'Joined 3 or more community groups',
                'category' => 'community',
                'type' => 'group_member',
                'criteria' => ['count' => 3],
                'points' => 75,
                'rarity' => 'uncommon',
            ],
            [
                'name' => 'Fitness Guru',
                'description' => 'Special badge for fitness experts',
                'category' => 'special',
                'type' => 'first_action',
                'criteria' => ['special' => 'fitness_expert'],
                'points' => 200,
                'rarity' => 'legendary',
            ],
        ];

        foreach ($badges as $badgeData) {
            Badge::create($badgeData);
        }

        // Create sample user profiles for testing
        $users = User::take(5)->get();
        foreach ($users as $user) {
            UserProfile::create([
                'user_id' => $user->id,
                'bio' => 'Fitness enthusiast on a journey to better health!',
                'fitness_goals' => ['lose_weight', 'build_muscle'],
                'interests' => ['cardio', 'strength_training', 'yoga'],
                'height' => rand(150, 200),
                'weight' => rand(50, 100),
                'experience_level' => ['beginner', 'intermediate', 'advanced'][rand(0, 2)],
                'privacy_settings' => [
                    'show_profile' => true,
                    'show_badges' => true,
                    'show_stats' => true,
                ],
            ]);
        }

        // Create sample posts
        $samplePosts = [
            [
                'content' => 'Just completed my first 5K run! 🏃‍♀️ Feeling amazing and ready for the next challenge. #FirstRun #FitnessJourney',
                'category_id' => $fitnessCategory->id,
                'user_id' => $users[0]->id,
                'visibility' => 'public',
            ],
            [
                'content' => 'Here\'s my favorite protein smoothie recipe: banana, spinach, protein powder, almond milk, and a tablespoon of peanut butter. Perfect post-workout fuel! 🥤',
                'category_id' => $nutritionCategory->id,
                'user_id' => $users[1]->id,
                'visibility' => 'public',
            ],
            [
                'content' => 'New to HIIT workouts and loving the intensity! Just finished a 20-minute session and I\'m already seeing improvements in my stamina.',
                'category_id' => $workoutCategory->id,
                'user_id' => $users[2]->id,
                'visibility' => 'public',
            ],
            [
                'content' => 'Meditation Monday! 🧘‍♀️ Taking 10 minutes each morning to center myself has been a game-changer for my mental health and workout motivation.',
                'category_id' => CommunityCategory::where('name', 'Mental Health')->first()->id,
                'user_id' => $users[3]->id,
                'visibility' => 'public',
            ],
            [
                'content' => 'SUCCESS STORY: 6 months ago I couldn\'t do a single push-up. Today I hit 25 in a row! 💪 Consistency is everything. Keep pushing, everyone!',
                'category_id' => CommunityCategory::where('name', 'Success Stories')->first()->id,
                'user_id' => $users[4]->id,
                'visibility' => 'public',
            ],
        ];

        foreach ($samplePosts as $postData) {
            CommunityPost::create([
                'user_id' => $postData['user_id'],
                'community_category_id' => $postData['category_id'],
                'content' => $postData['content'],
                'visibility' => $postData['visibility'],
                'is_active' => true,
                'likes_count' => rand(0, 15),
                'comments_count' => rand(0, 8),
                'shares_count' => rand(0, 3),
            ]);
        }

        echo "Community seeder completed successfully!\n";
        echo "- Created " . CommunityCategory::count() . " categories\n";
        echo "- Created " . CommunityGroup::count() . " groups\n";
        echo "- Created " . Badge::count() . " badges\n";
        echo "- Created " . UserProfile::count() . " user profiles\n";
        echo "- Created " . CommunityPost::count() . " sample posts\n";
    }
}
