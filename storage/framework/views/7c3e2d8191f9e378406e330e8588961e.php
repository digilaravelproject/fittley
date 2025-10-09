

<?php $__env->startSection('title', $episode->title . ' - ' . $fgSeries->title . ' - FitGuide'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid bg-dark text-white min-vh-100">
    <!-- Hero Section -->
    <div class="hero-section py-5" style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.8)), url('<?php echo e($fgSeries->banner_image_url ?? 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3'); ?>') center/cover;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('fitguide.index')); ?>" class="text-light">FitGuide</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(route('fitguide.series.show', $fgSeries->slug)); ?>" class="text-light"><?php echo e($fgSeries->title); ?></a></li>
                            <li class="breadcrumb-item active text-warning" aria-current="page">Episode <?php echo e($episode->episode_number); ?></li>
                        </ol>
                    </nav>
                    
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge bg-primary me-3 px-3 py-2">Episode <?php echo e($episode->episode_number); ?></span>
                        <span class="badge bg-secondary"><?php echo e($fgSeries->title); ?></span>
                    </div>
                    
                    <h1 class="display-4 fw-bold mb-3"><?php echo e($episode->title); ?></h1>
                    <?php if($episode->description): ?>
                        <p class="lead mb-4"><?php echo e($episode->description); ?></p>
                    <?php endif; ?>
                    
                    <!-- Episode Info -->
                    <div class="row g-3 mb-4">
                        <?php if($episode->duration_minutes): ?>
                        <div class="col-auto">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-clock me-2 text-primary"></i>
                                <div>
                                    <small class="text-muted d-block">Duration</small>
                                    <span><?php echo e($episode->formatted_duration); ?></span>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <div class="col-auto">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-list me-2 text-primary"></i>
                                <div>
                                    <small class="text-muted d-block">Episode</small>
                                    <span><?php echo e($episode->episode_number); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-3 flex-wrap">
                        <?php if($episode->video_url || $episode->video_file_path): ?>
                            <button class="btn btn-primary btn-lg" onclick="startEpisode()">
                                <i class="fas fa-play me-2"></i>Watch Episode
                            </button>
                        <?php endif; ?>
                        <a href="<?php echo e(route('fitguide.series.show', $fgSeries->slug)); ?>" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-list me-2"></i>All Episodes
                        </a>
                        <button class="btn btn-outline-light btn-lg">
                            <i class="fas fa-bookmark me-2"></i>Save Episode
                        </button>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="episode-poster">
                        <img src="<?php echo e($fgSeries->banner_image_url ?? 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3'); ?>" 
                             alt="<?php echo e($episode->title); ?>" class="img-fluid rounded shadow-lg" style="max-height: 400px;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Video Player Section (Hidden by default) -->
    <div id="videoSection" class="video-section" style="display: none;">
        <div class="container-fluid p-0">
            <div class="video-container position-relative" style="height: 70vh; background: #000;">
                
                <?php
                    $videoType = null;
                    $videoSource = null;
                    $youtubeId = null;
                    
                    if ($episode->video_type === 'youtube' && $episode->video_url) {
                        $videoType = 'youtube';
                        // Extract YouTube video ID from URL
                        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $episode->video_url, $matches);
                        $youtubeId = $matches[1] ?? null;
                    } elseif ($episode->video_type === 's3' && $episode->video_url) {
                        $videoType = 's3';
                        $videoSource = $episode->video_url;
                    } elseif ($episode->video_type === 'upload' && $episode->video_file_path) {
                        $videoType = 'upload';
                        $videoSource = asset('storage/app/public/' . $episode->video_file_path);
                    } elseif ($episode->video_url) {
                        // Fallback to direct URL
                        $videoType = 'direct';
                        $videoSource = $episode->video_url;
                    }
                ?>

                <?php if($videoType === 'youtube' && $youtubeId): ?>
                    <!-- YouTube Player -->
                    <div id="youtubePlayerContainer" class="w-100 h-100">
                        <iframe id="youtubePlayer" 
                                width="100%" 
                                height="100%" 
                                src="https://www.youtube.com/embed/<?php echo e($youtubeId); ?>?enablejsapi=1&rel=0&modestbranding=1" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen>
                        </iframe>
                    </div>
                    
                    <!-- YouTube Controls Overlay -->
                    <div class="video-controls position-absolute bottom-0 start-0 end-0 p-3 bg-gradient-dark">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <i class="fab fa-youtube text-danger me-2"></i>
                                <span class="text-white">YouTube Video</span>
                            </div>
                            <button class="btn btn-outline-light" onclick="closeVideo()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                <?php elseif($videoSource): ?>
                    <!-- HTML5 Video Player (for S3, Upload, Direct URLs) -->
                    <video id="episodeVideo" class="w-100 h-100" controls style="object-fit: cover;" preload="metadata">
                        <source src="<?php echo e($videoSource); ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    
                    <!-- Video Controls Overlay -->
                    <div class="video-controls position-absolute bottom-0 start-0 end-0 p-3 bg-gradient-dark">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <button class="btn btn-outline-light" onclick="toggleVideo()">
                                    <i id="playPauseIcon" class="fas fa-play"></i>
                                </button>
                                <?php if($videoType === 's3'): ?>
                                    <i class="fab fa-aws text-warning me-2"></i>
                                    <span class="text-white">AWS S3 Video</span>
                                <?php elseif($videoType === 'upload'): ?>
                                    <i class="fas fa-upload text-success me-2"></i>
                                    <span class="text-white">Uploaded Video</span>
                                <?php else: ?>
                                    <i class="fas fa-video text-info me-2"></i>
                                    <span class="text-white">Direct Video</span>
                                <?php endif; ?>
                            </div>
                            <div class="flex-grow-1 mx-3">
                                <input type="range" class="form-range" id="progressBar" min="0" max="100" value="0">
                            </div>
                            <button class="btn btn-outline-light" onclick="closeVideo()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- No Video Available -->
                    <div class="d-flex align-items-center justify-content-center h-100 text-center">
                        <div>
                            <i class="fas fa-video-slash fa-3x text-muted mb-3"></i>
                            <h4 class="text-white">Video Not Available</h4>
                            <p class="text-muted">This episode doesn't have a video configured.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Episode Description -->
    <?php if($episode->description): ?>
    <div class="description-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h3 class="mb-4">About This Episode</h3>
                    <div class="description-content">
                        <?php echo nl2br(e($episode->description)); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Series Episodes -->
    <div class="related-section py-5 bg-secondary">
        <div class="container">
            <h2 class="section-title mb-4">
                <i class="fas fa-list me-2"></i><?php echo e($fgSeries->title); ?> - All Episodes
            </h2>
            <div class="row">
                <?php $__currentLoopData = $fgSeries->episodes->where('is_published', true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="content-card bg-dark rounded overflow-hidden <?php echo e($ep->id === $episode->id ? 'border border-primary' : ''); ?>">
                            <img src="<?php echo e($fgSeries->banner_image_url ?? 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3'); ?>" 
                                 class="card-img-top" style="height: 200px; object-fit: cover;" alt="Episode <?php echo e($ep->episode_number); ?>">
                            <div class="card-body">
                                <h6 class="card-title">Episode <?php echo e($ep->episode_number); ?>: <?php echo e($ep->title); ?></h6>
                                <p class="card-text small text-muted"><?php echo e(Str::limit($ep->description ?? 'Episode description', 80)); ?></p>
                                <?php if($ep->id === $episode->id): ?>
                                    <span class="btn btn-primary btn-sm w-100">
                                        <i class="fas fa-play me-1"></i>Currently Watching
                                    </span>
                                <?php else: ?>
                                    <a href="<?php echo e(route('fitguide.series.episode', [$fgSeries->slug, $ep->episode_number])); ?>" class="btn btn-outline-primary btn-sm w-100">
                                        <i class="fas fa-play me-1"></i>Watch Episode
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-dark {
    background: linear-gradient(0deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 50%, rgba(0,0,0,0) 100%);
}

.content-card {
    transition: transform 0.3s ease;
}

.content-card:hover {
    transform: scale(1.05);
}

.section-title {
    font-size: 2rem;
    font-weight: 700;
    color: #ffffff;
}

.video-container {
    position: relative;
}

.video-controls {
    opacity: 0;
    transition: opacity 0.3s ease;
}

.video-container:hover .video-controls {
    opacity: 1;
}

.breadcrumb {
    background: transparent;
}

.breadcrumb-item + .breadcrumb-item::before {
    color: #6c757d;
}
</style>

<script>
function startEpisode() {
    <?php if($videoType): ?>
        const videoSection = document.getElementById('videoSection');
        videoSection.style.display = 'block';
        videoSection.scrollIntoView({ behavior: 'smooth' });
        
        <?php if($videoType === 'youtube'): ?>
            // YouTube iframe will auto-load, no need to programmatically play
            console.log('YouTube video loaded');
        <?php else: ?>
            // For HTML5 video players
            const video = document.getElementById('episodeVideo');
            if (video) {
                video.play().catch(function(error) {
                    console.log('Auto-play was prevented:', error);
                    // Show play button if auto-play fails
                });
                updatePlayPauseIcon();
            }
        <?php endif; ?>
    <?php else: ?>
        alert('Video not available for this episode');
    <?php endif; ?>
}

function toggleVideo() {
    const video = document.getElementById('episodeVideo');
    if (video.paused) {
        video.play();
    } else {
        video.pause();
    }
    updatePlayPauseIcon();
}

function closeVideo() {
    const videoSection = document.getElementById('videoSection');
    const video = document.getElementById('episodeVideo');
    if (video) {
        video.pause();
    }
    videoSection.style.display = 'none';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function updatePlayPauseIcon() {
    const video = document.getElementById('episodeVideo');
    const icon = document.getElementById('playPauseIcon');
    if (video && icon) {
        if (video.paused) {
            icon.className = 'fas fa-play';
        } else {
            icon.className = 'fas fa-pause';
        }
    }
}

// Video progress tracking
document.addEventListener('DOMContentLoaded', function() {
    const video = document.getElementById('episodeVideo');
    const progressBar = document.getElementById('progressBar');
    
    if (video && progressBar) {
        video.addEventListener('timeupdate', function() {
            if (video.duration && !isNaN(video.duration)) {
                const progress = (video.currentTime / video.duration) * 100;
                progressBar.value = progress;
            }
        });
        
        progressBar.addEventListener('input', function() {
            if (video.duration && !isNaN(video.duration)) {
                const time = (progressBar.value / 100) * video.duration;
                video.currentTime = time;
            }
        });
        
        video.addEventListener('play', updatePlayPauseIcon);
        video.addEventListener('pause', updatePlayPauseIcon);
        
        // Handle video loading errors
        video.addEventListener('error', function(e) {
            console.error('Video failed to load:', e);
            alert('Sorry, there was an error loading the video. Please check your connection and try again.');
        });
        
        // Handle video is ready to play
        video.addEventListener('canplay', function() {
            console.log('Video is ready to play');
        });
    }
});
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/purple-gaur-534336.hostingersite.com/public_html/resources/views/public/fitguide/episode.blade.php ENDPATH**/ ?>