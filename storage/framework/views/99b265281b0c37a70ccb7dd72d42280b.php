    
    
    <?php $__env->startSection('title', $fitDoc->title . ' - FitDoc'); ?>
    
    <?php $__env->startPush('styles'); ?>
    <style>
        :root {
            --netflix-black: #000000;
            --netflix-dark-gray: #141414;
            --netflix-gray: #2f2f2f;
            --netflix-light-gray: #8c8c8c;
            --netflix-white: #ffffff;
            --fittelly-orange: #f7a31a;
            --netflix-red: #e50914;
            --transition-speed: 0.3s;
        }
    
        body {
            background-color: var(--netflix-black);
            color: var(--netflix-white);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }
    
        .single-video-page {
            max-width: 1600px;
            margin: 0 auto;
            padding: 0.5rem;
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
            border-radius: 10px;
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
        }
    
        .play-button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: var(--fittelly-orange);
            border-radius: 50%;
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: var(--netflix-black);
            cursor: pointer;
            transition: all var(--transition-speed) ease;
        }
    
        .play-button:hover {
            transform: translate(-50%, -50%) scale(1.1);
            box-shadow: 0 0 20px rgba(247, 163, 26, 0.5);
        }
    
        .video-controls {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            opacity: 0;
            transition: opacity var(--transition-speed) ease;
        }
    
        .video-player:hover .video-controls {
            opacity: 1;
        }
    
        .video-progress {
            width: 80%;
            height: 5px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 2px;
            cursor: pointer;
        }
    
        .video-progress-bar {
            height: 100%;
            background: var(--fittelly-orange);
            border-radius: 2px;
            width: 0;
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
            font-size: 1.5rem;
            cursor: pointer;
            transition: color var(--transition-speed) ease;
        }
    
        .video-control-btn:hover {
            color: var(--fittelly-orange);
        }
    
        .video-time {
            font-size: 1rem;
        }
    
        .content-details {
            display: flex;
            flex-direction: column;
            gap: 2rem;
            margin-top: 2rem;
        }
    
        .details-header {
            display: flex;
            gap: 3rem;
            margin: 0 3rem 2rem;
        }
    
        .details-main {
            flex: 2;
        }
    
        .details-sidebar {
            flex: 1;
            background: var(--netflix-dark-gray);
            padding: 1rem;
            border-radius: 8px;
        }
    
        .movie-title {
            font-size: 2rem;
            font-weight: 700;
        }
    
        .movie-meta {
            display: flex;
            gap: 1.5rem;
            color: var(--netflix-light-gray);
            margin-bottom: 1.5rem;
        }
    
        .rating {
            background: var(--fittelly-orange);
            color: var(--netflix-black);
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }
    
        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
    
        .description {
            font-size: 1.1rem;
            color: var(--netflix-white);
            line-height: 1.6;
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
            padding: 0.7rem 1rem;
            border-radius: 6px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform var(--transition-speed) ease;
        }
    
        .btn-primary:hover {
            background: #e8941a;
            transform: translateY(-2px);
        }
    
        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: var(--netflix-white);
            padding: 0.8rem 2rem;
            border-radius: 6px;
            font-size: 1.1rem;
            cursor: pointer;
            backdrop-filter: blur(10px);
            transition: transform var(--transition-speed) ease;
        }
    
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }
    
        /* Sidebar container */
        /* .details-sidebar {
            width: 300px;
            background-color: var(--netflix-gray);
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        } */
    
        /* Grid for details */
        .details-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
        }
    
        /* Individual detail item */
        .detail-item {
            padding: 10px;
            background-color: var(--netflix-gray);
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }
    
        /* Hover effect for detail items */
        .detail-item:hover {
            background-color: #f1f1f1;
        }
    
        /* Label for each detail item */
        .detail-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
            font-size: 14px;
        }
    
        /* Value for each detail item */
        .detail-value {
            color: #555;
            font-size: 14px;
        }
    
        /* Specific styling for the duration and language (optional) */
        .detail-item .detail-value {
            font-style: italic;
            color: #888;
        }
    
        /* Style for the 'Release Year' section */
        .detail-item .detail-label {
            color: #007bff;
        }
    
        /* Responsive Design for smaller screens */
        @media (max-width: 768px) {
            .details-sidebar {
                width: 100%;
                margin-top: 0;
                padding: 15px;
                margin-bottom: 4rem;
            }
        }
    
        /* Responsive Design */
        @media (max-width: 768px) {
            .video-container {
                height: 50vh;
            }
    
            .video-player {
                height: 100%;
            }
    
            .details-header {
                flex-direction: column;
                gap: 1.5rem;
                margin: 0;
            }
            .description{
                margin-bottom: 1rem;
            }
            .details-main {
                flex: 1;
            }
            .action-buttons {
                justify-content: center;
                margin-bottom: 0;
            }
            .video-controls-buttons {
                gap: 0.5rem;
                margin-left: 2%;
            }
            .video-control-btn {
                font-size: 1rem;
            }
            .video-time {
                font-size: 1rem;
                display: flex;
                margin-left: 2%;
            }
            .movie-title {
                font-size: 1.5rem;
            }
        }
    </style>
    <?php $__env->stopPush(); ?>
    
    <?php $__env->startSection('content'); ?>
    <div class="single-video-page">
        <div class="video-container">
            <div class="video-player">
                <?php if(auth()->guard()->check()): ?>
                <?php if(auth()->user()->hasActiveSubscription('fitdoc')): ?>
                <video class="video-element" id="mainVideo"
                    poster="<?php echo e($fitDoc->banner_image_url ?? 'https://images.unsplash.com/photo-1574680096145-d05b474e2155?ixlib=rb-4.0.3'); ?>"
                    controlslist="nodownload nofullscreen noremoteplayback" disablepictureinpicture
                    oncontextmenu="return false;">
                    <source
                        src="<?php echo e($fitDoc->video_path ? asset('storage/app/public/' . $fitDoc->video_path) : 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4'); ?>"
                        type="video/mp4">
                    <source
                        src="<?php echo e($fitDoc->video_path ? asset('storage/app/public/' . $fitDoc->video_path) : 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4'); ?>"
                        type="video/webm">
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
                            <i class="fas fa-volume-up"></i>
                        </button>
                        <button class="video-control-btn" onclick="toggleFullscreen()">
                            <i class="fas fa-expand"></i>
                        </button>
                    </div>
                    <div class="video-time">
                        <span id="currentTime">00:00</span> / <span id="durationTime">00:00</span>
                    </div>
                </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    
        <div class="content-details">
            <div class="details-header">
                <div class="details-main">
                    <div class="movie-title"><?php echo e($fitDoc->title); ?></div>
                    <div class="movie-meta">
                        <div class="meta-item">
                            <i class="fas fa-star"></i>
                            <span class="rating">HD</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-calendar-alt"></i><?php echo e($fitDoc->created_at->format('Y')); ?>

                        </div>
                        <div class="meta-item">
                            <i class="fas fa-clock"></i> <?php echo e($fitDoc->duration_minutes ?? 90); ?> min
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-tags"></i> <?php echo e($fitDoc->category->name ?? 'N/A'); ?>

                        </div>
                    </div>
                    <p class="description"><?php echo e($fitDoc->description); ?></p>
                    <div class="action-buttons">
                        <button class="btn-primary" id="playPauseButton" onclick="togglePlayPause()">Play Now</button>
                        <button class="btn-secondary">Add to Watchlist</button>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let video = $('#mainVideo')[0];
        let playButton = $('#playButton');
        let playPauseBtn = $('#playPauseBtn');
        let progressBar = $('#progressBar');
        let currentTimeDisplay = $('#currentTime');
        let durationTimeDisplay = $('#durationTime');
        let volumeIcon = $('#volumeIcon');
        let volumeSlider = $('#volumeSlider');
        let speedControl = $('#speedControl');
        let videoControls = $('#videoControls');
        let progressTooltip = $('#progressTooltip');
        let isMuted = false;
        let isPlaying = false;
    
        // Play/Pause button toggle
        function togglePlayPause() {
            if (video.paused) {
                video.play();
                playPauseBtn.html('<i class="fas fa-pause"></i>');
            } else {
                video.pause();
                playPauseBtn.html('<i class="fas fa-play"></i>');
            }
            isPlaying = !video.paused;
            playButton.fadeOut();  // Hide play button after video starts playing
        }
    
        // Video Play
        function playVideo() {
            if (!isPlaying) {
                video.play();
                playPauseBtn.html('<i class="fas fa-pause"></i>');
                playButton.fadeOut();
                isPlaying = true;
            }
        }
    
        // Toggle Mute
        function toggleMute() {
            isMuted = !isMuted;
            video.muted = isMuted; // Ensure this sets the muted state of the video element
            if (isMuted) {
                volumeIcon.attr('class', 'fas fa-volume-mute');
            } else {
                volumeIcon.attr('class', 'fas fa-volume-up');
            }
        }
    
        // Fullscreen
        function toggleFullscreen() {
            if (document.fullscreenElement) {
                document.exitFullscreen();
            } else {
                video.requestFullscreen();
            }
        }
    
        // Speed Control
        function changeSpeed() {
            video.playbackRate = parseFloat(speedControl.val());
        }
    
        // Volume Control
        volumeSlider.on('input', function () {
            video.volume = volumeSlider.val() / 100;
            if (video.volume === 0) {
                volumeIcon.attr('class', 'fas fa-volume-mute');
            } else {
                volumeIcon.attr('class', 'fas fa-volume-up');
            }
        });
    
        // Seek Video by clicking on progress bar
        progressBar.on('click', function (event) {
            let progressWidth = progressBar.width();  // Get the width of the progress bar
            let offsetX = event.offsetX;  // Get the X position of the mouse click within the progress bar
            let newTime = (offsetX / progressWidth) * video.duration;  // Calculate the new time in the video
            video.currentTime = newTime;  // Set the video's current time to the new time
        });
    
        // Update Progress Bar and Time
        video.ontimeupdate = function () {
            let progress = (video.currentTime / video.duration) * 100;
            progressBar.css('width', progress + '%');
    
            let currentTime = formatTime(video.currentTime);
            let duration = formatTime(video.duration);
            currentTimeDisplay.text(currentTime);
            durationTimeDisplay.text(duration);
        };
    
        // Format time for display
        function formatTime(seconds) {
            let minutes = Math.floor(seconds / 60);
            let remainingSeconds = Math.floor(seconds % 60);
            return `${minutes}:${remainingSeconds < 10 ? '0' : ''}${remainingSeconds}`;
        }
    
        // Show controls on hover
        video.addEventListener('mousemove', function () {
            videoControls.css('opacity', '1');
        });
    
        // Hide controls after 2 seconds of inactivity
        let hideControlsTimeout;
        video.addEventListener('mouseleave', function () {
            hideControlsTimeout = setTimeout(() => {
                videoControls.css('opacity', '0');
            }, 2000);
        });
    
        // Replay Video after it ends
        video.addEventListener('ended', function () {
            $('#replayButton').fadeIn();
        });
    
        // Replay Button
        $('#replayButton').click(function () {
            video.currentTime = 0;
            video.play();
            $('#replayButton').fadeOut();
        });
    
        // Keyboard Shortcuts
        $(document).keydown(function (e) {
            switch (e.key) {
                case ' ':
                    togglePlayPause();  // Space for play/pause
                    break;
                case 'm':
                    toggleMute();  // M for mute/unmute
                    break;
                case 'f':
                    toggleFullscreen();  // F for fullscreen
                    break;
                case 'ArrowRight':
                    video.currentTime += 5;  // Fast forward by 5 seconds
                    break;
                case 'ArrowLeft':
                    video.currentTime -= 5;  // Rewind by 5 seconds
                    break;
            }
        });
    
        // When video starts, hide the play button
        video.onplay = function () {
            playButton.fadeOut();
        };
    
        // When video is paused, show the play button
        video.onpause = function () {
            playButton.fadeIn();
        };
    
        // Progress Bar Tooltip
        progressBar.on('mousemove', function (e) {
            let time = (e.offsetX / progressBar.width()) * video.duration;
            let tooltipText = formatTime(time);
            progressTooltip.text(tooltipText).css({
                left: e.pageX - progressBar.offset().left + 10 + 'px',
                top: e.pageY - progressBar.offset().top - 25 + 'px',
                display: 'block'
            });
        });
    
        progressBar.on('mouseleave', function () {
            progressTooltip.hide();
        });
    
        // Speed Control dropdown change
        speedControl.change(function () {
            changeSpeed();
        });
    
        // Toggle Play/Pause when video is clicked
        $('#mainVideo').on('click', function() {
            togglePlayPause(); // Call the toggle function to play or pause
        });
    </script>
    <?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fittley\resources\views/public/fitdoc/single.blade.php ENDPATH**/ ?>