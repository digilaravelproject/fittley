<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FitArenaEvent;
use App\Models\FitArenaStage;
use App\Models\FitArenaSession;
use App\Models\Category;
use App\Models\SubCategory;
use Carbon\Carbon;

class FitArenaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories for sessions
        $categories = Category::all();
        $subCategories = SubCategory::all();

        // Create sample events
        $events = [
            [
                'title' => 'Global Fitness Expo 2025',
                'description' => 'The world\'s largest fitness and wellness expo featuring top experts, innovative equipment, and breakthrough fitness methodologies.',
                'slug' => 'global-fitness-expo-2025',
                'start_date' => Carbon::now()->addDays(30),
                'end_date' => Carbon::now()->addDays(33),
                'location' => 'Las Vegas Convention Center, Nevada, USA',
                'status' => 'upcoming',
                'visibility' => 'public',
                'dvr_enabled' => true,
                'dvr_hours' => 48,
                'organizers' => [
                    ['name' => 'FitExpo International', 'role' => 'Main Organizer'],
                    ['name' => 'Wellness World', 'role' => 'Co-Organizer']
                ],
                'expected_viewers' => 50000,
                'is_featured' => true,
            ],
            [
                'title' => 'Yoga Masters Summit',
                'description' => 'A transformative 2-day summit bringing together the world\'s most renowned yoga masters and wellness experts.',
                'slug' => 'yoga-masters-summit',
                'start_date' => Carbon::now()->addDays(15),
                'end_date' => Carbon::now()->addDays(16),
                'location' => 'Rishikesh, India (Virtual)',
                'status' => 'upcoming',
                'visibility' => 'public',
                'dvr_enabled' => true,
                'dvr_hours' => 72,
                'organizers' => [
                    ['name' => 'International Yoga Alliance', 'role' => 'Organizer']
                ],
                'expected_viewers' => 25000,
                'is_featured' => true,
            ],
            [
                'title' => 'CrossFit Games Qualifier',
                'description' => 'Regional CrossFit competition featuring the best athletes competing for a spot in the CrossFit Games.',
                'slug' => 'crossfit-games-qualifier',
                'start_date' => Carbon::now()->subDays(5),
                'end_date' => Carbon::now()->addDays(2),
                'location' => 'Madison, Wisconsin, USA',
                'status' => 'live',
                'visibility' => 'public',
                'dvr_enabled' => true,
                'dvr_hours' => 24,
                'organizers' => [
                    ['name' => 'CrossFit Inc.', 'role' => 'Organizer']
                ],
                'expected_viewers' => 75000,
                'peak_viewers' => 45000,
                'is_featured' => false,
            ]
        ];

        foreach ($events as $eventData) {
            $event = FitArenaEvent::create($eventData);
            
            // Create stages for each event
            $stages = $this->getStagesForEvent($event);
            
            foreach ($stages as $stageData) {
                $stageData['event_id'] = $event->id;
                $stage = FitArenaStage::create($stageData);
                
                // Create sessions for each stage
                $sessions = $this->getSessionsForStage($event, $stage, $categories, $subCategories);
                
                foreach ($sessions as $sessionData) {
                    $sessionData['event_id'] = $event->id;
                    $sessionData['stage_id'] = $stage->id;
                    FitArenaSession::create($sessionData);
                }
            }
        }
    }

    /**
     * Get stages configuration for different events
     */
    private function getStagesForEvent(FitArenaEvent $event): array
    {
        if (str_contains($event->title, 'Global Fitness Expo')) {
            return [
                [
                    'name' => 'Main Stage',
                    'description' => 'Primary stage featuring keynote speakers and major presentations',
                    'color_code' => '#d4ab00',
                    'capacity' => 10000,
                    'is_primary' => true,
                    'sort_order' => 1,
                    'status' => 'scheduled'
                ],
                [
                    'name' => 'Innovation Hub',
                    'description' => 'Showcasing the latest fitness technology and equipment',
                    'color_code' => '#ff6b35',
                    'capacity' => 5000,
                    'is_primary' => false,
                    'sort_order' => 2,
                    'status' => 'scheduled'
                ],
                [
                    'name' => 'Wellness Workshop',
                    'description' => 'Interactive workshops and hands-on training sessions',
                    'color_code' => '#4ecdc4',
                    'capacity' => 3000,
                    'is_primary' => false,
                    'sort_order' => 3,
                    'status' => 'scheduled'
                ],
                [
                    'name' => 'Nutrition Corner',
                    'description' => 'Expert talks on nutrition, diet, and healthy eating',
                    'color_code' => '#95e1d3',
                    'capacity' => 2000,
                    'is_primary' => false,
                    'sort_order' => 4,
                    'status' => 'scheduled'
                ]
            ];
        } elseif (str_contains($event->title, 'Yoga Masters')) {
            return [
                [
                    'name' => 'Serenity Stage',
                    'description' => 'Main stage for yoga sessions and master classes',
                    'color_code' => '#8b5a3c',
                    'capacity' => 8000,
                    'is_primary' => true,
                    'sort_order' => 1,
                    'status' => 'scheduled'
                ],
                [
                    'name' => 'Meditation Garden',
                    'description' => 'Peaceful space for meditation and mindfulness sessions',
                    'color_code' => '#6ab04c',
                    'capacity' => 3000,
                    'is_primary' => false,
                    'sort_order' => 2,
                    'status' => 'scheduled'
                ]
            ];
        } else { // CrossFit Games
            return [
                [
                    'name' => 'Arena Floor',
                    'description' => 'Main competition floor with live CrossFit events',
                    'color_code' => '#e74c3c',
                    'capacity' => 15000,
                    'is_primary' => true,
                    'sort_order' => 1,
                    'status' => 'live'
                ],
                [
                    'name' => 'Training Zone',
                    'description' => 'Warm-up and training area coverage',
                    'color_code' => '#3498db',
                    'capacity' => 5000,
                    'is_primary' => false,
                    'sort_order' => 2,
                    'status' => 'live'
                ]
            ];
        }
    }

    /**
     * Get sessions for each stage
     */
    private function getSessionsForStage(FitArenaEvent $event, FitArenaStage $stage, $categories, $subCategories): array
    {
        $sessions = [];
        $startDate = $event->start_date->copy();
        
        if (str_contains($event->title, 'Global Fitness Expo')) {
            if ($stage->name === 'Main Stage') {
                $sessions = [
                    [
                        'title' => 'Opening Keynote: The Future of Fitness',
                        'description' => 'Industry leaders discuss emerging trends and technologies shaping the future of fitness.',
                        'speakers' => [
                            ['name' => 'Dr. Sarah Johnson', 'title' => 'Fitness Technology Expert', 'bio' => 'Leading researcher in fitness technology and biomechanics'],
                            ['name' => 'Mark Thompson', 'title' => 'CEO, FitTech Global', 'bio' => '20+ years experience in fitness industry innovation']
                        ],
                        'scheduled_start' => $startDate->copy()->setTime(9, 0),
                        'scheduled_end' => $startDate->copy()->setTime(10, 30),
                        'session_type' => 'keynote',
                        'category_id' => $categories->where('name', 'LIKE', '%Fitness%')->first()?->id,
                    ],
                    [
                        'title' => 'Panel: Sustainable Fitness Business Models',
                        'description' => 'Expert panel discussing sustainable and profitable fitness business strategies.',
                        'speakers' => [
                            ['name' => 'Lisa Chen', 'title' => 'Gym Chain Owner'],
                            ['name' => 'David Rodriguez', 'title' => 'Fitness Consultant'],
                            ['name' => 'Emma Wilson', 'title' => 'Digital Fitness Entrepreneur']
                        ],
                        'scheduled_start' => $startDate->copy()->setTime(11, 0),
                        'scheduled_end' => $startDate->copy()->setTime(12, 30),
                        'session_type' => 'panel',
                    ]
                ];
            } elseif ($stage->name === 'Innovation Hub') {
                $sessions = [
                    [
                        'title' => 'AI in Personal Training',
                        'description' => 'Exploring how artificial intelligence is revolutionizing personal training.',
                        'speakers' => [
                            ['name' => 'Dr. Alex Kim', 'title' => 'AI Researcher', 'bio' => 'Specialist in AI applications for health and fitness']
                        ],
                        'scheduled_start' => $startDate->copy()->setTime(10, 0),
                        'scheduled_end' => $startDate->copy()->setTime(11, 0),
                        'session_type' => 'presentation',
                    ]
                ];
            }
        } elseif (str_contains($event->title, 'Yoga Masters')) {
            if ($stage->name === 'Serenity Stage') {
                $sessions = [
                    [
                        'title' => 'Sunrise Hatha Yoga Flow',
                        'description' => 'Traditional Hatha yoga practice led by master yogis from India.',
                        'speakers' => [
                            ['name' => 'Guru Ravindra', 'title' => 'Yoga Master', 'bio' => '40+ years of yoga practice and teaching']
                        ],
                        'scheduled_start' => $startDate->copy()->setTime(6, 0),
                        'scheduled_end' => $startDate->copy()->setTime(7, 30),
                        'session_type' => 'workshop',
                        'category_id' => $categories->where('name', 'LIKE', '%Yoga%')->first()?->id,
                    ]
                ];
            }
        } else { // CrossFit Games
            if ($stage->name === 'Arena Floor') {
                $sessions = [
                    [
                        'title' => 'Event 1: Sprint Ladder',
                        'description' => 'Athletes compete in a high-intensity sprint ladder challenge.',
                        'speakers' => [
                            ['name' => 'Competition Judges', 'title' => 'Official Judges']
                        ],
                        'scheduled_start' => $startDate->copy()->setTime(9, 0),
                        'scheduled_end' => $startDate->copy()->setTime(11, 0),
                        'session_type' => 'competition',
                        'status' => $event->status === 'live' ? 'live' : 'scheduled',
                        'category_id' => $categories->where('name', 'LIKE', '%CrossFit%')->first()?->id ?? $categories->first()?->id,
                    ]
                ];
            }
        }

        return $sessions;
    }
} 