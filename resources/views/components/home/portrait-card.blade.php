@props(['video', 'badge' => null, 'badgeClass' => null, 'url'])

<div class="content-card" onclick="window.location.href='{{ route($url, $video) }}'">
    @if ($badge)
        <div class="status-badge {{ $badgeClass }}">{{ $badge }}</div>
    @endif

    @php
        // $fallbackImage = asset('storage/app/public/fitlive/banners/default-banner.jpg');
        $fallbackImage = asset('storage/app/public/fitlive/banners/default-banner.jpg');
        $finalImage = !empty($video->banner_image_path)
            ? asset('storage/app/public/' . $video->banner_image_path)
            : $fallbackImage;
    @endphp

    <img src="{{ $finalImage }}" alt="{{ $video->title }}" class="card-image" loading="lazy">
    <div class="card-overlay">
        <div class="play-icon">
            <i class="fas fa-play"></i>
        </div>
    </div>
    <div class="card-content">
        <h3 class="card-title">{{ $video->title }}</h3>
        <div class="card-meta">
            <span><i class="fas fa-calendar"></i>
                {{ $video->created_at ? $video->created_at->format('Y') : 'New' }}</span>
            <span><i class="fas fa-clock"></i> {{ $video->duration_minutes ?? 90 }} min</span>
        </div>
    </div>
</div>
