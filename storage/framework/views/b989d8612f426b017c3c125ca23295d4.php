<?php $__env->startSection('title', $fitDoc->title . ' - FitDoc'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Netflix-style Video Player */
    :root {
        --netflix-black: #000000;
        --netflix-dark-gray: #141414;
        --netflix-gray: #2f2f2f;
        --netflix-light-gray: #8c8c8c;
        --netflix-white: #ffffff;
        --fittelly-orange: #f7a31a;
        --netflix-red: #e50914;
    }

    body {
        background-color: var(--netflix-black);
        color: var(--netflix-white);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .video-container {
        position: relative;
        width: 100%;
        height: 60vh;
        background: var(--netflix-black);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 2rem;
    }

    .video-player {
        width: 100%;
        height: 100%;
        background: var(--netflix-dark-gray);
        border-radius: 8px;
        overflow: hidden;
        position: relative;
    }

    .video-element {
        width: 100%;
        height: 100%;
        object-fit: cover;
        background: var(--netflix-dark-gray);
        /* Disable right-click and download */
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        pointer-events: auto;
        /* Disable drag */
        -webkit-user-drag: none;
        -khtml-user-drag: none;
        -moz-user-drag: none;
        -o-user-drag: none;
        user-drag: none;
    }

    .video-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(45deg, var(--netflix-dark-gray), var(--netflix-gray));
        position: relative;
    }

    .play-button {
        width: 100px;
        height: 100px;
        background: var(--fittelly-orange);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 2.5rem;
        color: var(--netflix-black);
        box-shadow: 0 10px 30px rgba(247, 163, 26, 0.3);
        position: absolute;
        z-index: 10;
    }

    .play-button:hover {
        transform: scale(1.1);
        box-shadow: 0 15px 40px rgba(247, 163, 26, 0.5);
    }

    .play-button.hidden {
        display: none;
    }

    .play-button.hidden {
        display: none;
    }

    .video-controls {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
        padding: 1rem;
        transform: translateY(100%);
        transition: transform 0.3s ease;
    }

    .video-player:hover .video-controls {
        transform: translateY(0);
    }

    .video-progress {
        width: 100%;
        height: 4px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 2px;
        margin-bottom: 1rem;
        cursor: pointer;
    }

    .video-progress-bar {
        height: 100%;
        background: var(--fittelly-orange);
        border-radius: 2px;
        width: 0%;
        transition: width 0.1s ease;
    }

    .video-controls-buttons {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .video-control-btn {
        background: none;
        border: none;
        color: var(--netflix-white);
        font-size: 1.2rem;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .video-control-btn:hover {
        color: var(--fittelly-orange);
    }

    .video-time {
        color: var(--netflix-white);
        font-size: 0.9rem;
        margin-left: auto;
    }

    .video-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.8));
        display: flex;
        align-items: flex-end;
        padding: 2rem;
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }

    .video-player:hover .video-overlay {
        opacity: 1;
    }

    .video-info {
        color: var(--netflix-white);
    }

    .video-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .video-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 0.9rem;
        color: var(--netflix-light-gray);
    }

    .content-details {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    .details-header {
        display: flex;
        gap: 3rem;
        margin-bottom: 3rem;
    }

    .details-main {
        flex: 2;
    }

    .details-sidebar {
        flex: 1;
    }

    .movie-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        background: linear-gradient(45deg, var(--fittelly-orange), var(--netflix-white));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .movie-meta {
        display: flex;
        align-items: center;
        gap: 2rem;
        margin-bottom: 2rem;
        font-size: 1rem;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--netflix-light-gray);
    }

    .rating {
        background: var(--fittelly-orange);
        color: var(--netflix-black);
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .description {
        font-size: 1.1rem;
        line-height: 1.6;
        color: var(--netflix-white);
        margin-bottom: 2rem;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .btn-primary {
        background: var(--fittelly-orange);
        color: var(--netflix-black);
        border: none;
        padding: 0.8rem 2rem;
        border-radius: 6px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary:hover {
        background: #e8941a;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.3);
        color: var(--netflix-white);
        border: none;
        padding: 0.8rem 2rem;
        border-radius: 6px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        backdrop-filter: blur(10px);
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.4);
    }

    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .detail-item {
        background: var(--netflix-dark-gray);
        padding: 1.5rem;
        border-radius: 8px;
    }

    .detail-label {
        font-size: 0.9rem;
        color: var(--netflix-light-gray);
        margin-bottom: 0.5rem;
    }

    .detail-value {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--netflix-white);
    }

    .subscription-notice {
        background: linear-gradient(45deg, var(--netflix-red), #ff4757);
        color: var(--netflix-white);
        padding: 2rem;
        border-radius: 12px;
        text-align: center;
        margin: 2rem 0;
    }

    .subscription-notice h3 {
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .subscription-notice p {
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
    }

    .btn-subscribe {
        background: var(--fittelly-orange);
        color: var(--netflix-black);
        border: none;
        padding: 1rem 2rem;
        border-radius: 6px;
        font-size: 1.2rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-subscribe:hover {
        background: #e8941a;
        transform: translateY(-2px);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .video-container {
            height: 40vh;
        }

        .content-details {
            padding: 0 1rem;
        }

        .details-header {
            flex-direction: column;
            gap: 2rem;
        }

        .movie-title {
            font-size: 2rem;
        }

        .movie-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .details-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="single-video-page">
    <!-- Video Player Section -->
    <div class="video-container">
        <div class="video-player">
            <?php if(auth()->guard()->check()): ?>
                <?php if(auth()->user()->hasActiveSubscription('fitdoc')): ?>
                    <!-- HTML5 Video Player -->
                    <video class="video-element" id="mainVideo" 
                           poster="<?php echo e($fitDoc->banner_image_url ?? 'https://images.unsplash.com/photo-1574680096145-d05b474e2155?ixlib=rb-4.0.3'); ?>"
                           controlslist="nodownload nofullscreen noremoteplayback"
                           disablepictureinpicture
                           oncontextmenu="return false;">
                        <source src="<?php echo e($fitDoc->video_path ? asset('storage/app/public/' . $fitDoc->video_path) : 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4'); ?>" type="video/mp4">
                        <source src="<?php echo e($fitDoc->video_path ? asset('storage/app/public/' . $fitDoc->video_path) : 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4'); ?>" type="video/webm">
                        Your browser does not support the video tag.
                    </video>
                    
                    <div class="play-button" id="playButton" onclick="playVideo()">
                        <i class="fas fa-play"></i>
                    </div>
                    
                    <div class="video-controls" id="videoControls">
                        <div class="video-progress" onclick="seekVideo(event)">
                            <div class="video-progress-bar" id="progressBar"></div>
                        </div>
                        <div class="video-controls-buttons">
                            <button class="video-control-btn" id="playPauseBtn" onclick="togglePlayPause()">
                                <i class="fas fa-play"></i>
                            </button>
                            <button class="video-control-btn" onclick="toggleMute()">
                                <i class="fas fa-volume-up" id="volumeIcon"></i>
                            </button>
                            <button class="video-control-btn" onclick="toggleFullscreen()">
                                <i class="fas fa-expand"></i>
                            </button>
                            <div class="video-time">
                                <span id="currentTime">0:00</span> / <span id="duration"><?php echo e($fitDoc->duration_minutes ?? 90); ?>:00</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="video-overlay">
                        <div class="video-info">
                            <div class="video-title"><?php echo e($fitDoc->title); ?></div>
                            <div class="video-meta">
                                <span><i class="fas fa-clock"></i> <?php echo e($fitDoc->duration_minutes ?? 90); ?> min</span>
                                <span><i class="fas fa-calendar"></i> <?php echo e($fitDoc->created_at->format('Y')); ?></span>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="subscription-notice">
                        <h3><i class="fas fa-lock"></i> Premium Content</h3>
                        <p>Subscribe to FitDoc to watch this movie and access our entire library of fitness documentaries.</p>
                        <button class="btn-subscribe" onclick="window.location.href='<?php echo e(route('subscription.plans')); ?>'">
                            <i class="fas fa-crown"></i> Subscribe Now
                        </button>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="subscription-notice">
                    <h3><i class="fas fa-user-lock"></i> Sign In Required</h3>
                    <p>Please sign in to watch this movie and access our fitness content library.</p>
                    <button class="btn-subscribe" onclick="window.location.href='<?php echo e(route('login')); ?>'">
                        <i class="fas fa-sign-in-alt"></i> Sign In
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Content Details -->
    <div class="content-details">
        <div class="details-header">
            <div class="details-main">
                <h1 class="movie-title"><?php echo e($fitDoc->title); ?></h1>
                
                <div class="movie-meta">
                    <div class="meta-item">
                        <i class="fas fa-star"></i>
                        <span class="rating">HD</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-calendar"></i>
                        <span><?php echo e($fitDoc->created_at->format('Y')); ?></span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-clock"></i>
                        <span><?php echo e($fitDoc->duration_minutes ?? 90); ?> minutes</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-film"></i>
                        <span>Documentary</span>
                    </div>
                </div>

                <?php if($fitDoc->description): ?>
                <p class="description"><?php echo e($fitDoc->description); ?></p>
                <?php endif; ?>

                <div class="action-buttons">
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(auth()->user()->hasActiveSubscription('fitdoc')): ?>
                            <button class="btn-primary" onclick="playVideo()">
                                <i class="fas fa-play"></i> Play Movie
                            </button>
                            <button class="btn-secondary">
                                <i class="fas fa-plus"></i> My List
                            </button>
                            <button class="btn-secondary">
                                <i class="fas fa-share"></i> Share
                            </button>
                        <?php else: ?>
                            <button class="btn-primary" onclick="window.location.href='<?php echo e(route('subscription.plans')); ?>'">
                                <i class="fas fa-crown"></i> Subscribe to Watch
                            </button>
                        <?php endif; ?>
                    <?php else: ?>
                        <button class="btn-primary" onclick="window.location.href='<?php echo e(route('login')); ?>'">
                            <i class="fas fa-sign-in-alt"></i> Sign In to Watch
                        </button>
                    <?php endif; ?>
                </div>
            </div>

            <div class="details-sidebar">
                <div class="details-grid">
                    <?php if($fitDoc->director): ?>
                    <div class="detail-item">
                        <div class="detail-label">Director</div>
                        <div class="detail-value"><?php echo e($fitDoc->director); ?></div>
                    </div>
                    <?php endif; ?>

                    <?php if($fitDoc->cast): ?>
                    <div class="detail-item">
                        <div class="detail-label">Cast</div>
                        <div class="detail-value"><?php echo e($fitDoc->cast); ?></div>
                    </div>
                    <?php endif; ?>

                    <?php if($fitDoc->genre): ?>
                    <div class="detail-item">
                        <div class="detail-label">Genre</div>
                        <div class="detail-value"><?php echo e($fitDoc->genre); ?></div>
                    </div>
                    <?php endif; ?>

                    <div class="detail-item">
                        <div class="detail-label">Release Year</div>
                        <div class="detail-value"><?php echo e($fitDoc->created_at->format('Y')); ?></div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Duration</div>
                        <div class="detail-value"><?php echo e($fitDoc->duration_minutes ?? 90); ?> min</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Language</div>
                        <div class="detail-value"><?php echo e($fitDoc->language ?? 'English'); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
let video = null;
let playButton = null;
let playPauseBtn = null;
let progressBar = null;
let currentTimeSpan = null;
let durationSpan = null;
let volumeIcon = null;

document.addEventListener('DOMContentLoaded', function() {
    video = document.getElementById('mainVideo');
    playButton = document.getElementById('playButton');
    playPauseBtn = document.getElementById('playPauseBtn');
    progressBar = document.getElementById('progressBar');
    currentTimeSpan = document.getElementById('currentTime');
    durationSpan = document.getElementById('duration');
    volumeIcon = document.getElementById('volumeIcon');

    if (video) {
        // Disable right-click context menu on video
        video.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            return false;
        });

        // Disable drag and drop
        video.addEventListener('dragstart', function(e) {
            e.preventDefault();
            return false;
        });

        // Disable text selection
        video.addEventListener('selectstart', function(e) {
            e.preventDefault();
            return false;
        });

        // Update progress bar
        video.addEventListener('timeupdate', updateProgress);
        
        // Update duration when metadata loads
        video.addEventListener('loadedmetadata', function() {
            durationSpan.textContent = formatTime(video.duration);
        });
        
        // Handle play/pause state changes
        video.addEventListener('play', function() {
            playButton.classList.add('hidden');
            playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
        });
        
        video.addEventListener('pause', function() {
            playButton.classList.remove('hidden');
            playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
        });
        
        // Handle video end
        video.addEventListener('ended', function() {
            playButton.classList.remove('hidden');
            playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
        });
    }
});

function playVideo() {
    if (video) {
        video.play();
    }
}

function togglePlayPause() {
    if (video) {
        if (video.paused) {
            video.play();
        } else {
            video.pause();
        }
    }
}

function toggleMute() {
    if (video) {
        video.muted = !video.muted;
        volumeIcon.className = video.muted ? 'fas fa-volume-mute' : 'fas fa-volume-up';
    }
}

function toggleFullscreen() {
    if (video) {
        if (video.requestFullscreen) {
            video.requestFullscreen();
        } else if (video.webkitRequestFullscreen) {
            video.webkitRequestFullscreen();
        } else if (video.msRequestFullscreen) {
            video.msRequestFullscreen();
        }
    }
}

function seekVideo(event) {
    if (video) {
        const progressContainer = event.currentTarget;
        const clickX = event.offsetX;
        const width = progressContainer.offsetWidth;
        const duration = video.duration;
        
        const newTime = (clickX / width) * duration;
        video.currentTime = newTime;
    }
}

function updateProgress() {
    if (video && progressBar && currentTimeSpan) {
        const progress = (video.currentTime / video.duration) * 100;
        progressBar.style.width = progress + '%';
        currentTimeSpan.textContent = formatTime(video.currentTime);
    }
}

function formatTime(seconds) {
    const minutes = Math.floor(seconds / 60);
    const remainingSeconds = Math.floor(seconds % 60);
    return `${minutes}:${remainingSeconds.toString().padStart(2, '0')}`;
}

// Add keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (video && document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'TEXTAREA') {
        switch(e.code) {
            case 'Space':
                e.preventDefault();
                togglePlayPause();
                break;
            case 'KeyM':
                e.preventDefault();
                toggleMute();
                break;
            case 'KeyF':
                e.preventDefault();
                toggleFullscreen();
                break;
            case 'ArrowLeft':
                e.preventDefault();
                video.currentTime -= 10;
                break;
            case 'ArrowRight':
                e.preventDefault();
                video.currentTime += 10;
                break;
        }
    }
});
</script>
<?php $__env->stopPush(); ?> 
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/purple-gaur-534336.hostingersite.com/public_html/resources/views/public/fitdoc/single.blade.php ENDPATH**/ ?>