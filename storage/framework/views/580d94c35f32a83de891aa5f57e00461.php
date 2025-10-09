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
            <!-- Error Message if there's an error -->
            <?php if(isset($error)): ?>
                <div class="content-section">
                    <div class="text-center">
                        <h3 style="color: #e50914;">Error: <?php echo e($error); ?></h3>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Featured Singles -->
            <?php if(isset($featuredSingles) && $featuredSingles->count() > 0): ?>

                <section class="content-section" data-type="live">
                    <h2 class="section-title">
                        Featured Quick Guides
                    </h2>
                    <div class="media-grid-wrapper">
                        <?php $__currentLoopData = $featuredSingles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if (isset($component)) { $__componentOriginalc758cb2babd8d0e77fd718754f273bf5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc758cb2babd8d0e77fd718754f273bf5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.media-grid','data' => ['title' => $single->title,'image' => $single->banner_image_url
                                ? $single->banner_image_url
                                : 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3','url' => route('fitguide.single.show', $single->slug),'type' => 'quick-guide','badgeClass' => 'type-badge','year' => optional($single->created_at)->format('Y'),'rating' => null,'description' => Str::limit($single->description ?? 'Training guide description', 100)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.media-grid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($single->title),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($single->banner_image_url
                                ? $single->banner_image_url
                                : 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3'),'url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('fitguide.single.show', $single->slug)),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('quick-guide'),'badgeClass' => 'type-badge','year' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(optional($single->created_at)->format('Y')),'rating' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(Str::limit($single->description ?? 'Training guide description', 100))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc758cb2babd8d0e77fd718754f273bf5)): ?>
<?php $attributes = $__attributesOriginalc758cb2babd8d0e77fd718754f273bf5; ?>
<?php unset($__attributesOriginalc758cb2babd8d0e77fd718754f273bf5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc758cb2babd8d0e77fd718754f273bf5)): ?>
<?php $component = $__componentOriginalc758cb2babd8d0e77fd718754f273bf5; ?>
<?php unset($__componentOriginalc758cb2babd8d0e77fd718754f273bf5); ?>
<?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </section>
            <?php endif; ?>


            <!-- Featured Series -->
            <?php if(isset($featuredSeries) && $featuredSeries->count() > 0): ?>
                <section class="content-section" data-type="series">
                    <h2 class="section-title">
                        Featured Training Series
                    </h2>
                    <div class="media-grid-wrapper">
                        <?php $__currentLoopData = $featuredSeries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $series): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if (isset($component)) { $__componentOriginalc758cb2babd8d0e77fd718754f273bf5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc758cb2babd8d0e77fd718754f273bf5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.media-grid','data' => ['title' => $series->title,'image' => $series->banner_image_url ??
                                'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3','url' => route('fitguide.series.show', $series->slug),'type' => 'series','badgeClass' => 'series-badge','year' => optional($series->created_at)->format('Y'),'rating' => null,'description' => Str::limit($series->description ?? 'Training series description', 100)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.media-grid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($series->title),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($series->banner_image_url ??
                                'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3'),'url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('fitguide.series.show', $series->slug)),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('series'),'badgeClass' => 'series-badge','year' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(optional($series->created_at)->format('Y')),'rating' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(Str::limit($series->description ?? 'Training series description', 100))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc758cb2babd8d0e77fd718754f273bf5)): ?>
<?php $attributes = $__attributesOriginalc758cb2babd8d0e77fd718754f273bf5; ?>
<?php unset($__attributesOriginalc758cb2babd8d0e77fd718754f273bf5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc758cb2babd8d0e77fd718754f273bf5)): ?>
<?php $component = $__componentOriginalc758cb2babd8d0e77fd718754f273bf5; ?>
<?php unset($__componentOriginalc758cb2babd8d0e77fd718754f273bf5); ?>
<?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </section>
            <?php endif; ?>


            <!-- All Quick Guides -->
            <?php if(isset($allSingles) && $allSingles->count() > 0): ?>
                <section class="content-section" data-type="quick-guides">
                    <h2 class="section-title">
                        All Quick Guides
                    </h2>
                    <div class="media-grid-wrapper">
                        <?php $__currentLoopData = $allSingles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if (isset($component)) { $__componentOriginalc758cb2babd8d0e77fd718754f273bf5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc758cb2babd8d0e77fd718754f273bf5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.media-grid','data' => ['title' => $single->title,'image' => $single->banner_image_url ??
                                'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3','url' => route('fitguide.single.show', $single->slug),'type' => 'quick-guide','badgeClass' => 'type-badge','year' => optional($single->created_at)->format('Y'),'rating' => null,'description' => Str::limit($single->description ?? 'Training guide description', 100)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.media-grid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($single->title),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($single->banner_image_url ??
                                'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3'),'url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('fitguide.single.show', $single->slug)),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('quick-guide'),'badgeClass' => 'type-badge','year' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(optional($single->created_at)->format('Y')),'rating' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(Str::limit($single->description ?? 'Training guide description', 100))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc758cb2babd8d0e77fd718754f273bf5)): ?>
<?php $attributes = $__attributesOriginalc758cb2babd8d0e77fd718754f273bf5; ?>
<?php unset($__attributesOriginalc758cb2babd8d0e77fd718754f273bf5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc758cb2babd8d0e77fd718754f273bf5)): ?>
<?php $component = $__componentOriginalc758cb2babd8d0e77fd718754f273bf5; ?>
<?php unset($__componentOriginalc758cb2babd8d0e77fd718754f273bf5); ?>
<?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </section>
            <?php endif; ?>
            <!-- All Training Series -->
            <?php if(isset($allSeries) && $allSeries->count() > 0): ?>
                <section class="content-section" data-type="training-series">
                    <h2 class="section-title">
                        All Training Series
                    </h2>
                    <div class="media-grid-wrapper">
                        <?php $__currentLoopData = $allSeries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $series): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if (isset($component)) { $__componentOriginalc758cb2babd8d0e77fd718754f273bf5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc758cb2babd8d0e77fd718754f273bf5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.media-grid','data' => ['title' => $series->title,'image' => $series->banner_image_url ??
                                'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3','url' => route('fitguide.series.show', $series->slug),'type' => 'series','badgeClass' => 'series-badge','year' => optional($series->created_at)->format('Y'),'rating' => null,'description' => Str::limit($series->description ?? 'Training series description', 100)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.media-grid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($series->title),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($series->banner_image_url ??
                                'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3'),'url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('fitguide.series.show', $series->slug)),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('series'),'badgeClass' => 'series-badge','year' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(optional($series->created_at)->format('Y')),'rating' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(Str::limit($series->description ?? 'Training series description', 100))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc758cb2babd8d0e77fd718754f273bf5)): ?>
<?php $attributes = $__attributesOriginalc758cb2babd8d0e77fd718754f273bf5; ?>
<?php unset($__attributesOriginalc758cb2babd8d0e77fd718754f273bf5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc758cb2babd8d0e77fd718754f273bf5)): ?>
<?php $component = $__componentOriginalc758cb2babd8d0e77fd718754f273bf5; ?>
<?php unset($__componentOriginalc758cb2babd8d0e77fd718754f273bf5); ?>
<?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </section>
            <?php endif; ?>


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

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/purple-gaur-534336.hostingersite.com/public_html/resources/views/public/fitguide/index.blade.php ENDPATH**/ ?>