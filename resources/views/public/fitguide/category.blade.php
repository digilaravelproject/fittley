@extends('layouts.public')

@section('title', 'FitGuide Categories - Training Categories')

@section('content')
<div class="container-fluid bg-dark text-white min-vh-100" style="background-color: #0a0a0a !important;">
    <!-- Hero Section -->
    <div class="row py-5 bg-gradient" style="background: linear-gradient(135deg, #f8ad30 0%, #e6941a 100%);">
        <div class="col-12 text-center">
            <h1 class="display-4 fw-bold mb-3 text-white">
                <i class="fas fa-th-large me-3"></i>Training Categories
            </h1>
            <p class="lead mb-4 text-white">Choose your fitness focus and find the perfect training program</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('fitguide.index') }}" class="btn btn-outline-light">
                    <i class="fas fa-arrow-left me-2"></i>Back to FitGuide
                </a>
            </div>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="row py-5">
        <div class="col-12">
            <h2 class="text-white mb-4">
                <i class="fas fa-dumbbell me-2"></i>Choose Your Training Focus
            </h2>
            <div class="row">
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100" style="background-color: #1d1d1d; border-color: #f8ad30;">
                        <div class="card-body text-center" style="background-color: #1d1d1d; padding: 2rem;">
                            <i class="fas fa-dumbbell fa-4x mb-3" style="color: #f8ad30;"></i>
                            <h4 class="card-title text-white mb-3">Strength Training</h4>
                            <p class="text-light mb-4">Build muscle mass, increase strength, and improve overall power with comprehensive weight training guides.</p>
                            <ul class="list-unstyled text-start mb-4">
                                <li class="text-muted mb-2"><i class="fas fa-check text-success me-2"></i>Beginner to Advanced</li>
                                <li class="text-muted mb-2"><i class="fas fa-check text-success me-2"></i>Progressive Overload</li>
                                <li class="text-muted mb-2"><i class="fas fa-check text-success me-2"></i>Form & Technique</li>
                            </ul>
                            <a href="#" class="btn btn-lg w-100" style="background-color: #f8ad30; color: #000; border-color: #f8ad30;">
                                <i class="fas fa-dumbbell me-2"></i>Explore Strength
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100" style="background-color: #1d1d1d; border-color: #f8ad30;">
                        <div class="card-body text-center" style="background-color: #1d1d1d; padding: 2rem;">
                            <i class="fas fa-heartbeat fa-4x mb-3" style="color: #f8ad30;"></i>
                            <h4 class="card-title text-white mb-3">Cardio Workouts</h4>
                            <p class="text-light mb-4">Improve cardiovascular health, burn calories, and boost endurance with varied cardio programs.</p>
                            <ul class="list-unstyled text-start mb-4">
                                <li class="text-muted mb-2"><i class="fas fa-check text-success me-2"></i>HIIT Workouts</li>
                                <li class="text-muted mb-2"><i class="fas fa-check text-success me-2"></i>Steady State Cardio</li>
                                <li class="text-muted mb-2"><i class="fas fa-check text-success me-2"></i>Fat Burning Zones</li>
                            </ul>
                            <a href="#" class="btn btn-lg w-100" style="background-color: #f8ad30; color: #000; border-color: #f8ad30;">
                                <i class="fas fa-heartbeat me-2"></i>Explore Cardio
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100" style="background-color: #1d1d1d; border-color: #f8ad30;">
                        <div class="card-body text-center" style="background-color: #1d1d1d; padding: 2rem;">
                            <i class="fas fa-leaf fa-4x mb-3" style="color: #f8ad30;"></i>
                            <h4 class="card-title text-white mb-3">Flexibility & Yoga</h4>
                            <p class="text-light mb-4">Enhance flexibility, balance, and mental well-being through yoga and stretching routines.</p>
                            <ul class="list-unstyled text-start mb-4">
                                <li class="text-muted mb-2"><i class="fas fa-check text-success me-2"></i>Yoga Flows</li>
                                <li class="text-muted mb-2"><i class="fas fa-check text-success me-2"></i>Stretching Routines</li>
                                <li class="text-muted mb-2"><i class="fas fa-check text-success me-2"></i>Mindfulness</li>
                            </ul>
                            <a href="#" class="btn btn-lg w-100" style="background-color: #f8ad30; color: #000; border-color: #f8ad30;">
                                <i class="fas fa-leaf me-2"></i>Explore Flexibility
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100" style="background-color: #1d1d1d; border-color: #f8ad30;">
                        <div class="card-body text-center" style="background-color: #1d1d1d; padding: 2rem;">
                            <i class="fas fa-running fa-4x mb-3" style="color: #f8ad30;"></i>
                            <h4 class="card-title text-white mb-3">HIIT Training</h4>
                            <p class="text-light mb-4">High-intensity interval training for maximum results in minimum time with explosive workouts.</p>
                            <ul class="list-unstyled text-start mb-4">
                                <li class="text-muted mb-2"><i class="fas fa-check text-success me-2"></i>Quick Workouts</li>
                                <li class="text-muted mb-2"><i class="fas fa-check text-success me-2"></i>Fat Burning</li>
                                <li class="text-muted mb-2"><i class="fas fa-check text-success me-2"></i>Metabolic Boost</li>
                            </ul>
                            <a href="#" class="btn btn-lg w-100" style="background-color: #f8ad30; color: #000; border-color: #f8ad30;">
                                <i class="fas fa-running me-2"></i>Explore HIIT
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100" style="background-color: #1d1d1d; border-color: #f8ad30;">
                        <div class="card-body text-center" style="background-color: #1d1d1d; padding: 2rem;">
                            <i class="fas fa-apple-alt fa-4x mb-3" style="color: #f8ad30;"></i>
                            <h4 class="card-title text-white mb-3">Nutrition Guides</h4>
                            <p class="text-light mb-4">Learn about proper nutrition, meal planning, and dietary strategies to support your fitness goals.</p>
                            <ul class="list-unstyled text-start mb-4">
                                <li class="text-muted mb-2"><i class="fas fa-check text-success me-2"></i>Meal Planning</li>
                                <li class="text-muted mb-2"><i class="fas fa-check text-success me-2"></i>Macro Tracking</li>
                                <li class="text-muted mb-2"><i class="fas fa-check text-success me-2"></i>Healthy Recipes</li>
                            </ul>
                            <a href="#" class="btn btn-lg w-100" style="background-color: #f8ad30; color: #000; border-color: #f8ad30;">
                                <i class="fas fa-apple-alt me-2"></i>Explore Nutrition
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100" style="background-color: #1d1d1d; border-color: #f8ad30;">
                        <div class="card-body text-center" style="background-color: #1d1d1d; padding: 2rem;">
                            <i class="fas fa-brain fa-4x mb-3" style="color: #f8ad30;"></i>
                            <h4 class="card-title text-white mb-3">Mental Wellness</h4>
                            <p class="text-light mb-4">Focus on mental health, stress management, and the mind-body connection for holistic fitness.</p>
                            <ul class="list-unstyled text-start mb-4">
                                <li class="text-muted mb-2"><i class="fas fa-check text-success me-2"></i>Stress Management</li>
                                <li class="text-muted mb-2"><i class="fas fa-check text-success me-2"></i>Meditation</li>
                                <li class="text-muted mb-2"><i class="fas fa-check text-success me-2"></i>Sleep Optimization</li>
                            </ul>
                            <a href="#" class="btn btn-lg w-100" style="background-color: #f8ad30; color: #000; border-color: #f8ad30;">
                                <i class="fas fa-brain me-2"></i>Explore Wellness
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Coming Soon Notice -->
    <div class="row py-5">
        <div class="col-12 text-center">
            <div class="card" style="background-color: #1d1d1d; border-color: #333;">
                <div class="card-body" style="background-color: #1d1d1d; padding: 3rem;">
                    <i class="fas fa-tools fa-3x mb-3" style="color: #f8ad30;"></i>
                    <h3 class="text-white mb-3">Content Coming Soon!</h3>
                    <p class="text-light mb-4">We're working hard to bring you comprehensive training guides in all these categories. Stay tuned for amazing content!</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('fitguide.index') }}" class="btn btn-lg" style="background-color: #f8ad30; color: #000; border-color: #f8ad30;">
                            <i class="fas fa-arrow-left me-2"></i>Back to FitGuide
                        </a>
                        <a href="{{ route('subscription.plans') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-bell me-2"></i>Get Notified
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 