@extends('layouts.admin')

@section('title', 'View Badge - ' . $badge->name)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">View Badge</h1>
        <a href="{{ route('admin.community.badges.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Badges
        </a>
    </div>

    <!-- Badge Card -->
    <div class="card shadow mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{ $badge->name }}</h6>
            <span class="badge {{ $badge->is_active ? 'bg-success' : 'bg-danger' }}">
                {{ $badge->is_active ? 'Active' : 'Inactive' }}
            </span>
        </div>
        <div class="card-body row">
            <div class="col-md-4 text-center">
                @if($badge->icon)
                    <img src="{{ asset('storage/app/public/' . $badge->icon) }}" 
                         alt="{{ $badge->name }}" 
                         class="img-fluid mb-3 rounded shadow"
                         style="max-height: 200px;">
                @else
                    <p class="text-muted">No icon uploaded</p>
                @endif
            </div>
            <div class="col-md-8">
                <h4>{{ $badge->name }}</h4>
                <p>{{ $badge->description }}</p>

                <div class="mb-2">
                    <strong>Category:</strong> {{ ucfirst($badge->category) }}
                </div>
                <div class="mb-2">
                    <strong>Type:</strong> {{ str_replace('_', ' ', ucfirst($badge->type)) }}
                </div>
                <div class="mb-2">
                    <strong>Criteria:</strong> 
                    @if(is_array($badge->criteria))
                        <ul class="mb-0">
                            @foreach($badge->criteria as $crit)
                                <li>{{ $crit }}</li>
                            @endforeach
                        </ul>
                    @else
                        {{ $badge->criteria }}
                    @endif
                </div>
                <div class="mb-2">
                    <strong>Points:</strong> {{ $badge->points }}
                </div>
                <div class="mb-2">
                    <strong>Rarity:</strong> {{ ucfirst($badge->rarity) }}
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h5 class="text-muted">Total Earned</h5>
                    <h3>{{ $stats['total_earned'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h5 class="text-muted">Earned This Month</h5>
                    <h3>{{ $stats['earned_this_month'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h5 class="text-muted">Earned This Week</h5>
                    <h3>{{ $stats['earned_this_week'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Earners -->
    <div class="card shadow mt-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Recent Earners</h6>
        </div>
        <div class="card-body">
            @if($badge->userBadges->isEmpty())
                <p class="text-muted">No users have earned this badge yet.</p>
            @else
                <ul class="list-group">
                    @foreach($badge->userBadges as $userBadge)
                        <li class="list-group-item d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <img src="{{ $userBadge->user->avatar }}" 
                                     class="rounded-circle me-2" 
                                     style="width:40px; height:40px;">
                                <div>
                                    <strong>{{ $userBadge->user->name }}</strong>
                                    <small class="d-block text-muted">{{ $userBadge->user->email }}</small>
                                </div>
                            </div>
                            <span class="badge bg-info">
                                {{ $userBadge->earned_at ? $userBadge->earned_at->format('M d, Y H:i') : 'N/A' }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
