@props(['route', 'title', 'image', 'badge' => null, 'meta' => []])


@php
    $fallbackImage = asset('storage/app/public/fitlive/banners/' . 'default-banner.jpg');
    $finalImage = !empty($image) ? $image : $fallbackImage;
@endphp

<div class="content-card content-card-landscap" onclick="window.location.href='{{ $route }}'">
    @if ($badge)
        <div class="status-badge {{ $badge['class'] ?? 'badge-single' }}">
            {{ $badge['label'] ?? '' }}
        </div>
    @endif

    <img loading="lazy" src="{{ $finalImage }}" alt="{{ $title }}" class="card-image">

    <div class="card-overlay">
        <div class="play-icon">
            <i class="fas fa-play"></i>
        </div>
    </div>

    <div class="card-content">
        <h3 class="card-title">{{ $title }}</h3>
        {{-- @if (!empty($meta))
            <div class="card-meta">
                @foreach ($meta as $item)
                    <span class="meta-item">{{ $item }}</span>
                @endforeach
            </div>
        @endif --}}

    </div>
</div>
