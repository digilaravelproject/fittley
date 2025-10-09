<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule daily FitLive sessions creation
Schedule::command('fitlive:create-daily-sessions')->everyMinute();
Schedule::command('fitnews:create-daily-news')->everyMinute();

// Schedule badge checking (run every hour)
Schedule::command('badges:check')->everyMinute();
