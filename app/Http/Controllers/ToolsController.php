<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToolsController extends Controller
{
    /**
     * Display a listing of the tools.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mock data for the tools, similar to the image provided.
        $tools = [
            ['name' => 'Progress Insights', 'icon' => 'insights'],
            ['name' => 'BMR Calculator', 'icon' => 'calculator'],
            ['name' => 'HealthKit', 'icon' => 'health'],
            ['name' => 'Calories Consumed', 'icon' => 'fire'],
            ['name' => 'Steps Tracker', 'icon' => 'steps'],
            ['name' => 'RPE Calculator', 'icon' => 'rpe'],
            ['name' => 'Body Fat Percentage Estimator', 'icon' => 'body_fat'],
            ['name' => 'Calorie & Macronutrient Planner', 'icon' => 'planner'],
            ['name' => 'Protein Requirement Tool', 'icon' => 'protein'],
            ['name' => 'TDEE Calculator', 'icon' => 'tdee'], 
            ['name' => 'Water Intake Calculator', 'icon' => 'water_intake'], 
            ['name' => '1 RM Calculator', 'icon' => '1_rm'],
        ];

        return view('tools.index', ['tools' => $tools]);
    }

    public function progress_insights(Request $request)
    {
        $period = $request->get('period', 'Weekly');

        // Mock data for demo - replace with DB queries later
        $progressData = match ($period) {
            'Monthly' => [
                'stats' => [
                    'weight' => '71.2 kg',
                    'chest' => '99 cm',
                    'squat_pr' => '120 kg'
                ],
                'charts' => [
                    'body_weight' => [
                        'labels' => ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                        'data' => [70.0, 70.5, 71.0, 71.2]
                    ],
                    'workout_prs' => [
                        'labels' => ['Squat', 'Bench', 'Deadlift'],
                        'data' => [120, 87, 142]
                    ]
                ]
            ],
            'Yearly' => [
                'stats' => [
                    'weight' => '72.0 kg',
                    'chest' => '102 cm',
                    'squat_pr' => '125 kg'
                ],
                'charts' => [
                    'body_weight' => [
                        'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                        'data' => [70.0, 70.8, 71.5, 71.8, 72.0, 72.0]
                    ],
                    'workout_prs' => [
                        'labels' => ['Squat', 'Bench', 'Deadlift'],
                        'data' => [125, 90, 150]
                    ]
                ]
            ],
            default => [ // Weekly
                'stats' => [
                    'weight' => '70.0 kg',
                    'chest' => '98 cm',
                    'squat_pr' => '118 kg'
                ],
                'charts' => [
                    'body_weight' => [
                        'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                        'data' => [69.5, 69.8, 70.0, 70.2, 70.0, 69.9, 70.0]
                    ],
                    'workout_prs' => [
                        'labels' => ['Squat', 'Bench', 'Deadlift'],
                        'data' => [118, 85, 140]
                    ]
                ]
            ]
        };

        if ($request->ajax()) {
            return response()->json($progressData);
        }

        return view('tools.progress-insights', compact('progressData', 'period'));
    }

    /**
     * Show the BMR Calculator page.
     */
    public function bmr_calculator()
    {
        return view('tools.bmr-calculator');
    }

    /**
     * Show the calories page.
     */
    public function calories()
    {
        return view('tools.calories');
    }
    
    /**
     * Show the steps tracker page.
     */
    public function steps_tracker()
    {
        return view('tools.steps-tracker');
    }

    /**
     * Show the health-kit page.
     */
    public function health_kit()
    {
        // Mock data for the tools, similar to the image provided.
        $tools = [
            ['name' => 'Step Count', 'icon' => 'insights'],
            ['name' => 'Heart Rate', 'icon' => 'calculator'],
            ['name' => 'Calories Burned', 'icon' => 'health'],
            ['name' => 'Sleep Tracking', 'icon' => 'fire'],
        ];

        return view('tools.health-kit', ['tools' => $tools]);
    }

    /**
     * Show the rpe calculator page.
     */
    public function rpe()
    {
        return view('tools.rpe-calculator');
    }
    /**
     * Show the rpe calculator page.
     */
    public function body_fat()
    {
        return view('tools.body-fat');
    }
    
    /**
     * Show the Calorie & Macronutrient Planner page.
     */
    public function planner()
    {
        return view('tools.planner');
    }
    
    /**
     * Show the Protein Requirement Tool page.
     */
    public function protein_requirement()
    {
        return view('tools.protein-requirement');
    }
    
    /**
     * Show the TDEE Calculator page.
     */
    public function tdee()
    {
        return view('tools.tdee');
    }
    
    /**
     * Show the Water Intake Calculator page.
     */
    public function water_intake()
    {
        return view('tools.water-intake');
    }
    
    /**
     * Show the 1 RM Calculator page.
     */
    public function one_rm()
    {
        return view('tools.one-rm');
    }
}
