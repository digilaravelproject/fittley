@props([
'title',
'image' => 'https://via.placeholder.com/300x450?text=No+Image',
'type' => 'movie', // or 'series'
'url' => '#',
'duration' => null,
'year' => null,
'rating' => null,
'description' => null,
'badgeClass' => null,
])


@php
$typeText = ucfirst($type);
// $badgeClass = $type === 'series' ? 'series-badge' : '';
@endphp
<div class="content-card-wrapper ccw-portrait">
    <div class="content-card" onclick="window.location.href='{{ $url }}'">
        <div class="type-badge {{ $badgeClass }}">
            {{ ucfirst($type) }}
        </div>
        <img src="{{ $image }}" alt="{{ $title }}" class="card-image" loading="lazy">
        <div class="card-overlay">
            <div class="play-icon"><i class="fas fa-play"></i></div>
        </div>
    </div>
    <div class="card-caption">
        <h3 class="card-title">{{ $title }}</h3>
        {{-- <div class="card-meta">
            @if ($type === 'movie' && $duration)
            <span><i class="fas fa-clock"></i> {{ $duration }} min</span>
            @elseif ($type === 'series')
            <span><i class="fas fa-list"></i> {{ $duration ?? 'Multiple' }} Episodes</span>
            @endif
            @if ($year)
            <span><i class="fas fa-calendar"></i> {{ $year }}</span>
            @endif
            @if ($rating)
            <span><i class="fas fa-star"></i> {{ number_format($rating, 1) }}</span>
            @endif
        </div>
        <p class="card-description">{{ Str::limit($description, 100) }}</p> --}}
    </div>

</div>