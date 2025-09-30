<?php $__env->startSection('title', 'FitGuide - Fitness Training Guides & Programs'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/home/css/fitdoc.index.css')); ?>?v=<?php echo e(time()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="fitdoc-container">

        
        <section class="hero-section">
            <div class="container-fluid">
                <div class="hero-content text-white">
                    <h1>FitGuide</h1>
                    <p>Master your fitness journey with comprehensive training guides, workout programs, and expert-led
                        series.</p>
                </div>
            </div>
        </section>

        <div class="container px-3 mt-1 mb-5">
            <!-- Filter Buttons for Categories -->
            <div class="filter-buttons">
                <button class="filter-btn <?php echo e(request('category') == null ? 'active' : ''); ?>" data-filter="all"
                    onclick="window.location.href='<?php echo e(route('fitguide.index')); ?>'">All Content</button>

                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button class="filter-btn <?php echo e(request('category') == $category->slug ? 'active' : ''); ?>"
                        data-filter="<?php echo e($category->slug); ?>"
                        onclick="window.location.href='<?php echo e(route('fitguide.index', ['category' => $category->slug])); ?>'">
                        <?php echo e($category->name); ?>

                    </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>


            <!-- Content Based on Category Selection -->
            <div class="filterable-content">
                <!-- Featured Quick Guides -->
                <?php if(isset($featuredSingles) && $featuredSingles->count() > 0): ?>
                    <section class="content-section" data-category="quick-guides">
                        <h2 class="section-title">Featured Quick Guides</h2>
                        <div class="media-grid-wrapper">
                            <?php $__currentLoopData = $featuredSingles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if (isset($component)) { $__componentOriginal3a8c1a2d94b1c50e899eb326aa5eda61 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3a8c1a2d94b1c50e899eb326aa5eda61 = $attributes; } ?>
<?php $component = App\View\Components\Home\MediaGrid::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.media-grid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Home\MediaGrid::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($single->title),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($single->banner_image_url ??
                                    'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3'),'url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('fitguide.single.show', $single->slug)),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('quick-guide'),'badgeClass' => 'type-badge','year' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(optional($single->created_at)->format('Y')),'rating' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(Str::limit($single->description ?? 'Training guide description', 100))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3a8c1a2d94b1c50e899eb326aa5eda61)): ?>
<?php $attributes = $__attributesOriginal3a8c1a2d94b1c50e899eb326aa5eda61; ?>
<?php unset($__attributesOriginal3a8c1a2d94b1c50e899eb326aa5eda61); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3a8c1a2d94b1c50e899eb326aa5eda61)): ?>
<?php $component = $__componentOriginal3a8c1a2d94b1c50e899eb326aa5eda61; ?>
<?php unset($__componentOriginal3a8c1a2d94b1c50e899eb326aa5eda61); ?>
<?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- Featured Training Series -->
                <?php if(isset($featuredSeries) && $featuredSeries->count() > 0): ?>
                    <section class="content-section" data-category="training-series">
                        <h2 class="section-title">Featured Training Series</h2>
                        <div class="media-grid-wrapper">
                            <?php $__currentLoopData = $featuredSeries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $series): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if (isset($component)) { $__componentOriginal3a8c1a2d94b1c50e899eb326aa5eda61 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3a8c1a2d94b1c50e899eb326aa5eda61 = $attributes; } ?>
<?php $component = App\View\Components\Home\MediaGrid::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.media-grid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Home\MediaGrid::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($series->title),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($series->banner_image_url ??
                                    'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3'),'url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('fitguide.series.show', $series->slug)),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('series'),'badgeClass' => 'series-badge','year' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(optional($series->created_at)->format('Y')),'rating' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(Str::limit($series->description ?? 'Training series description', 100))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3a8c1a2d94b1c50e899eb326aa5eda61)): ?>
