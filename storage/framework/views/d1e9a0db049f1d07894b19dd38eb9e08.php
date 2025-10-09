

<?php $__env->startSection('title', $fgSeries->title . ' - FitGuide Series'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid bg-dark text-white min-vh-100">
    <!-- Hero Section -->
    <div class="hero-section py-5" style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.8)), url('<?php echo e($fgSeries->banner_image_url ?? 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3'); ?>') center/cover;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge bg-primary me-3 px-3 py-2">Fitness Guide Series</span>
                        <?php if($fgSeries->category): ?>
                            <span class="badge bg-secondary me-2"><?php echo e($fgSeries->category->name); ?></span>
                        <?php endif; ?>
                        <?php if($fgSeries->subCategory): ?>
                            <span class="badge bg-outline-light"><?php echo e($fgSeries->subCategory->name); ?></span>
                        <?php endif; ?>
                    </div>
                    <h1 class="display-4 fw-bold mb-3"><?php echo e($fgSeries->title); ?></h1>
                    <?php if($fgSeries->description): ?>
                        <p class="lead mb-4"><?php echo e($fgSeries->description); ?></p>
                    <?php endif; ?>
                    
                    <!-- Series Info -->
                    <div class="row g-3 mb-4">
                        <div class="col-auto">
                            <div class="info-item">
                                <i class="fas fa-list me-2"></i>
                                <span><?php echo e($fgSeries->total_episodes ?? $episodes->count()); ?> Episodes</span>
                            </div>
                        </div>
                        <?php if($fgSeries->release_date): ?>
                        <div class="col-auto">
                            <div class="info-item">
                                <i class="fas fa-calendar me-2"></i>
                                <span><?php echo e($fgSeries->release_date->format('Y')); ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($fgSeries->language): ?>
                        <div class="col-auto">
                            <div class="info-item">
                                <i class="fas fa-globe me-2"></i>
                                <span><?php echo e($fgSeries->language); ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($fgSeries->feedback): ?>
                        <div class="col-auto">
                            <div class="info-item">
                                <i class="fas fa-star me-2"></i>
                                <span><?php echo e(number_format($fgSeries->feedback, 1)); ?>/5</span>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <?php if($episodes->count() > 0): ?>
                        <button class="btn btn-primary btn-lg me-3" onclick="playEpisode(1)">
                            <i class="fas fa-play me-2"></i>Start Series
                        </button>
                    <?php endif; ?>
                    
                    <?php if($fgSeries->trailer_url): ?>
                        <button class="btn btn-outline-light btn-lg" onclick="playTrailer()">
                            <i class="fas fa-video me-2"></i>Watch Trailer
                        </button>
                    <?php endif; ?>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="series-poster">
                        <img src="<?php echo e($fgSeries->banner_image_url ?? 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3'); ?>" 
                             alt="<?php echo e($fgSeries->title); ?>" class="img-fluid rounded shadow-lg" style="max-height: 400px;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Episodes Section -->
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title mb-4">
                    <i class="fas fa-list me-3"></i>Episodes
                </h2>
                
                <?php if($episodes->count() > 0): ?>
                    <div class="episodes-grid">
                        <?php $__currentLoopData = $episodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $episode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="episode-card mb-4" onclick="playEpisode(<?php echo e($episode->episode_number); ?>)">
                                <div class="row g-0">
                                    <div class="col-md-3">
                                        <div class="episode-thumbnail">
                                            <img src="<?php echo e($episode->thumbnail_path ? asset('storage/app/public/' . $episode->thumbnail_path) : $fgSeries->banner_image_url); ?>" 
                                                 alt="Episode <?php echo e($episode->episode_number); ?>" class="img-fluid rounded">
                                            <div class="play-overlay">
                                                <i class="fas fa-play"></i>
                                            </div>
                                            <div class="episode-number"><?php echo e($episode->episode_number); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="episode-info p-4">
                                            <h5 class="episode-title"><?php echo e($episode->title); ?></h5>
                                            <?php if($episode->description): ?>
                                                <p class="episode-description text-muted"><?php echo e(Str::limit($episode->description, 200)); ?></p>
                                            <?php endif; ?>
                                            <div class="episode-meta">
                                                <?php if($episode->duration_minutes): ?>
                                                    <span class="me-3">
                                                        <i class="fas fa-clock me-1"></i><?php echo e($episode->duration_minutes); ?> min
                                                    </span>
                                                <?php endif; ?>
                                                <?php if($episode->release_date): ?>
                                                    <span>
                                                        <i class="fas fa-calendar me-1"></i><?php echo e($episode->release_date->format('M d, Y')); ?>

                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-video fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No Episodes Available</h4>
                        <p class="text-muted">Episodes for this series will be available soon.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Similar Series Section -->
    <div class="container py-5">
        <h2 class="section-title mb-4">
            <i class="fas fa-thumbs-up me-3"></i>More Like This
        </h2>
        <!-- You can add similar series recommendations here -->
    </div>
</div>

<style>
.hero-section {
    min-height: 60vh;
}

.info-item {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1.1rem;
}

.section-title {
    color: #fff;
    font-weight: 600;
    font-size: 2rem;
}

.episode-card {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.episode-card:hover {
    background: rgba(255, 255, 255, 0.15);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
}

.episode-thumbnail {
    position: relative;
    height: 120px;
    overflow: hidden;
}

.episode-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.play-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(0, 0, 0, 0.7);
    color: white;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.episode-card:hover .play-overlay {
    opacity: 1;
}

.episode-number {
    position: absolute;
    top: 10px;
    left: 10px;
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.9rem;
    font-weight: 600;
}

.episode-title {
    color: #fff;
    font-weight: 600;
    margin-bottom: 8px;
}

.episode-description {
    font-size: 0.95rem;
    line-height: 1.5;
}

.episode-meta {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.7);
}

.series-poster img {
    border: 3px solid rgba(255, 255, 255, 0.2);
}

@media (max-width: 768px) {
    .hero-section {
        min-height: 50vh;
    }
    
    .display-4 {
        font-size: 2.5rem;
    }
    
    .episode-card .row {
        flex-direction: column;
    }
    
    .episode-thumbnail {
        height: 200px;
    }
}
</style>

<script>
function playEpisode(episodeNumber) {
    // Implement episode playback logic
    const episodeUrl = `<?php echo e(route('fitguide.series.episode', ['fgSeries' => $fgSeries->slug, 'episode' => '__EPISODE__'])); ?>`.replace('__EPISODE__', episodeNumber);
    window.location.href = episodeUrl;
}

function playTrailer() {
    // Implement trailer playback logic
    <?php if($fgSeries->trailer_url): ?>
        window.open('<?php echo e($fgSeries->trailer_url); ?>', '_blank');
    <?php endif; ?>
}
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/purple-gaur-534336.hostingersite.com/public_html/resources/views/public/fitguide/series.blade.php ENDPATH**/ ?>