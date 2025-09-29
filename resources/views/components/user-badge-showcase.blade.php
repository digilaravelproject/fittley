@props([
    'user' => null,
    'showAll' => false,
    'limit' => 6,
    'title' => 'Badges Earned'
])

@php
    $user = $user ?? auth()->user();
    $userBadges = $user->userBadges()
        ->with('badge')
        ->where('is_visible', true)
        ->orderBy('earned_at', 'desc')
        ->when(!$showAll, fn($q) => $q->limit($limit))
        ->get();
    
    $totalBadges = $user->userBadges()->count();
    $totalPoints = $user->userBadges()->with('badge')->get()->sum('badge.points');
@endphp

<div class="user-badge-showcase bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">{{ $title }}</h3>
            <p class="text-sm text-gray-600">
                {{ $totalBadges }} badge{{ $totalBadges !== 1 ? 's' : '' }} earned
                @if($totalPoints > 0)
                    • {{ $totalPoints }} total points
                @endif
            </p>
        </div>
        
        @if($totalBadges > $limit && !$showAll)
            <button onclick="showAllBadges()" 
                    class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                View All
            </button>
        @endif
    </div>
    
    <!-- Badges Grid -->
    @if($userBadges->count() > 0)
        <div class="grid grid-cols-6 gap-3" id="badges-grid">
            @foreach($userBadges as $userBadge)
                <x-badge-card :userBadge="$userBadge" size="medium" />
            @endforeach
        </div>
        
        <!-- Empty slots for visual balance -->
        @if($userBadges->count() < 6)
            @for($i = $userBadges->count(); $i < 6; $i++)
                <div class="w-16 h-16 rounded-full bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center">
                    <i class="fas fa-plus text-gray-400"></i>
                </div>
            @endfor
        @endif
    @else
        <!-- Empty State -->
        <div class="text-center py-8">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                <i class="fas fa-trophy text-gray-400 text-2xl"></i>
            </div>
            <h4 class="text-gray-600 font-medium mb-2">No badges earned yet</h4>
            <p class="text-sm text-gray-500 mb-4">
                Start participating in the community to earn your first badge!
            </p>
            <a href="{{ route('community.badges') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-trophy mr-2"></i>
                View Available Badges
            </a>
        </div>
    @endif
</div>

@if($totalBadges > $limit && !$showAll)
<script>
function showAllBadges() {
    // This would typically load more badges via AJAX or redirect to a full page
    window.location.href = "{{ route('user.badges.index', $user->id) }}";
}
</script>
@endif
