

<?php $__env->startSection('title', 'FitNews - Live Streams'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/home/css/fitdoc.index.css')); ?>?v=<?php echo e(time()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $liveStreams = $liveStreams ?? collect();
        $upcomingStreams = $upcomingStreams ?? collect();
        $pastStreams = $pastStreams ?? collect();
        $heroStream = $latestStream ?? ($liveStreams->first() ?? null);
    ?>

    <div class="fitdoc-container">

        

        <section class="hero-section"
            style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.8)),
           url('<?php echo e($heroStream && $heroStream->banner_image
               ? asset('storage/app/public/' . $heroStream->banner_image)
               : 'https://images.unsplash.com/photo-1558611848-73f7eb4001a1?ixlib=rb-4.0.3'); ?>')
           center/cover no-repeat;">


            <div class="container-fluid">
                <div class="hero-content text-white">
                    <h1>FitNews Live</h1>
                    <p>Stay updated with live fitness news and insights</p>
                    <?php if($heroStream): ?>
                        <div class="live-now-alert">

                            <strong><?php echo e($heroStream->title); ?></strong>
                            <a href="<?php echo e(route('fitnews.show', $heroStream)); ?>" class="btn btn-light btn-sm ms-2">
                                Watch Now
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <div class="container px-3 mt-1 mb-5">

            
            <?php if($liveStreams->count()): ?>
                <section class="content-section" data-type="live">
                    <h2 class="section-title">
                        Live Now
                    </h2>
                    <div class="media-grid-wrapper">
                        <?php $__currentLoopData = $liveStreams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stream): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if (isset($component)) { $__componentOriginalc758cb2babd8d0e77fd718754f273bf5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc758cb2babd8d0e77fd718754f273bf5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.media-grid','data' => ['title' => $stream->title,'image' => $stream->thumbnail ? asset('storage/app/public/' . $stream->thumbnail) : null,'url' => route('fitnews.show', $stream),'type' => 'live','badgeClass' => 'live-badge','year' => optional($stream->started_at)->format('Y'),'rating' => $stream->viewer_count,'description' => 'By ' . optional($stream->creator)->name]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.media-grid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stream->title),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stream->thumbnail ? asset('storage/app/public/' . $stream->thumbnail) : null),'url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('fitnews.show', $stream)),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('live'),'badgeClass' => 'live-badge','year' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(optional($stream->started_at)->format('Y')),'rating' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stream->viewer_count),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('By ' . optional($stream->creator)->name)]); ?>
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

            
            <?php if($upcomingStreams->count()): ?>
                <section class="content-section" data-type="upcoming">
                    <h2 class="section-title">
                        Today News
                    </h2>
                    <div class="media-grid-wrapper">
                        <?php
                            $today = \Carbon\Carbon::today(); // Aaj ki date
                            $currentTime = \Carbon\Carbon::now(); // Abhi ka time
                        ?>
                        <?php $__currentLoopData = $upcomingStreams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stream): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(\Carbon\Carbon::parse($stream->scheduled_at)->isToday()): ?>
                                <!-- Check if scheduled_at is today -->
                                <?php
                                    // Compare current time with scheduled_at
                                    $scheduledTime = \Carbon\Carbon::parse($stream->scheduled_at);

                                    // Define status and badge class
                                    if ($currentTime->lt($scheduledTime)) {
                                        $statusLabel = 'Upcoming';
                                        $badgeClass = 'badge-upcoming';
                                    } elseif (
                                        $currentTime->gte($scheduledTime) &&
                                        $currentTime->lte($scheduledTime->copy()->addHours(2))
                                    ) {
                                        // Check if current time is within 1 hour of scheduled time
                                        $statusLabel = 'Live';
                                        $badgeClass = 'badge-live';
                                    } else {
                                        $statusLabel = 'Archive';
                                        $badgeClass = 'badge-archive';
                                    }
                                ?>
                                <div class="landscape">

                                    <?php if (isset($component)) { $__componentOriginalc758cb2babd8d0e77fd718754f273bf5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc758cb2babd8d0e77fd718754f273bf5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.media-grid','data' => ['title' => $stream->title,'image' => $stream->thumbnail
                                        ? asset('storage/app/public/' . $stream->thumbnail)
                                        : null,'url' => route('fitnews.show', $stream),'type' => $statusLabel,'badgeClass' => '$badgeClass','year' => optional($stream->scheduled_at)->format('Y'),'description' => 'By ' .
                                            optional($stream->creator)->name .
                                            ' | ' .
                                            optional($stream->scheduled_at)->format('M d, g:i A')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.media-grid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stream->title),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stream->thumbnail
                                        ? asset('storage/app/public/' . $stream->thumbnail)
                                        : null),'url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('fitnews.show', $stream)),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($statusLabel),'badgeClass' => '$badgeClass','year' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(optional($stream->scheduled_at)->format('Y')),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('By ' .
                                            optional($stream->creator)->name .
                                            ' | ' .
                                            optional($stream->scheduled_at)->format('M d, g:i A'))]); ?>
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
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </section>
            <?php endif; ?>

            
            <?php if($pastStreams->count()): ?>
                <section class="content-section" data-type="ended">
                    <h2 class="section-title">
                        Recent Streams
                    </h2>
                    <div class="media-grid-wrapper">
                        <?php $__currentLoopData = $pastStreams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stream): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if (isset($component)) { $__componentOriginalc758cb2babd8d0e77fd718754f273bf5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc758cb2babd8d0e77fd718754f273bf5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.media-grid','data' => ['title' => $stream->title,'image' => $stream->thumbnail ? asset('storage/app/public/' . $stream->thumbnail) : null,'url' => route('fitnews.show', $stream),'type' => 'ended','badgeClass' => 'ended-badge','year' => optional($stream->ended_at)->format('Y'),'description' => 'By ' .
                                    optional($stream->creator)->name .
                                    ' | ' .
                                    optional($stream->ended_at)->format('M d')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.media-grid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stream->title),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stream->thumbnail ? asset('storage/app/public/' . $stream->thumbnail) : null),'url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('fitnews.show', $stream)),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('ended'),'badgeClass' => 'ended-badge','year' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(optional($stream->ended_at)->format('Y')),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('By ' .
                                    optional($stream->creator)->name .
                                    ' | ' .
                                    optional($stream->ended_at)->format('M d'))]); ?>
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

            
            <?php if($liveStreams->isEmpty() && $upcomingStreams->isEmpty() && $pastStreams->isEmpty()): ?>
                <section class="content-section">
                    <div class="text-center py-5">

                        <h2 style="color: #fff; margin-bottom: 1rem;">No Streams Available</h2>
                        <p style="color: #aaa; font-size: 1.1rem;">Stay tuned for upcoming fitness news and live streams!
                        </p>
                    </div>
                </section>
            <?php endif; ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/fittelly.com/public_html/resources/views/public/fitnews/index.blade.php ENDPATH**/ ?>