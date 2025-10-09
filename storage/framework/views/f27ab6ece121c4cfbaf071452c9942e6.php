<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['video', 'badge' => null, 'badgeClass' => null, 'categorySlug' => null,'landscapeCard' => null, 'url']));

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

foreach (array_filter((['video', 'badge' => null, 'badgeClass' => null, 'categorySlug' => null,'landscapeCard' => null, 'url']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<div class="content-card-wrapper ccw-portrait">
    <div class="content-card content-card-portrait"
        onclick="window.location.href='<?php echo e($categorySlug ? route($url, ['category' => $categorySlug]) : route($url, $video)); ?>'">
    <?php if($badge): ?>
        <div class="status-badge <?php echo e($badgeClass); ?>">
            <?php echo e($badge); ?>

        </div>
    <?php endif; ?>
        <?php
            $fallbackImage = asset('storage/app/public/fitlive/banners/default-banner.jpg');

            // Smartly decide final image path
            if (!empty($video->banner_image_path)) {
                // If accessor or manually set path is available
                $finalImage = asset('storage/app/public/' .$video->banner_image_path);
            } elseif (!empty($video->banner_image)) {
                // If only banner_image is set, build full path
                $finalImage = asset('storage/app/public/' . $video->banner_image);
            } else {
                // Fallback to default
                $finalImage = $fallbackImage;
            }
        ?>
    <!--<?php-->
    <!--    // Determine the final image path-->
    <!--    $fallbackImage = asset('storage/app/public/fitlive/banners/default-banner.jpg');-->
    <!--    $finalImage = !empty($video->banner_image_path)-->
    <!--        ? asset('storage/app/public/' . $video->banner_image_path)-->
    <!--        : $fallbackImage;-->
    <!--?>-->

    <img src="<?php echo e($finalImage); ?>" alt="<?php echo e($video->title); ?>" class="card-image" loading="lazy">

    <div class="card-overlay">
        <div class="play-icon">
            <i class="fas fa-play"></i>
        </div>
    </div>
    </div>

    <div class="card-caption">
        <h3 class="card-title"><?php echo e($video->title); ?></h3>
    </div>
</div><?php /**PATH /home/u945294333/domains/fittelly.com/public_html/resources/views/components/home/portrait-card.blade.php ENDPATH**/ ?>