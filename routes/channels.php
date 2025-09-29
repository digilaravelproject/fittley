<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// FitLive session channel for real-time updates
Broadcast::channel('fitlive.{id}', function ($user, $id) {
    // Allow authenticated users to join any public FitLive session
    // In production, you might want to add more specific authorization logic
    return $user ? true : false;
});
