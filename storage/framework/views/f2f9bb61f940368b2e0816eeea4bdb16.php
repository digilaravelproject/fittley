<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['route', 'title', 'image', 'badge' => null, 'meta' => []]));

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

foreach (array_filter((['route', 'title', 'image', 'badge' => null, 'meta' => []]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $fallbackImage = asset('storage/app/public/fitlive/banners/' . 'default-banner.jpg');
    $finalImage = !empty($image) ? $image : $fallbackImage;
?>


<div class="content-card-wrapper">

    
    <div class="content-card content-card-landscap" onclick="window.location.href='<?php echo e($route); ?>'">
        <?php if($badge): ?>
            <div class="status-badge <?php echo e($badge['class'] ?? 'badge-single'); ?>">
                <?php echo e($badge['label'] ?? ''); ?>

            </div>
        <?php endif; ?>

        <img loading="lazy" src="<?php echo e($finalImage); ?>" alt="<?php echo e($title); ?>" class="card-image">

        <div class="card-overlay">
            <div class="play-icon">
                <i class="fas fa-play"></i>
            </div>
        </div>
    </div>

    
    <div class="card-caption">
        <h3 class="card-title"><?php echo e($title); ?></h3>
    </div>

</div>
<?php /**PATH C:\xampp\htdocs\Digi_Laravel_Prrojects\Fittelly_github\fittley\resources\views/components/home/landscape-card.blade.php ENDPATH**/ ?>