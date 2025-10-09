<?php $__env->startSection('title', 'FitArena - Live Fitness Competitions'); ?>

<?php $__env->startSection('content'); ?>
<div class="fitarena-page">
    <!-- Hero Section -->
    <?php if($heroEvent): ?>
    <section class="hero-section bg-dark text-white position-relative overflow-hidden">
        <div class="hero-background">
            <?php if($heroEvent->banner_image): ?>
                <img src="<?php echo e(asset('storage/app/public/'.$heroEvent->banner_image)); ?>" alt="<?php echo e($heroEvent->title); ?>" class="w-100 h-100 object-cover opacity-50">
            <?php else: ?>
                <div class="bg-gradient-primary w-100 h-100"></div>
            <?php endif; ?>
        </div>
        <div class="hero-content position-absolute top-50 start-50 translate-middle text-center w-100">
            <div class="container">
                <span class="badge bg-danger fs-6 mb-3">
                    <i class="fas fa-circle pulse me-2"></i>LIVE NOW
                </span>
                <h1 class="display-4 fw-bold mb-3"><?php echo e($heroEvent->title); ?></h1>
                <p class="lead mb-4"><?php echo e($heroEvent->description); ?></p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="<?php echo e(route('fitarena.event', $heroEvent->slug)); ?>" class="btn btn-primary btn-lg">
                        <i class="fas fa-play me-2"></i>Watch Live
                    </a>
                    <div class="text-muted">
                        <i class="fas fa-users me-2"></i><?php echo e($heroEvent->peak_viewers ?? 0); ?> viewers
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Live Events Section -->
    <?php if($liveEvents->count() > 0): ?>
    <section class="py-5 bg-dark" style="background-color: #0a0a0a !important;">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="fw-bold">🔴 Live Now</h2>
                    <p class="text-muted">Join the action happening right now</p>
                </div>
            </div>
            <div class="row g-4">
                <?php $__currentLoopData = $liveEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card event-card h-100 border-0 shadow-sm bg-dark text-white">
                        <div class="position-relative">
                            <?php if($event->banner_image): ?>
                                <img src="<?php echo e(asset('storage/app/public/'.$event->banner_image)); ?>" class="card-img-top" alt="<?php echo e($event->title); ?>" style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-gradient-primary" style="height: 200px;"></div>
                            <?php endif; ?>
                            <span class="position-absolute top-0 start-0 m-2 badge bg-danger">
                                <i class="fas fa-circle pulse me-1"></i>LIVE
                            </span>
                            <div class="position-absolute bottom-0 end-0 m-2 badge bg-dark">
                                <i class="fas fa-users me-1"></i><?php echo e($event->peak_viewers ?? 0); ?>

                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-white"><?php echo e($event->title); ?></h5>
                            <p class="card-text text-light small"><?php echo e(Str::limit($event->description, 100)); ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-light">
                                    <i class="fas fa-calendar me-1"></i><?php echo e($event->start_date->format('M j')); ?>

                                </small>
                                <span class="badge bg-success"><?php echo e($event->event_type ?? 'Competition'); ?></span>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="<?php echo e(route('fitarena.event', $event->slug)); ?>" class="btn btn-primary w-100">
                                <i class="fas fa-play me-2"></i>Watch Live
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Upcoming Events Section -->
    <?php if($upcomingEvents->count() > 0): ?>
    <section class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="fw-bold">📅 Upcoming Events</h2>
                    <p class="text-muted">Don't miss these exciting competitions</p>
                </div>
            </div>
            <div class="row g-4">
                <?php $__currentLoopData = $upcomingEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card event-card h-100 border-0 shadow-sm bg-dark text-white">
                        <div class="position-relative">
                            <?php if($event->banner_image): ?>
                                <img src="<?php echo e(asset('storage/app/public/'.$event->banner_image)); ?>" class="card-img-top" alt="<?php echo e($event->title); ?>" style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-gradient-secondary" style="height: 200px;"></div>
                            <?php endif; ?>
                            <span class="position-absolute top-0 start-0 m-2 badge bg-warning text-dark">
                                <i class="fas fa-clock me-1"></i><?php echo e($event->getDaysUntilStart()); ?>d
                            </span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-white"><?php echo e($event->title); ?></h5>
                            <p class="card-text text-light small"><?php echo e(Str::limit($event->description, 100)); ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-light">
                                    <i class="fas fa-calendar me-1"></i><?php echo e($event->start_date->format('M j, Y')); ?>

                                </small>
                                <span class="badge bg-info"><?php echo e($event->event_type ?? 'Competition'); ?></span>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="<?php echo e(route('fitarena.event', $event->slug)); ?>" class="btn btn-outline-primary w-100">
                                <i class="fas fa-info-circle me-2"></i>View Details
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Featured Events Section -->
    <?php if($featuredEvents->count() > 0): ?>
    <section class="py-5 bg-dark">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="fw-bold">⭐ Featured Events</h2>
                    <p class="text-muted">Highlighted competitions and challenges</p>
                </div>
            </div>
            <div class="row g-4">
                <?php $__currentLoopData = $featuredEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-3 col-md-6">
                    <div class="card event-card h-100 border-0 shadow-sm bg-dark text-white">
                        <div class="position-relative">
                            <?php if($event->banner_image): ?>
                                <img src="<?php echo e(asset('storage/app/public/'.$event->banner_image)); ?>" class="card-img-top" alt="<?php echo e($event->title); ?>" style="height: 150px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-gradient-warning" style="height: 150px;"></div>
                            <?php endif; ?>
                            <span class="position-absolute top-0 end-0 m-2 badge bg-warning text-dark">
                                <i class="fas fa-star me-1"></i>Featured
                            </span>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title text-white"><?php echo e($event->title); ?></h6>
                            <small class="text-light d-block mb-2">
                                <i class="fas fa-calendar me-1"></i><?php echo e($event->start_date->format('M j')); ?>

                            </small>
                            <span class="badge bg-<?php echo e($event->status_color); ?>"><?php echo e(ucfirst($event->status)); ?></span>
                        </div>
                        <div class="card-footer bg-transparent border-0 p-2">
                            <a href="<?php echo e(route('fitarena.event', $event->slug)); ?>" class="btn btn-sm btn-outline-primary w-100">
                                View Event
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Call to Action Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container text-center">
            <h2 class="fw-bold mb-3">Ready to Compete?</h2>
            <p class="lead mb-4">Join FitArena and showcase your fitness skills in live competitions</p>
            <?php if(auth()->guard()->guest()): ?>
                <a href="<?php echo e(route('register')); ?>" class="btn btn-light btn-lg me-3">
                    <i class="fas fa-user-plus me-2"></i>Sign Up Now
                </a>
                <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </a>
            <?php else: ?>
                <a href="<?php echo e(route('subscription.plans')); ?>" class="btn btn-light btn-lg">
                    <i class="fas fa-crown me-2"></i>Get Premium Access
                </a>
            <?php endif; ?>
        </div>
    </section>
</div>

<style>
.fitarena-page .hero-section {
    height: 70vh;
    min-height: 500px;
}

.fitarena-page .hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
}

.fitarena-page .hero-content {
    z-index: 2;
}

.fitarena-page .event-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.fitarena-page .event-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
}

.fitarena-page .pulse {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-secondary {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/purple-gaur-534336.hostingersite.com/public_html/resources/views/public/fitarena/index.blade.php ENDPATH**/ ?>