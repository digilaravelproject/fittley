@extends('layouts.public')

@section('title', $episode->title . ' - ' . $fgSeries->title . ' - FitGuide')

@section('content')
    <div class="container px-0 text-white">
        <!-- Hero Section -->
        <section class=" py-1 py-md-2 py-lg-4"
            style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.8)), url('{{ $fgSeries->banner_image_url ? getImagePath($fgSeries->banner_image_url) : 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b' }}') center/cover;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb" class="mb-3">
                            <ol class="breadcrumb bg-transparent p-0">
                                <li class="breadcrumb-item"><a href="{{ route('fitguide.index') }}"
                                        class="text-light">FitGuide</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('fitguide.series.show', $fgSeries->slug) }}"
                                        class="text-light">{{ $fgSeries->title }}</a></li>
                                <li class="breadcrumb-item active text-warning" aria-current="page">Episode
                                    {{ $episode->episode_number }}</li>
                            </ol>
                        </nav>

                        <h1 class="display-5 fw-bold">{{ $episode->title }}</h1>
                        <p class="lead text-light">{{ $episode->description ?? 'No description available.' }}</p>

                        <!-- Episode Info -->
                        <div class="d-flex flex-wrap gap-4 text-light mb-4">
                            @if($episode->duration_minutes)
                                <div><i class="fas fa-clock me-2 text-warning"></i>Duration: {{ $episode->formatted_duration }}
                                </div>
                            @endif
                            <div><i class="fas fa-list me-2 text-warning"></i>Episode: {{ $episode->episode_number }}</div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex flex-wrap gap-3">
                            @if($episode->video_url || $episode->video_file_path)
                                <button class="btn btn-warning btn-lg" onclick="startEpisode()"><i
                                        class="fas fa-play me-2"></i>Watch Episode</button>
                            @endif
                            <a href="{{ route('fitguide.series.show', $fgSeries->slug) }}"
                                class="btn btn-outline-light btn-lg"><i class="fas fa-list me-2"></i>All Episodes</a>
                            <button class="btn btn-outline-light btn-lg"><i class="fas fa-bookmark me-2"></i>Save
                                Episode</button>
                        </div>
                    </div>

                    <!-- Poster -->
                    <div class="col-lg-4 mt-4 mt-lg-0 text-center">
                        <img src="{{ $fgSeries->banner_image_url ? getImagePath($fgSeries->banner_image_url) : 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b' }}"
                            class="img-fluid rounded shadow" alt="{{ $episode->title }}" style="max-height: 400px;">
                    </div>
                </div>
            </div>
        </section>

        <!-- Video Section -->
        <section id="videoSection" style="display: none;">
            <div class="position-relative" style="height: 70vh; background: #000;">
                @php
                    $videoType = null;
                    $videoSource = null;
                    $youtubeId = null;

                    if ($episode->video_type === 'youtube' && $episode->video_url) {
                        $videoType = 'youtube';
                        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $episode->video_url, $matches);
                        $youtubeId = $matches[1] ?? null;
                    } elseif ($episode->video_type === 's3') {
                        $videoType = 's3';
                        $videoSource = $episode->video_url;
                    } elseif ($episode->video_type === 'upload') {
                        $videoType = 'upload';
                        $videoSource = asset('storage/app/public/' . $episode->video_file_path);
                    } elseif ($episode->video_url) {
                        $videoType = 'direct';
                        $videoSource = $episode->video_url;
                    }
                @endphp

                @if($videoType === 'youtube' && $youtubeId)
                    <iframe class="w-100 h-100" src="https://www.youtube.com/embed/{{ $youtubeId }}?autoplay=1&modestbranding=1"
                        frameborder="0" allowfullscreen></iframe>
                @elseif($videoSource)
                    <video id="episodeVideo" class="w-100 h-100" controls>
                        <source src="{{ $videoSource }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <!-- Custom Controls (optional) -->
                    <div
                        class="position-absolute bottom-0 start-0 end-0 p-3 bg-dark bg-opacity-50 d-flex justify-content-between align-items-center">
                        <button class="btn btn-light" onclick="toggleVideo()"><i id="playPauseIcon"
                                class="fas fa-play"></i></button>
                        <input type="range" id="progressBar" class="form-range w-75" min="0" max="100" value="0">
                        <button class="btn btn-danger" onclick="closeVideo()"><i class="fas fa-times"></i></button>
                    </div>
                @else
                    <div class="d-flex justify-content-center align-items-center h-100 text-center text-muted">
                        <div>
                            <i class="fas fa-video-slash fa-3x mb-3"></i>
                            <h4>Video Not Available</h4>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <!-- About Section -->
        @if($episode->description)
            <section class=" py-1 py-md-2 py-lg-4 bg-black">
                <div class="container">
                    <h3 class="text-warning mb-3">About This Episode</h3>
                    <p class="text-light">{!! nl2br(e($episode->description)) !!}</p>
                </div>
            </section>
        @endif

        <!-- All Episodes -->
        <section class=" py-1 py-md-2 py-lg-4 bg-dark">
            <div class="container">
                <h3 class="text-white mb-4">{{ $fgSeries->title }} - All Episodes</h3>
                <div class="row g-1">
                    @foreach($fgSeries->episodes->where('is_published', true) as $ep)
                        <div class="col-lg-3 col-md-6">
                            <div
                                class="card bg-secondary border-0 shadow-sm {{ $ep->id === $episode->id ? 'border border-warning' : '' }}">
                                <img src="{{ getImagePath($fgSeries->banner_image_url) }}" class="card-img-top"
                                    alt="Episode {{ $ep->episode_number }}">
                                <div class="card-body">
                                    <h6 class="card-title text-white">Ep {{ $ep->episode_number }}: {{ $ep->title }}</h6>
                                    <p class="card-text text-light small">{{ Str::limit($ep->description, 80) }}</p>
                                    @if($ep->id === $episode->id)
                                        <button class="btn btn-warning w-100" onclick="startEpisode()"><i
                                                class="fas fa-play me-2"></i>Currently Watching</button>
                                    @else
                                        <a href="{{ route('fitguide.series.episode', [$fgSeries->slug, $ep->episode_number]) }}"
                                            class="btn btn-outline-light w-100"><i class="fas fa-play me-2"></i>Watch</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>

    <!-- Script -->


    <?php /*<script>
       $(document).ready(function() {

       // Function to start the episode
       function startEpisode() {
           const videoType = @json($videoType); // Get the video type from Blade to JavaScript

           if (videoType) {
               $('#videoSection').fadeIn().scrollIntoView({ behavior: 'smooth' });

               if (videoType === 'youtube') {
                   // YouTube iframe will auto-load, no need to programmatically play
                   console.log('YouTube video loaded');
               } else {
                   // For HTML5 video players (like S3 or uploaded videos)
                   const video = $('#episodeVideo')[0]; // Get the actual video DOM element
                   if (video) {
                       video.play().catch(function(error) {
                           console.log('Auto-play was prevented:', error);
                           // Optionally show a play button if auto-play fails
                       });
                       updatePlayPauseIcon();
                   }
               }
           } else {
               alert('Video not available for this episode');
           }
       }

       // Toggle play/pause of the video
       function toggleVideo() {
           const video = $('#episodeVideo')[0];
           if (video.paused) {
               video.play();
           } else {
               video.pause();
           }
           updatePlayPauseIcon();
       }

       // Close the video section
       function closeVideo() {
           const video = $('#episodeVideo')[0];
           if (video) {
               video.pause();
           }
           $('#videoSection').fadeOut();
           $('html, body').animate({ scrollTop: 0 }, 'smooth');
       }

       // Update the play/pause icon
       function updatePlayPauseIcon() {
           const video = $('#episodeVideo')[0];
           const icon = $('#playPauseIcon');
           if (video && icon.length) {
               icon.attr('class', video.paused ? 'fas fa-play' : 'fas fa-pause');
           }
       }

       // Video progress tracking
       const video = $('#episodeVideo')[0];
       const progressBar = $('#progressBar');

       if (video && progressBar.length) {
           // Update progress bar as video plays
           $(video).on('timeupdate', function() {
               if (video.duration && !isNaN(video.duration)) {
                   const progress = (video.currentTime / video.duration) * 100;
                   progressBar.val(progress);
               }
           });

           // Scrubbing (seeking) via the progress bar
           progressBar.on('input', function() {
               if (video.duration && !isNaN(video.duration)) {
                   const time = (progressBar.val() / 100) * video.duration;
                   video.currentTime = time;
               }
           });

           // Update play/pause icon when video is played or paused
           $(video).on('play', updatePlayPauseIcon);
           $(video).on('pause', updatePlayPauseIcon);

           // Handle video loading errors
           $(video).on('error', function(e) {
               console.error('Video failed to load:', e);
               alert('Sorry, there was an error loading the video. Please check your connection and try again.');
           });

           // Handle when the video is ready to play
           $(video).on('canplay', function() {
               console.log('Video is ready to play');
           });
       }

       // Event Listeners for the buttons
       $('#startEpisodeBtn').on('click', startEpisode); // Assuming button has an id of startEpisodeBtn
       $('#toggleVideoBtn').on('click', toggleVideo);   // Assuming button has an id of toggleVideoBtn
       $('#closeVideoBtn').on('click', closeVideo);     // Assuming button has an id of closeVideoBtn
    });
    </script>*/ ?>

    <script>
        function startEpisode() {
            const videoType = @json($videoType);

            if (videoType) {
                $('#videoSection').fadeIn();
                document.getElementById('videoSection').scrollIntoView({ behavior: 'smooth' });

                if (videoType === 'youtube') {
                    console.log('YouTube video loaded');
                } else {
                    const video = $('#episodeVideo')[0];
                    if (video) {
                        video.play().catch(error => console.log('Auto-play prevented:', error));
                        updatePlayPauseIcon();
                    }
                }
            } else {
                alert('Video not available for this episode');
            }
        }

        function toggleVideo() {
            const video = $('#episodeVideo')[0];
            if (video.paused) {
                video.play();
            } else {
                video.pause();
            }
            updatePlayPauseIcon();
        }

        function closeVideo() {
            const video = $('#episodeVideo')[0];
            if (video) video.pause();
            $('#videoSection').fadeOut();
            $('html, body').animate({ scrollTop: 0 }, 'smooth');
        }

        function updatePlayPauseIcon() {
            const video = $('#episodeVideo')[0];
            const icon = $('#playPauseIcon');
            if (video && icon.length) {
                icon.attr('class', video.paused ? 'fas fa-play' : 'fas fa-pause');
            }
        }

        $(document).ready(function () {
            const video = $('#episodeVideo')[0];
            const progressBar = $('#progressBar');

            if (video && progressBar.length) {
                $(video).on('timeupdate', function () {
                    if (video.duration && !isNaN(video.duration)) {
                        progressBar.val((video.currentTime / video.duration) * 100);
                    }
                });

                progressBar.on('input', function () {
                    if (video.duration && !isNaN(video.duration)) {
                        video.currentTime = (progressBar.val() / 100) * video.duration;
                    }
                });

                $(video).on('play pause', updatePlayPauseIcon);
                $(video).on('canplay', () => console.log('Video ready'));
                $(video).on('error', e => console.error('Video load error:', e));
            }
        });
    </script>

@endsection