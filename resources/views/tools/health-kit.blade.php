@extends('layouts.public')

@section('title', 'Tools')

@section('content')
<div class="container py-4">
    <!-- Page header - matches your dashboard style -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title mb-1">
                    <i class="fas fa-tools me-2"></i>
                    Health Kit
                </h1>
                <p class="page-subtitle text-white">Explore calculators and trackers to support your journey</p>
            </div>
        </div>
    </div>

    <!-- Tools list (centered column) -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="tools-list">
                @foreach ($tools as $tool)
                    <a href="#" class="d-block mb-3 text-decoration-none">
                        <div class="card bg-dark text-white shadow-sm border-0 rounded-3">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="me-3 tools-icon d-flex align-items-center justify-content-center rounded-2">
                                        @switch($tool['icon'])
                                            @case('insights')
                                                <i class="fas fa-bolt fa-lg text-warning"></i>
                                                @break
                                            @case('calculator')
                                                <i class="fas fa-calculator fa-lg text-info"></i>
                                                @break
                                            @case('steps')
                                                <i class="fas fa-shoe-prints fa-lg text-success"></i>
                                                @break
                                            @case('fire')
                                                <i class="fas fa-fire fa-lg text-danger"></i>
                                                @break
                                            @default
                                                <i class="fas fa-toolbox fa-lg text-secondary"></i>
                                        @endswitch
                                    </div>

                                    <div>
                                        <div class="h5 mb-0">{{ $tool['name'] }}</div>
                                        @if(!empty($tool['subtitle']))
                                            <small class="text-muted">{{ $tool['subtitle'] }}</small>
                                        @endif
                                    </div>
                                </div>

                                <div class="text-muted">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Small CSS tweak to match dark rounded cards -->
<style>
.tools-icon {
    width: 52px;
    height: 52px;
    background: rgba(255,255,255,0.02);
    border-radius: 10px;
}
.card.bg-dark {
    background: linear-gradient(180deg, rgba(23,23,23,1), rgba(18,18,18,1));
}
.page-title i { color: #ffc107; } /* keep yellow wrench icon like header */
</style>
@endsection
