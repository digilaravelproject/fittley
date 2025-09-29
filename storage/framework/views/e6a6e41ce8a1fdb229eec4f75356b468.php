<?php $__env->startSection('title', 'FitLive - Live Fitness Sessions'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/home/css/fitdoc.index.css')); ?>?v=<?php echo e(time()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="fitdoc-container">
        
        <section class="hero-section">
            <div class="container-fluid">
                <div class="hero-content">
                    <h1>FitLive</h1>
                    <p>Join live fitness sessions with expert instructors</p>

                    <?php if($liveSession): ?>
                        <div class="live-now-alert">

                            <strong><?php echo e($liveSession->title); ?></strong> is live now!
                            <a href="<?php echo e(route('fitlive.session', $liveSession)); ?>" class="btn btn-light btn-sm ms-2">Join
                                Now</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <div class="container px-3 mt-1 mb-5">

            
            <?php if($liveSessions->count() > 0): ?>
                <section class="content-section" data-type="live">
                    <h2 class="section-title">
                        Live Now
                    </h2>
                    <div class="media-grid-wrapper">
                        <?php $__currentLoopData = $liveSessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if (isset($component)) { $__componentOriginal3a8c1a2d94b1c50e899eb326aa5eda61 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3a8c1a2d94b1c50e899eb326aa5eda61 = $attributes; } ?>
<?php $component = App\View\Components\Home\MediaGrid::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.media-grid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Home\MediaGrid::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($session->title),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($session->banner_image ? asset('storage/app/public/'.$session->banner_image) : null),'url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('fitlive.session', $session)),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('live'),'duration' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null),'year' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null),'rating' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($session->viewer_peak),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('By ' . $session->instructor->name),'badgeClass' => 'live-badge']); ?>
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

            
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $categoryUpcoming = $upcomingSessions->where('category_id', $category->id);
                    $categoryRecent = $recentSessions->where('category_id', $category->id);
                ?>

                <?php if($categoryUpcoming->count() > 0 || $categoryRecent->count() > 0): ?>
                    <section class="content-section">
                        <h3 class="section-title">
                            <?php echo e($category->name); ?>

                        </h3>

                        
                        <?php if($categoryUpcoming->count() > 0): ?>
                            <h5 class="text-warning mb-3">Upcoming Sessions</h5>
                            <div class="media-grid-wrapper mb-4">
                                <?php $__currentLoopData = $categoryUpcoming; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if (isset($component)) { $__componentOriginal3a8c1a2d94b1c50e899eb326aa5eda61 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3a8c1a2d94b1c50e899eb326aa5eda61 = $attributes; } ?>
<?php $component = App\View\Components\Home\MediaGrid::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.media-grid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Home\MediaGrid::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($session->title),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($session->banner_image ? asset('storage/app/public/'.$session->banner_image) : null),'url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('fitlive.session', $session)),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('upcoming'),'duration' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null),'year' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($session->scheduled_at->format('Y')),'rating' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null),'badgeClass' => 'upcoming-badge','description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('By ' .
                                            $session->instructor->name .
                                            ' | ' .
                                            $session->scheduled_at->format('M d, g:i A'))]); ?>
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
                        <?php endif; ?>

                        
                        <?php if($categoryRecent->count() > 0): ?>
                            <h5 class="text-secondary mb-3">Recently Ended</h5>
                            <div class="media-grid-wrapper">
                                <?php $__currentLoopData = $categoryRecent; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if (isset($component)) { $__componentOriginal3a8c1a2d94b1c50e899eb326aa5eda61 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3a8c1a2d94b1c50e899eb326aa5eda61 = $attributes; } ?>
<?php $component = App\View\Components\Home\MediaGrid::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.media-grid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Home\MediaGrid::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($session->title),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($session->banner_image ? asset('storage/app/public/'.$session->banner_image) : null),'url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('fitlive.session', $session)),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('ended'),'duration' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null),'year' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($session->updated_at->format('Y')),'rating' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null),'badgeClass' => 'ended-badge','description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('By ' .
                                            $session->instructor->name .
                                            ' | Ended on ' .
                                            $session->updated_at->format('M d'))]); ?>
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
                        <?php endif; ?>
                    </section>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fittley\resources\views/public/fitlive/index.blade.php ENDPATH**/ ?>