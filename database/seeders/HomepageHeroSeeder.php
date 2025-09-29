<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HomepageHero;

class HomepageHeroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HomepageHero::create([
            'title' => 'ABS Workout - Core Strengthening',
            'description' => 'An abs workout is designed to strengthen and tone the muscles in the abdominal region, including the upper, lower, and side muscles that form the core.',
            'youtube_video_id' => 'dQw4w9WgXcQ', // Sample YouTube video ID
            'play_button_text' => 'PLAY NOW',
            'play_button_link' => '#',
            'trailer_button_text' => 'WATCH TRAILER',
            'trailer_button_link' => '#',
            'category' => 'ABS',
            'duration' => '20 min',
            'year' => 2018,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        HomepageHero::create([
            'title' => 'HIIT Training - High Intensity',
            'description' => 'High-Intensity Interval Training (HIIT) is a fitness technique that alternates short bursts of intense exercise with brief recovery periods.',
            'youtube_video_id' => 'jNQXAC9IVRw', // Sample YouTube video ID
            'play_button_text' => 'START WORKOUT',
            'play_button_link' => '#',
            'trailer_button_text' => 'PREVIEW',
            'trailer_button_link' => '#',
            'category' => 'HIIT',
            'duration' => '30 min',
            'year' => 2023,
            'is_active' => false,
            'sort_order' => 2,
        ]);
    }
}
