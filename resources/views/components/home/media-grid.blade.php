<style>
    /* Default portrait layout (already exists) */
/* Landscape mode for grid */
@media (min-width: 992px) {
    .media-grid-wrapper.landscape {
        display: grid;
        gap: 1rem;
        grid-template-columns: repeat(4, 1fr);
    }
}

@media (max-width: 767px) {
    .media-grid-wrapper.landscape {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Landscape aspect ratio */
.content-card.landscape {
    aspect-ratio: 16 / 9;
}

</style>
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
'class' => null,
])


@php
$typeText = ucfirst($type);
// $badgeClass = $type === 'series' ? 'series-badge' : '';
//  $isLandscape = $class === 'landscape';
@endphp
<div class="content-card-wrapper ccw-portrait {{ $class}}">
    <div class="content-card {{ $class}}" onclick="window.location.href='{{ $url }}'">
        @if($badgeClass)
        <div class="type-badge {{ $badgeClass }}">
            {{ ucfirst($type) }}
        </div>
        @endif
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
