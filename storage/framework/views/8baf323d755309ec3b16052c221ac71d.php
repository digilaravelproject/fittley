<?php $__env->startSection('title', 'FitDoc - Fitness Documentaries & Series'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/home/css/fitdoc.index.css')); ?>?v=<?php echo e(time()); ?> ">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="fitdoc-container">
        <section class="hero-section">
            <div class="container-fluid">
                <div class="hero-content">
                    <h1>FitDoc</h1>
                    <p>Discover inspiring fitness documentaries, training series, and educational content...</p>
                </div>
            </div>
        </section>

        <div class="container px-3 mt-1 mb-5">
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">All Content</button>
                <button class="filter-btn" data-filter="movie">Movies</button>
                <button class="filter-btn" data-filter="series">Series</button>
            </div>

            <?php if($featuredSingles && $featuredSingles->count() > 0): ?>
                <section class="content-section" data-type="movie">
                    <h2 class="section-title">Featured Movies</h2>
                    <div class="media-grid-wrapper">
                        <?php $__currentLoopData = $featuredSingles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if (isset($component)) { $__componentOriginalc758cb2babd8d0e77fd718754f273bf5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc758cb2babd8d0e77fd718754f273bf5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.media-grid','data' => ['title' => $single->title,'image' => $single->banner_image_url,'type' => 'movie','url' => route('fitdoc.single.show', $single->slug),'duration' => $single->duration_minutes,'badgeClass' => 'movie-badge','year' => $single->release_date?->format('Y'),'rating' => $single->feedback,'description' => $single->description]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.media-grid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($single->title),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($single->banner_image_url),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('movie'),'url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('fitdoc.single.show', $single->slug)),'duration' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($single->duration_minutes),'badgeClass' => 'movie-badge','year' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($single->release_date?->format('Y')),'rating' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($single->feedback),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($single->description)]); ?>
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

            <?php if($featuredSeries && $featuredSeries->count() > 0): ?>
                <section class="content-section" data-type="series">
                    <h2 class="section-title">Featured Series</h2>
                    <div class="media-grid-wrapper">
                        <?php $__currentLoopData = $featuredSeries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $series): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if (isset($component)) { $__componentOriginalc758cb2babd8d0e77fd718754f273bf5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc758cb2babd8d0e77fd718754f273bf5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.media-grid','data' => ['title' => $series->title,'image' => $series->banner_image_url,'type' => 'series','url' => route('fitdoc.series.show', $series->slug),'duration' => $series->total_episodes,'badgeClass' => 'series-badge','year' => $series->release_date?->format('Y'),'rating' => $series->feedback,'description' => $series->description]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.media-grid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($series->title),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($series->banner_image_url),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('series'),'url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('fitdoc.series.show', $series->slug)),'duration' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($series->total_episodes),'badgeClass' => 'series-badge','year' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($series->release_date?->format('Y')),'rating' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($series->feedback),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($series->description)]); ?>
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

            <?php if((!$featuredSingles || $featuredSingles->count() === 0) && (!$featuredSeries || $featuredSeries->count() === 0)): ?>
                <section class="content-section">
                    <div class="text-center py-5">
                        <i class="fas fa-film"
                            style="font-size: 4rem; color: var(--fittelly-orange); margin-bottom: 2rem;"></i>
                        <h2 style="color: var(--netflix-white); margin-bottom: 1rem;">Coming Soon</h2>
                        <p style="color: var(--netflix-light-gray); font-size: 1.1rem;">
                            Amazing fitness documentaries and series are on their way. Stay tuned!
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
            const contentSections = document.querySelectorAll('.content-section[data-type]');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    const filter = this.getAttribute('data-filter');

                    contentSections.forEach(section => {
                        if (filter === 'all' || section.getAttribute('data-type') ===
                            filter) {
                            section.style.display = '';
                        } else {
                            section.style.display = 'none';
                        }
                    });
                });
            });

            // clickable card
            document.querySelectorAll('.content-card').forEach(card => {
                card.addEventListener('click', function() {
                    const onclickAttr = card.getAttribute('onclick');
                    if (onclickAttr) {
                        const match = onclickAttr.match(/window\.location\.href='([^']+)'/);
                        if (match && match[1]) {
                            window.location.href = match[1];
                        }
                    }
                });
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/purple-gaur-534336.hostingersite.com/public_html/resources/views/public/fitdoc/index.blade.php ENDPATH**/ ?>