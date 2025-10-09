@props(['video', 'badge' => null, 'badgeClass' => null, 'categorySlug' => null, 'landscapeCard' => null, 'url'])
<div class="content-card-wrapper ccw-portrait">
    <div class="content-card content-card-portrait"
        onclick="window.location.href='{{ $categorySlug ? route($url, ['category' => $categorySlug]) : route($url, $video) }}'">
        @if ($badge)
            <div class="status-badge {{ $badgeClass }}">
                {{ $badge }}
            </div>
        @endif
        @php
            $fallbackImage = asset('storage/app/public/fitlive/banners/default-banner.jpg');

            // Smartly decide final image path
            if (!empty($video->banner_image_path)) {
                // If accessor or manually set path is available
                $finalImage = asset('storage/app/public/' . $video->banner_image_path);
            } elseif (!empty($video->banner_image)) {
                // If only banner_image is set, build full path
                $finalImage = asset('storage/app/public/' . $video->banner_image);
            } else {
                // Fallback to default
                $finalImage = $fallbackImage;
            }
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