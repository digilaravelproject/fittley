@props([
    'badge' => null,
    'userBadge' => null,
    'showProgress' => false,
    'size' => 'medium' // small, medium, large
])

@php
    $sizeClasses = [
        'small' => 'w-12 h-12',
        'medium' => 'w-16 h-16', 
        'large' => 'w-20 h-20'
    ];
    
    $textSizeClasses = [
        'small' => 'text-xs',
        'medium' => 'text-sm',
        'large' => 'text-base'
    ];
    
    $isEarned = $userBadge !== null;
    $badgeData = $badge ?? $userBadge?->badge;
@endphp

<div class="badge-card {{ $sizeClasses[$size] }} relative group cursor-pointer" 
     @if($badgeData) title="{{ $badgeData->name }} - {{ $badgeData->description }}" @endif>
    
    <!-- Badge Image/Icon -->
    <div class="badge-image {{ $sizeClasses[$size] }} rounded-full overflow-hidden 
                {{ $isEarned ? 'ring-2 ring-yellow-400 shadow-lg' : 'opacity-60' }}
                bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center
                transition-all duration-300 group-hover:scale-110">
        
        @if($badgeData?->image_path)
            <img src="{{ asset('storage/app/public/' . $badgeData->image_path) }}" 
                 alt="{{ $badgeData->name }}"
                 class="w-full h-full object-cover">
        @elseif($badgeData?->icon)
            <i class="{{ $badgeData->icon }} text-2xl" 
               style="color: {{ $badgeData->color ?? '#3B82F6' }}"></i>
        @else
            <div class="w-full h-full flex items-center justify-center"
                 style="background-color: {{ $badgeData->color ?? '#3B82F6' }}">
                <i class="fas fa-trophy text-white text-xl"></i>
            </div>
        @endif
        
        <!-- Earned indicator -->
        @if($isEarned)
            <div class="absolute -top-1 -right-1 w-4 h-4 bg-yellow-400 rounded-full flex items-center justify-center">
                <i class="fas fa-check text-white text-xs"></i>
            </div>
        @endif
    </div>
    
    <!-- Badge Info (shown on hover for small/medium) -->
    @if($size !== 'small' || $showProgress)
        <div class="badge-info mt-2 text-center {{ $textSizeClasses[$size] }}">
            <div class="font-semibold text-gray-800 truncate">
                {{ $badgeData?->name ?? 'Unknown Badge' }}
            </div>
            
            @if($badgeData?->points > 0)
                <div class="text-yellow-600 font-medium">
                    {{ $badgeData->points }} pts
                </div>
            @endif
            
            @if($isEarned && $userBadge?->earned_at)
                <div class="text-xs text-gray-500">
                    Earned {{ $userBadge->earned_at->diffForHumans() }}
                </div>
            @endif
        </div>
    @endif
    
    <!-- Progress Bar (if enabled) -->
    @if($showProgress && $badgeData && !$isEarned)
        @php
            $progress = app(\App\Services\BadgeService::class)->getBadgeProgress(auth()->user(), $badgeData);
            $overallProgress = collect($progress)->avg('percentage') ?? 0;
        @endphp
        
        <div class="progress-container mt-1">
            <div class="w-full bg-gray-200 rounded-full h-1.5">
                <div class="bg-blue-500 h-1.5 rounded-full transition-all duration-500" 
                     style="width: {{ $overallProgress }}%"></div>
            </div>
            <div class="text-xs text-gray-500 mt-1">
                {{ round($overallProgress, 1) }}% complete
            </div>
        </div>
    @endif
</div>
