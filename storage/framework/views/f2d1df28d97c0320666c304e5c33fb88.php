<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title',
    'image' => 'https://via.placeholder.com/300x450?text=No+Image',
    'type' => 'movie', // or 'series'
    'url' => '#',
    'duration' => null,
    'year' => null,
    'rating' => null,
    'description' => null,
    'badgeClass' => null,
]));

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

foreach (array_filter(([
    'title',
    'image' => 'https://via.placeholder.com/300x450?text=No+Image',
    'type' => 'movie', // or 'series'
    'url' => '#',
    'duration' => null,
    'year' => null,
    'rating' => null,
    'description' => null,
    'badgeClass' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>


<?php
    $typeText = ucfirst($type);
    // $badgeClass = $type === 'series' ? 'series-badge' : '';
?>

<div class="content-card" onclick="window.location.href='<?php echo e($url); ?>'">
    <div class="type-badge <?php echo e($badgeClass); ?>">
        <?php echo e(ucfirst($type)); ?>

    </div>
    <img src="<?php echo e($image); ?>" alt="<?php echo e($title); ?>" class="card-image" loading="lazy">
    <div class="card-overlay">
        <div class="play-icon"><i class="fas fa-play"></i></div>
    </div>
    <div class="card-content">
        <h3 class="card-title"><?php echo e($title); ?></h3>
        <div class="card-meta">
            <?php if($type === 'movie' && $duration): ?>
                <span><i class="fas fa-clock"></i> <?php echo e($duration); ?> min</span>
            <?php elseif($type === 'series'): ?>
                <span><i class="fas fa-list"></i> <?php echo e($duration ?? 'Multiple'); ?> Episodes</span>
            <?php endif; ?>
            <?php if($year): ?>
                <span><i class="fas fa-calendar"></i> <?php echo e($year); ?></span>
            <?php endif; ?>
            <?php if($rating): ?>
                <span><i class="fas fa-star"></i> <?php echo e(number_format($rating, 1)); ?></span>
            <?php endif; ?>
        </div>
        <p class="card-description"><?php echo e(Str::limit($description, 100)); ?></p>
    </div>
</div>
<?php /**PATH /home/u945294333/domains/purple-gaur-534336.hostingersite.com/public_html/resources/views/components/home/media-grid.blade.php ENDPATH**/ ?>