@extends('layouts.app')

@section('title', 'My Badges')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">My Badges</h1>
        <p class="text-gray-600">Track your achievements and progress</p>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-trophy text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-800">{{ $userBadges->count() }}</h3>
                    <p class="text-gray-600">Badges Earned</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-star text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-800">{{ $totalPoints }}</h3>
                    <p class="text-gray-600">Total Points</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-chart-line text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-800">{{ $availableBadges->count() }}</h3>
                    <p class="text-gray-600">Available Badges</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tabs -->
    <div class="mb-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                <button onclick="showTab('earned')" 
                        class="tab-button py-2 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'earned' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <i class="fas fa-trophy mr-2"></i>
                    Earned Badges ({{ $userBadges->count() }})
                </button>
                <button onclick="showTab('available')" 
                        class="tab-button py-2 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'available' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <i class="fas fa-list mr-2"></i>
                    Available Badges ({{ $availableBadges->count() }})
                </button>
            </nav>
        </div>
    </div>
    
    <!-- Earned Badges Tab -->
    <div id="earned-tab" class="tab-content {{ $activeTab === 'earned' ? 'block' : 'hidden' }}">
        @if($userBadges->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($userBadges as $userBadge)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                        <div class="flex items-start space-x-4">
                            <x-badge-card :userBadge="$userBadge" size="large" />
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800 mb-1">{{ $userBadge->badge->name }}</h3>
                                <p class="text-sm text-gray-600 mb-2">{{ $userBadge->badge->description }}</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-500">
                                        Earned {{ $userBadge->earned_at->diffForHumans() }}
                                    </span>
                                    @if($userBadge->badge->points > 0)
                                        <span class="text-xs font-medium text-yellow-600">
                                            {{ $userBadge->badge->points }} points
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-24 h-24 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                    <i class="fas fa-trophy text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-800 mb-2">No badges earned yet</h3>
                <p class="text-gray-600 mb-6">Start participating in the community to earn your first badge!</p>
                <a href="#available" onclick="showTab('available')" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-list mr-2"></i>
                    View Available Badges
                </a>
            </div>
        @endif
    </div>
    
    <!-- Available Badges Tab -->
    <div id="available-tab" class="tab-content {{ $activeTab === 'available' ? 'block' : 'hidden' }}">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($availableBadges as $badge)
                <x-badge-progress :badge="$badge" :user="auth()->user()" :showDetails="true" />
            @endforeach
        </div>
    </div>
</div>

<script>
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
        tab.classList.remove('block');
    });
    
    // Remove active class from all buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab
    document.getElementById(tabName + '-tab').classList.remove('hidden');
    document.getElementById(tabName + '-tab').classList.add('block');
    
    // Add active class to clicked button
    event.target.classList.remove('border-transparent', 'text-gray-500');
    event.target.classList.add('border-blue-500', 'text-blue-600');
}
</script>
@endsection
