

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
                <section class="content-section " data-type="live">
                    <h2 class="section-title">
                        Live Now
                    </h2>
                    <div class="media-grid-wrapper">
                        <?php $__currentLoopData = $liveSessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if (isset($component)) { $__componentOriginalc758cb2babd8d0e77fd718754f273bf5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc758cb2babd8d0e77fd718754f273bf5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.media-grid','data' => ['title' => $session->title,'image' => $session->banner_image
                                ? asset('storage/app/public/' . $session->banner_image)
                                : null,'url' => route('fitlive.session', $session),'type' => 'live','duration' => null,'year' => null,'rating' => $session->viewer_peak,'description' => 'By ' . $session->instructor->name,'badgeClass' => 'live-badge']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.media-grid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($session->title),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($session->banner_image
                                ? asset('storage/app/public/' . $session->banner_image)
                                : null),'url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('fitlive.session', $session)),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('live'),'duration' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null),'year' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null),'rating' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($session->viewer_peak),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('By ' . $session->instructor->name),'badgeClass' => 'live-badge']); ?>
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

            
            <?php if($dailylive->count() > 0 || $fitexpert->count() > 0): ?>
                <section class="content- ">
                    <h3 class="section-title">
                        Daily Live Classes
                    </h3>

                    
                    <?php if($dailylive->count() > 0): ?>
                       
                        <div class="media-grid-wrapper mb-4">
                            <?php $__currentLoopData = $dailylive; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if (isset($component)) { $__componentOriginalc758cb2babd8d0e77fd718754f273bf5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc758cb2babd8d0e77fd718754f273bf5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.media-grid','data' => ['title' => $session->name,'image' => $session->banner_image
                                    ? asset('storage/app/public/' . $session->banner_image)
                                    : null,'url' => route('fitlive.daily-classes.show', $session->id),'type' => 'live','duration' => null,'rating' => null,'badgeClass' => 'live-badge']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.media-grid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($session->name),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($session->banner_image
                                    ? asset('storage/app/public/' . $session->banner_image)
                                    : null),'url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('fitlive.daily-classes.show', $session->id)),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('live'),'duration' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null),'rating' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null),'badgeClass' => 'live-badge']); ?>
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
                    <?php endif; ?>
                    <h3 class="section-title">
                        FitExpert
                    </h3>
                    
                    <?php if($fitexpert->count() > 0): ?>
                        <div class="media-grid-wrapper">
                            <?php $__currentLoopData = $fitexpert->sortByDesc('id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if (isset($component)) { $__componentOriginalc758cb2babd8d0e77fd718754f273bf5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc758cb2babd8d0e77fd718754f273bf5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.media-grid','data' => ['title' => $session->title,'image' => $session->banner_image
                                    ? asset('storage/app/public/' . $session->banner_image)
                                    : null,'url' => route('fitlive.session', $session),'type' => 'live','duration' => null,'year' => $session->updated_at->format('Y'),'rating' => null,'badgeClass' => 'live-badge','description' => 'By ' .
                                        $session->instructor->name .
                                        ' | Ended on ' .
                                        $session->updated_at->format('M d')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.media-grid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($session->title),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($session->banner_image
                                    ? asset('storage/app/public/' . $session->banner_image)
                                    : null),'url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('fitlive.session', $session)),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('live'),'duration' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null),'year' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($session->updated_at->format('Y')),'rating' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null),'badgeClass' => 'live-badge','description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('By ' .
                                        $session->instructor->name .
                                        ' | Ended on ' .
                                        $session->updated_at->format('M d'))]); ?>
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
                    <?php endif; ?>
                </section>
            <?php endif; ?>


        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/fittelly.com/public_html/resources/views/public/fitlive/index.blade.php ENDPATH**/ ?>