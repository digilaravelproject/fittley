<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['video', 'badge' => null, 'badgeClass' => null, 'url']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['video', 'badge' => null, 'badgeClass' => null, 'url']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div class="content-card" onclick="window.location.href='<?php echo e(route($url, $video)); ?>'">
    <?php if($badge): ?>
        <div class="status-badge <?php echo e($badgeClass); ?>"><?php echo e($badge); ?></div>
    <?php endif; ?>

    <?php
        // $fallbackImage = asset('storage/app/public/fitlive/banners/default-banner.jpg');
        $fallbackImage = asset('storage/app/public/fitlive/banners/default-banner.jpg');
        $finalImage = !empty($video->banner_image_path)
            ? asset('storage/app/public/' . $video->banner_image_path)
            : $fallbackImage;
    ?>

    <img src="<?php echo e($finalImage); ?>" alt="<?php echo e($video->title); ?>" class="card-image" loading="lazy">
    <div class="card-overlay">
        <div class="play-icon">
            <i class="fas fa-play"></i>
        </div>
    </div>
    <div class="card-content">
        <h3 class="card-title"><?php echo e($video->title); ?></h3>
        <div class="card-meta">
            <span><i class="fas fa-calendar"></i>
                <?php echo e($video->created_at ? $video->created_at->format('Y') : 'New'); ?></span>
            <span><i class="fas fa-clock"></i> <?php echo e($video->duration_minutes ?? 90); ?> min</span>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\fittley\resources\views/components/home/portrait-card.blade.php ENDPATH**/ ?>