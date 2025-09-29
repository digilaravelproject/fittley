@extends('layouts.home.public')

@section('title', 'Tools')

@section('content')
    <div class="tools-mobile-container mx-auto pb-2">
        <!-- Page header -->
        <div class="page-header mb-4">
            <div class="row align-items-center">
                <div class="col-12">
                    <h1 class="page-title mb-1">
                        <i class="fas fa-tools me-2"></i>
                        Fitness Tools
                    </h1>
                    <p class="page-subtitle text-white">Explore calculators and trackers to support your journey</p>
                </div>
            </div>
        </div>

        <!-- Tools list -->
        <div class="row">
            {{-- <div class="col-12"> --}}
            <div class="tools-list row g-3">
                @foreach ($tools as $tool)
                    @php
                        $href = match ($tool['name']) {
                            'Progress Insights' => route('progress-insights'),
                            'BMR Calculator' => route('bmr-calculator'),
                            'Steps Tracker' => route('steps-tracker'),
                            'Calories Consumed' => route('calories'),
                            'HealthKit' => route('health-kit'),
                            'RPE Calculator' => route('rpe'),
                            'Body Fat Percentage Estimator' => route('body-fat'),
                            'Calorie & Macronutrient Planner' => route('planner'),
                            'Protein Requirement Tool' => route('protein-requirement'),
                            'TDEE Calculator' => route('tdee'),
                            'Water Intake Calculator' => route('water-intake'),
                            '1 RM Calculator' => route('one-rm'),
                            default => '#',
                        };
                    @endphp


                    <div class="col-12 col-md-6 col-lg-4">
                        <a href="{{ $href }}" class="tool-card text-decoration-none d-block h-100">
                            <div class="card shadow-sm border-0 rounded-2 h-100">
                                <div class="tools-card-body card-body d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="tool-icon me-3 d-flex align-items-center justify-content-center rounded-1">
                                            @switch($tool['icon'])
                                                @case('insights')
                                                    <i class="fas fa-bolt fa-lg text-warning"></i>
                                                @break

                                                @case('calculator')
                                                    <i class="fas fa-calculator fa-lg text-info"></i>
                                                @break

                                                @case('health')
                                                    <i class="fas fa-heartbeat fa-lg text-danger"></i>
                                                @break

                                                @case('fire')
                                                    <i class="fas fa-fire fa-lg text-danger"></i>
                                                @break

                                                @case('steps')
                                                    <i class="fas fa-shoe-prints fa-lg text-success"></i>
                                                @break

                                                @case('rpe')
                                                    <i class="fas fa-dumbbell fa-lg text-primary"></i>
                                                @break

                                                @case('body_fat')
                                                    <i class="fas fa-weight fa-lg text-pink-500"></i>
                                                @break

                                                @case('planner')
                                                    <i class="fas fa-clipboard-list fa-lg text-primary"></i>
                                                @break

                                                @case('protein')
                                                    <i class="fas fa-egg fa-lg text-yellow-500"></i>
                                                @break

                                                @case('tdee')
                                                    <i class="fas fa-balance-scale fa-lg text-indigo-500"></i>
                                                @break

                                                @case('water_intake')
                                                    <i class="fas fa-tint fa-lg text-blue-500"></i>
                                                @break

                                                @case('1_rm')
                                                    <i class="fas fa-weight-hanging fa-lg text-teal-500"></i>
                                                @break

                                                @default
                                                    <i class="fas fa-toolbox fa-lg text-secondary"></i>
                                            @endswitch
                                        </div>

                                        <div>
                                            <h6 class="mb-0">{{ $tool['name'] }}</h6>
                                            @if (!empty($tool['subtitle']))
                                                <small class="text-muted">{{ $tool['subtitle'] }}</small>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="text-white arrow-icon">
                                        <i class="fas fa-chevron-right"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            {{-- </div> --}}
        </div>
    </div>

    <!-- Styles -->
    <style>
        .card {
            color: #e9e6e6;
            background: #1e1e1e !important;
        }

        .tools-mobile-container {
            margin: 0 auto;
            padding: 0 0.5rem;
        }

        .tools-icon {
            width: 52px;
            height: 52px;
            background: rgba(255, 255, 255, 0.02);
            border-radius: 10px;
        }

        .card.bg-dark {
            background: linear-gradient(180deg, rgba(23, 23, 23, 1), rgba(18, 18, 18, 1));
        }

        .page-title i {
            color: #ffc107;
        }

        @media (max-width: 575.98px) {
            .tools-mobile-container {
                max-width: 425px;
            }
        }

        @media (max-width:480px) {


            .tools-mobile-container {
                max-width: 425px;
                margin: 0 auto;
                padding: 0 0.5rem;
            }


            .navbar-nav {
                gap: 1rem;
                align-items: center;
                margin-left: 0.5rem;
            }

            .card.bg-dark {
                background: linear-gradient(180deg, rgba(23, 23, 23, 1), rgba(18, 18, 18, 1));
            }

            .page-title {
                font-size: 1.2rem;
            }

            .page-title i {
                color: #ffc107;
            }

            .page-subtitle {
                font-size: 0.9rem;
                color: #bbbbbb;
            }

            .tool-card {
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .tool-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2);
            }

            .tool-icon {
                width: 35px;
                height: 35px;
                font-size: 1rem;
                background: none;
            }

            .tools-card-body {
                padding: .3rem 0.5rem;
            }

            .card {
                color: #e9e6e6;
                background: #1e1e1e !important;
            }

            .tool-card h6 {
                font-size: 0.9rem;
                font-weight: 300;
                font-family: Roboto;
            }

            .arrow-icon {
                color: #e9e6e6 !important;
                font-size: 0.9rem;
            }

            .tools-list .col-12 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .page-header {
                margin-bottom: 1rem !important;
                padding: 0.7rem;
                font-family: Roboto;
                border-radius: 0.3rem;
            }
        }
    </style>
@endsection