<?php $attributes = $__attributesOriginal3a8c1a2d94b1c50e899eb326aa5eda61; ?>
<?php unset($__attributesOriginal3a8c1a2d94b1c50e899eb326aa5eda61); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3a8c1a2d94b1c50e899eb326aa5eda61)): ?>
<?php $component = $__componentOriginal3a8c1a2d94b1c50e899eb326aa5eda61; ?>
<?php unset($__componentOriginal3a8c1a2d94b1c50e899eb326aa5eda61); ?>
<?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- All Quick Guides -->
                <?php if(isset($allSingles) && $allSingles->count() > 0): ?>
                    <section class="content-section" data-category="quick-guides">
                        <h2 class="section-title">All Quick Guides</h2>
                        <div class="media-grid-wrapper">
                            <?php $__currentLoopData = $allSingles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if (isset($component)) { $__componentOriginal3a8c1a2d94b1c50e899eb326aa5eda61 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3a8c1a2d94b1c50e899eb326aa5eda61 = $attributes; } ?>
<?php $component = App\View\Components\Home\MediaGrid::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.media-grid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Home\MediaGrid::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($single->title),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($single->banner_image_url ??
                                    'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3'),'url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('fitguide.single.show', $single->slug)),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('quick-guide'),'badgeClass' => 'type-badge','year' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(optional($single->created_at)->format('Y')),'rating' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(Str::limit($single->description ?? 'Training guide description', 100))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3a8c1a2d94b1c50e899eb326aa5eda61)): ?>
<?php $attributes = $__attributesOriginal3a8c1a2d94b1c50e899eb326aa5eda61; ?>
<?php unset($__attributesOriginal3a8c1a2d94b1c50e899eb326aa5eda61); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3a8c1a2d94b1c50e899eb326aa5eda61)): ?>
<?php $component = $__componentOriginal3a8c1a2d94b1c50e899eb326aa5eda61; ?>
<?php unset($__componentOriginal3a8c1a2d94b1c50e899eb326aa5eda61); ?>
<?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- All Training Series -->
                <?php if(isset($allSeries) && $allSeries->count() > 0): ?>
                    <section class="content-section" data-category="training-series">
                        <h2 class="section-title">All Training Series</h2>
                        <div class="media-grid-wrapper">
                            <?php $__currentLoopData = $allSeries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $series): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if (isset($component)) { $__componentOriginal3a8c1a2d94b1c50e899eb326aa5eda61 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3a8c1a2d94b1c50e899eb326aa5eda61 = $attributes; } ?>
<?php $component = App\View\Components\Home\MediaGrid::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.media-grid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Home\MediaGrid::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($series->title),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($series->banner_image_url ??
                                    'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3'),'url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('fitguide.series.show', $series->slug)),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('series'),'badgeClass' => 'series-badge','year' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(optional($series->created_at)->format('Y')),'rating' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(Str::limit($series->description ?? 'Training series description', 100))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3a8c1a2d94b1c50e899eb326aa5eda61)): ?>
<?php $attributes = $__attributesOriginal3a8c1a2d94b1c50e899eb326aa5eda61; ?>
<?php unset($__attributesOriginal3a8c1a2d94b1c50e899eb326aa5eda61); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3a8c1a2d94b1c50e899eb326aa5eda61)): ?>
<?php $component = $__componentOriginal3a8c1a2d94b1c50e899eb326aa5eda61; ?>
<?php unset($__componentOriginal3a8c1a2d94b1c50e899eb326aa5eda61); ?>
<?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </section>
                <?php endif; ?>
            </div>

            <!-- Coming Soon Message if no content -->
            <?php if(
                !isset($error) &&
                    ((!isset($featuredSingles) || $featuredSingles->count() === 0) &&
                        (!isset($featuredSeries) || $featuredSeries->count() === 0) &&
                        (!isset($categories) || $categories->count() === 0))): ?>
                <section class="content-section">
                    <div class="text-center py-5">
                        <h2 style="color: #fff; margin-bottom: 1rem;">Coming Soon</h2>
                        <p style="color: #aaa; font-size: 1.1rem;">
                            Comprehensive training guides and workout programs are being prepared. Get ready to transform
                            your fitness journey!
                        </p>
                    </div>
                </section>
            <?php endif; ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const contentSections = document.querySelectorAll('.content-section[data-category]');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    const filter = this.getAttribute('data-filter');

                    contentSections.forEach(section => {
                        // Check if the category matches the filter
                        if (filter === 'all' || section.getAttribute('data-category') ===
                            filter) {
                            section.style.display = '';
                        } else {
                            section.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Digi_Laravel_Prrojects\Fittelly_github\fittley\resources\views/public/fitguide/index.blade.php ENDPATH**/ ?>