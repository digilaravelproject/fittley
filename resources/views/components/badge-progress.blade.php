@props([
    'badge' => null,
    'user' => null,
    'showDetails' => false
])

@php
    $user = $user ?? auth()->user();
    $progress = app(\App\Services\BadgeService::class)->getBadgeProgress($user, $badge);
    $overallProgress = collect($progress)->avg('percentage') ?? 0;
    $isEarned = $user->userBadges()->where('badge_id', $badge->id)->exists();
@endphp

<div class="badge-progress bg-white rounded-lg border border-gray-200 p-4 {{ $isEarned ? 'bg-green-50 border-green-200' : '' }}">
    <!-- Badge Header -->
    <div class="flex items-center space-x-3 mb-3">
        <!-- Badge Icon -->
        <div class="w-12 h-12 rounded-full overflow-hidden flex-shrink-0
                    {{ $isEarned ? 'ring-2 ring-green-400' : 'bg-gray-100' }}">
            @if($badge->image_path)
                <img src="{{ asset('storage/app/public/' . $badge->image_path) }}" 
                     alt="{{ $badge->name }}"
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center"
                     style="background-color: {{ $badge->color ?? '#3B82F6' }}">
                    <i class="fas fa-trophy text-white"></i>
                </div>
            @endif
        </div>
        
        <!-- Badge Info -->
        <div class="flex-1 min-w-0">
            <h4 class="font-semibold text-gray-800 truncate">
                {{ $badge->name }}
                @if($isEarned)
                    <i class="fas fa-check-circle text-green-500 ml-1"></i>
                @endif
            </h4>
            <p class="text-sm text-gray-600 truncate">{{ $badge->description }}</p>
            @if($badge->points > 0)
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                    {{ $badge->points }} points
                </span>
            @endif
        </div>
    </div>
    
    <!-- Progress Bar -->
    <div class="mb-3">
        <div class="flex justify-between items-center mb-1">
            <span class="text-sm font-medium text-gray-700">Progress</span>
            <span class="text-sm text-gray-600">{{ round($overallProgress, 1) }}%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-blue-500 h-2 rounded-full transition-all duration-500 {{ $isEarned ? 'bg-green-500' : '' }}" 
                 style="width: {{ $overallProgress }}%"></div>
        </div>
    </div>
    
    <!-- Detailed Progress (if enabled) -->
    @if($showDetails && !empty($progress))
        <div class="space-y-2">
            @foreach($progress as $criterion => $data)
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-600 capitalize">
                        {{ str_replace('_', ' ', $criterion) }}
                    </span>
                    <div class="flex items-center space-x-2">
                        <span class="text-gray-800">
                            {{ $data['current'] }} / {{ $data['target'] }}
                        </span>
                        <div class="w-16 bg-gray-200 rounded-full h-1.5">
                            <div class="bg-blue-400 h-1.5 rounded-full" 
                                 style="width: {{ $data['percentage'] }}%"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    
    <!-- Status Message -->
    @if($isEarned)
        <div class="mt-3 p-2 bg-green-100 text-green-800 rounded-md text-sm">
            <i class="fas fa-check-circle mr-1"></i>
            Badge earned! Great job!
        </div>
    @elseif($overallProgress > 0)
        <div class="mt-3 p-2 bg-blue-100 text-blue-800 rounded-md text-sm">
            <i class="fas fa-clock mr-1"></i>
            Keep going! You're {{ round($overallProgress, 1) }}% of the way there.
        </div>
    @else
        <div class="mt-3 p-2 bg-gray-100 text-gray-600 rounded-md text-sm">
            <i class="fas fa-info-circle mr-1"></i>
            Start participating to earn this badge.
        </div>
    @endif
</div>
