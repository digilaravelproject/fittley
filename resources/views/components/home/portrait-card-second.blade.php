@props(['video', 'badge' => null, 'badgeClass' => null, 'url'])
<div class="content-card-wrapper ccw-portrait">
<div class="content-card content-card-portrait" onclick="window.location.href='{{ route($url, $video) }}'">
    @if ($badge)
        <div class="status-badge {{ $badgeClass }}">{{ $badge }}</div>
    @endif

    @php
        // $fallbackImage = asset('storage/app/public/fitlive/banners/default-banner.jpg');
        $fallbackImage = asset('storage/app/public/fitlive/banners/default-banner.jpg');
        $finalImage = !empty($video->banner_image_path)
            ? $video->banner_image_path
            : $fallbackImage;
    @endphp

    <img src="{{ $finalImage }}" alt="{{ $video->title }}" class="card-image" loading="lazy">
    <div class="card-overlay">
        <div class="play-icon">
            <i class="fas fa-play"></i>
        </div>
    </div>
</div>
    <div class="card-caption">
        <h3 class="card-title">{{ $video->title }}</h3>

    </div>
</div>