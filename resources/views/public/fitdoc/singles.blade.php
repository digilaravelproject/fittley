@extends('layouts.public')

@section('title', 'FitDoc Singles - Fitness Documentaries')

@section('content')
<div class="container-fluid bg-dark text-white min-vh-100" style="background-color: #0a0a0a !important;">
    <!-- Hero Section -->
    <div class="row py-5 bg-gradient" style="background: linear-gradient(135deg, #f8ad30 0%, #e6941a 100%);">
        <div class="col-12 text-center">
            <h1 class="display-4 fw-bold mb-3 text-dark">
                <i class="fas fa-video me-3"></i>FitDoc Singles
            </h1>
            <p class="lead mb-4 text-dark">Standalone fitness documentaries for quick learning</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('fitdoc.index') }}" class="btn btn-outline-dark">
                    <i class="fas fa-arrow-left me-2"></i>Back to FitDoc
                </a>
                <a href="{{ route('fitdoc.series') }}" class="btn btn-dark">
                    <i class="fas fa-list me-2"></i>View Series
                </a>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="row py-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-white">
                    <i class="fas fa-video me-2"></i>Single Documentaries
                </h2>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" style="width: auto; background-color: #1d1d1d; border-color: #333; color: white;">
                        <option>All Categories</option>
                        <option>Strength Training</option>
                        <option>Cardio</option>
                        <option>Nutrition</option>
                        <option>Mental Health</option>
                    </select>
                    <select class="form-select form-select-sm" style="width: auto; background-color: #1d1d1d; border-color: #333; color: white;">
                        <option>Sort by Latest</option>
                        <option>Sort by Popular</option>
                        <option>Sort by Rating</option>
                    </select>
                </div>
            </div>

            <!-- Coming Soon Message -->
            <div class="text-center py-5">
                <div class="card" style="background-color: #1d1d1d; border-color: #333;">
                    <div class="card-body" style="background-color: #1d1d1d; padding: 4rem;">
                        <i class="fas fa-film fa-4x mb-4" style="color: #f8ad30;"></i>
                        <h3 class="text-white mb-3">Coming Soon!</h3>
                        <p class="text-light mb-4">We're curating an amazing collection of fitness documentaries for you. Stay tuned for inspiring content that will transform your fitness journey.</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('fitdoc.index') }}" class="btn btn-lg" style="background-color: #f8ad30; color: #000; border-color: #f8ad30;">
                                <i class="fas fa-arrow-left me-2"></i>Back to FitDoc
                            </a>
                            <a href="{{ route('subscription.plans') }}" class="btn btn-outline-light btn-lg">
                                <i class="fas fa-bell me-2"></i>Get Notified
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Placeholder Grid (for future content) -->
            <div class="row" style="display: none;">
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100" style="background-color: #1d1d1d; border-color: #333;">
                        <div class="position-relative">
                            <div class="card-img-top d-flex align-items-center justify-content-center" 
                                 style="height: 200px; background-color: #2d2d2d;">
                                <i class="fas fa-film fa-3x text-muted"></i>
                            </div>
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-primary">Documentary</span>
                            </div>
                            <div class="position-absolute bottom-0 start-0 m-2">
                                <span class="badge bg-dark bg-opacity-75">
                                    <i class="fas fa-clock"></i> 45 min
                                </span>
                            </div>
                        </div>
                        <div class="card-body" style="background-color: #1d1d1d;">
                            <h5 class="card-title text-white">Documentary Title</h5>
                            <p class="card-text text-light">Brief description of the documentary content...</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-star"></i> 4.8 (120 reviews)
                                </small>
                                <a href="#" class="btn btn-sm" style="background-color: #f8ad30; color: #000; border-color: #f8ad30;">
                                    <i class="fas fa-play"></i> Watch
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 