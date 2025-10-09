

<?php $__env->startSection('title', 'FitExpertLive - Live Fitness Sessions'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/home/css/fitdoc.index.css')); ?>?v=<?php echo e(time()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="fitdoc-container">
        
        <section class="hero-section">
            <div class="container-fluid">
                <div class="hero-content">
                    <h1>Fit Expert live</h1>
                    <p>Join live fitness sessions with expert instructors</p>

                </div>
            </div>
        </section>

        <div class="container px-3 mt-1 mb-5">

             
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



        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/fittelly.com/public_html/resources/views/public/fitlive/fitexpert.blade.php ENDPATH**/ ?>