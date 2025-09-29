<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\FitLiveSession;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class FitLiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles and permissions
        $this->createRolesAndPermissions();
        
        // Create admin user
        $this->createAdminUser();
        
        // Create instructor users
        $this->createInstructorUsers();
        
        // Create FitLive Categories
        $this->createCategories();
        
        // Create sample sessions
        $this->createSampleSessions();
    }

    /**
     * Create roles and permissions
     */
    private function createRolesAndPermissions(): void
    {
        // Create roles if they don't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $instructorRole = Role::firstOrCreate(['name' => 'instructor']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Create permissions
        $permissions = [
            'manage-fitlive',
            'create-sessions',
            'edit-sessions',
            'delete-sessions',
            'start-sessions',
            'end-sessions',
            'manage-categories',
            'view-analytics',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $adminRole->syncPermissions($permissions);
        $instructorRole->syncPermissions(['create-sessions', 'edit-sessions', 'start-sessions', 'end-sessions']);
    }

    /**
     * Create admin user
     */
    private function createAdminUser(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@fitlley.com'],
            [
                'name' => 'FitLley Admin',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        $admin->assignRole('admin');
    }

    /**
     * Create instructor users
     */
    private function createInstructorUsers(): void
    {
        $instructors = [
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah@fitlley.com',
                'password' => Hash::make('instructor123'),
            ],
            [
                'name' => 'Maria Santos',
                'email' => 'maria@fitlley.com',
                'password' => Hash::make('instructor123'),
            ],
            [
                'name' => 'Mike Chen',
                'email' => 'mike@fitlley.com',
                'password' => Hash::make('instructor123'),
            ],
        ];

        foreach ($instructors as $instructorData) {
            $instructor = User::firstOrCreate(
                ['email' => $instructorData['email']],
                array_merge($instructorData, ['email_verified_at' => now()])
            );
            
            $instructor->assignRole('instructor');
        }
    }

    /**
     * Create categories and subcategories
     */
    private function createCategories(): void
    {
        $categories = [
            [
                'name' => 'Fitness Classes',
                'slug' => 'fitness-classes',
                'chat_mode' => 'during',
                'sort_order' => 1,
                'subcategories' => [
                    ['name' => 'HIIT Training', 'slug' => 'hiit-training', 'sort_order' => 1],
                    ['name' => 'Strength Training', 'slug' => 'strength-training', 'sort_order' => 2],
                    ['name' => 'Cardio Workouts', 'slug' => 'cardio-workouts', 'sort_order' => 3],
                ]
            ],
            [
                'name' => 'Yoga & Meditation',
                'slug' => 'yoga-meditation',
                'chat_mode' => 'after',
                'sort_order' => 2,
                'subcategories' => [
                    ['name' => 'Beginner Yoga', 'slug' => 'beginner-yoga', 'sort_order' => 1],
                    ['name' => 'Advanced Yoga', 'slug' => 'advanced-yoga', 'sort_order' => 2],
                    ['name' => 'Meditation', 'slug' => 'meditation', 'sort_order' => 3],
                ]
            ],
            [
                'name' => 'Dance Workouts',
                'slug' => 'dance-workouts',
                'chat_mode' => 'during',
                'sort_order' => 3,
                'subcategories' => [
                    ['name' => 'Zumba', 'slug' => 'zumba', 'sort_order' => 1],
                    ['name' => 'Hip Hop Dance', 'slug' => 'hip-hop-dance', 'sort_order' => 2],
                ]
            ],
            [
                'name' => 'Nutrition Talks',
                'slug' => 'nutrition-talks',
                'chat_mode' => 'during',
                'sort_order' => 4,
                'subcategories' => [
                    ['name' => 'Meal Planning', 'slug' => 'meal-planning', 'sort_order' => 1],
                    ['name' => 'Weight Management', 'slug' => 'weight-management', 'sort_order' => 2],
                ]
            ],
        ];

        foreach ($categories as $categoryData) {
            $subcategories = $categoryData['subcategories'];
            unset($categoryData['subcategories']);

            $category = Category::firstOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );

            foreach ($subcategories as $subcategoryData) {
                $subcategoryData['category_id'] = $category->id;
                SubCategory::firstOrCreate(
                    ['slug' => $subcategoryData['slug']],
                    $subcategoryData
                );
            }
        }
    }

    /**
     * Create sample sessions
     */
    private function createSampleSessions(): void
    {
        $fitnessCategory = Category::where('slug', 'fitness-classes')->first();
        $yogaCategory = Category::where('slug', 'yoga-meditation')->first();
        $hiitSubcategory = SubCategory::where('slug', 'hiit-training')->first();
        $beginnerYogaSubcategory = SubCategory::where('slug', 'beginner-yoga')->first();

        $sarahInstructor = User::where('email', 'sarah@fitlley.com')->first();
        $mariaInstructor = User::where('email', 'maria@fitlley.com')->first();
        $mikeInstructor = User::where('email', 'mike@fitlley.com')->first();

        $sessions = [
            [
                'category_id' => $fitnessCategory->id,
                'sub_category_id' => $hiitSubcategory->id,
                'instructor_id' => $sarahInstructor->id,
                'title' => 'Morning HIIT Blast',
                'description' => 'Start your day with an energizing 30-minute HIIT workout',
                'scheduled_at' => Carbon::tomorrow()->setTime(8, 0),
                'status' => 'scheduled',
                'chat_mode' => 'during',
                'livekit_room' => 'fitlive.morning-hiit-' . time(),
                'visibility' => 'public',
            ],
            [
                'category_id' => $yogaCategory->id,
                'sub_category_id' => $beginnerYogaSubcategory->id,
                'instructor_id' => $mariaInstructor->id,
                'title' => 'Evening Relaxation Yoga',
                'description' => 'Gentle yoga flow to help you unwind and relax',
                'scheduled_at' => Carbon::today()->addDays(2)->setTime(19, 0),
                'status' => 'scheduled',
                'chat_mode' => 'after',
                'livekit_room' => 'fitlive.evening-yoga-' . time(),
                'visibility' => 'public',
            ],
            [
                'category_id' => $fitnessCategory->id,
                'sub_category_id' => $hiitSubcategory->id,
                'instructor_id' => $mikeInstructor->id,
                'title' => 'Lunch Break HIIT',
                'description' => 'Quick and effective 20-minute HIIT session',
                'scheduled_at' => Carbon::today()->addDays(3)->setTime(12, 30),
                'status' => 'scheduled',
                'chat_mode' => 'during',
                'livekit_room' => 'fitlive.lunch-hiit-' . time(),
                'visibility' => 'public',
            ],
        ];

        foreach ($sessions as $sessionData) {
            FitLiveSession::firstOrCreate(
                ['livekit_room' => $sessionData['livekit_room']],
                $sessionData
            );
        }
    }
}
