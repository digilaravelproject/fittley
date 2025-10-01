@extends('layouts.public')

@section('title', 'FITTELLY - Your Ultimate Fitness Destination')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/home/css/homepage.css') }}?v={{ time() }}">
@endpush

@section('content')
    <div class="homepage-container">
        <!-- Hero Section -->
        <section class="hero-section">
            @if ($hero && isset($hero['play_button_link']))
                <!-- Local Background Video -->
                <video class="hero-video" autoplay muted loop playsinline preload="auto"
                    controlslist="nodownload nofullscreen noremoteplayback" disablepictureinpicture
                    oncontextmenu="return false;">
                    <source src="{{ asset(str_replace('/storage/app/public/', '/storage/app/public/', $hero['play_button_link'])) }}"
                        type="video/mp4">
                </video>
            @elseif ($hero && isset($hero['youtube_video_id']))
                <!-- YouTube Video Background -->
                <iframe id="yt-hero-video" class="hero-video"
                    src="https://www.youtube.com/embed/{{ $hero['youtube_video_id'] }}?autoplay=1&mute=1&loop=1&playlist={{ $hero['youtube_video_id'] }}&controls=0&modestbranding=1&rel=0&showinfo=0&disablekb=1&fs=0&iv_load_policy=3&cc_load_policy=0&playsinline=1&enablejsapi=1&origin={{ request()->getSchemeAndHttpHost() }}"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen loading="lazy">
                </iframe>
            @endif

            <!-- Video Overlay -->
            <div class="hero-overlay"></div>

            <div class="container">
                <div class="hero-content">
                    @if ($hero && $hero->category)
                        <div class="hero-category mt-4">{{ $hero->category }}</div>
                    @endif
                    <h1>{{ $hero ? $hero->title : 'Transform Your Fitness Journey' }}</h1>
                    @if ($hero && ($hero->duration || $hero->year))
                        <div class="hero-meta">
                            @if ($hero->duration)
                                <span><i class="fas fa-clock"></i> {{ $hero->duration }}</span>
                            @endif
                            @if ($hero->year)
                                <span><i class="fas fa-calendar"></i> {{ $hero->year }}</span>
                            @endif
                            <span><i class="fas fa-star"></i> Premium Content</span>
                        </div>
                    @endif
                    <p>{{ $hero ? $hero->description : 'Discover world-class fitness documentaries, live training sessions, expert guides, and the latest fitness news - all in one place.' }}
                    </p>
                    <div class="hero-buttons">
                        <a href="{{ $hero && $hero->play_button_link ? $hero->play_button_link : '#' }}"
                            class="btn-hero primary">
                            <i class="fas fa-play"></i>
                            {{ $hero && $hero->play_button_text ? $hero->play_button_text : 'Start Watching' }}
                        </a>
                        @if ($hero && $hero->trailer_button_text)
                            <a href="{{ $hero->trailer_button_link ?? '#' }}"
                                class="btn-hero btn btn-outline-light border">
                                <i class="fas fa-info-circle"></i> {{ $hero->trailer_button_text }}
                            </a>
                        @else
                            <a href="#" class="btn-hero btn btn-outline-light border">
                                <i class="fas fa-info-circle"></i> Learn More
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <div class="container-fluid">
            <!-- FitDoc Section -->
            @if ($fitDocVideos->count() > 0 || $fitDocSeries->count() > 0)
                <section class="content-section mt-2">
                    <a href="{{ route('fitdoc.index') }}" class="text-decoration-none">
                    <div class="section-header">
                        <h2 class="section-title">
                            {{-- <i class="fas fa-film"></i>  --}}
                            FitSeries
                        </h2>
                        <span class="view-all-btn opacity-75">View All</span>
                    </div>
                </a>

                    <!-- FitDoc Videos -->
                    @if ($fitDocVideos->count() > 0)
                        <div class="category-section">
                            <h3 class="category-title">Documentory</h3>
                            <div class="content-slider">

                                <div class="slider-container" id="fitdoc-videos-slider">
                                    @foreach ($fitDocVideos as $video)
                                        <x-home.portrait-card-second :video="$video"  url="fitdoc.single.show"/>
                                    @endforeach
                                </div>

                                <button class="slider-controls slider-prev"
                                    onclick="slideContent('fitdoc-videos-slider', -1)">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="slider-controls slider-next"
                                    onclick="slideContent('fitdoc-videos-slider', 1)">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>

                        </div>
                    @endif

                    <!-- FitDoc Series -->
                    @if ($fitDocSeries->count() > 0)
                        <div class="category-section">
                            <h3 class="category-title">Season</h3>
                            <div class="content-slider">
                                <div class="slider-container" id="fitdoc-series-slider">
                                       @foreach ($fitDocSeries as $video)
                                        <x-home.portrait-card :video="$video" badge="Series" badgeClass="badge-series" url="fitdoc.series.show"/>
                                    @endforeach

                                </div>
                                <button class="slider-controls slider-prev"
                                    onclick="slideContent('fitdoc-series-slider', -1)">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="slider-controls slider-next"
                                    onclick="slideContent('fitdoc-series-slider', 1)">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                </section>
            @endif

            <!-- FitLive Section -->
            @if ($fitLiveCategories->count() > 0)
                <section class="content-section mt-4">
                    <a href="{{ route('fitlive.index') }}" class="text-decoration-none">
                        <div class="section-header">
                            <h2 class="section-title">
                                FitLive
                            </h2>
                            <span class="opacity-75 view-all-btn">View All</span>
                        </div>
                    </a>

                    @foreach ($fitLiveCategories as $category)
                        @php
                            // Collect all subcategories inside this category
                            $allContent = $category->subCategories;
                        @endphp

                        @if ($allContent->count() > 0)
                            <div class="category-section">
                                <h3 class="category-title">{{ $category->name }}</h3>
                                <div class="content-slider">
                                    <div class="slider-container" id="fitlive-{{ $category->id }}-slider">
                                        @foreach ($allContent as $subCategory)

                                            @if ($category->id == 21)
                                                <x-home.landscape-card
                                                    :route="route('fitlive.daily-classes.show', $category->slug)"
                                                    :title="$subCategory->title"
                                                    :image="$subCategory->banner_image ? asset('storage/app/public/' . $subCategory->banner_image) : null"
                                                    :badge="['label' => 'Live', 'class' => 'badge-live']"
                                                    :meta="[ '<i class=\'fas fa-calendar\'></i> ' . ($subCategory->created_at?->format('M d, Y') ?? '') ]"
                                                />
                                            @else
                                        {{ $subCategory->title }}
                                            @php
                                                if ($category->id == 21) {
                                                    $route = 'fitlive.daily-classes.show';
                                                } else {
                                                    $route = 'fitlive.index';
                                                }
                                            @endphp
                                                <x-home.portrait-card
                                                    :video="$subCategory"
                                                    badge="Live"
                                                    badgeClass="badge-live"
                                                    :url="$route"
                                                />
                                            @endif
                                        @endforeach
                                    </div>

                                    <button class="slider-controls slider-prev"
                                        onclick="slideContent('fitlive-{{ $category->id }}-slider', -1)">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button class="slider-controls slider-next"
                                        onclick="slideContent('fitlive-{{ $category->id }}-slider', 1)">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </section>
            @endif

            <!-- FitArena Live Section -->
            @if ($fitarenaliveEvents->count() > 0 || $fitarenaliveEvents->count() > 0)
                <section class="content-section mt-2">
                    <a href="{{ route('fitarena.index') }}" class="text-decoration-none">
                        <div class="section-header">
                            <h2 class="section-title">
                                FitArena Live
                            </h2>
                            <span class="view-all-btn opacity-75">View All</span>
                        </div>
                    </a>

                    <div class="category-section">
                        <h3 class="category-title">Live Events</h3>
                        <div class="content-slider">
                            <div class="slider-container" id="fitarena-live-slider">

                                @foreach ($fitarenaliveEvents as $event)
                                        @php
                                                $badge = match ($event->status) {
                                                    'upcoming' => ['label' => 'Upcoming', 'class' => 'badge-upcoming'],
                                                    'live'     => ['label' => 'Live',     'class' => 'badge-live'],
                                                    'ended'    => ['label' => 'Ended',    'class' => 'badge-ended'],
                                                };
                                            @endphp
                                                <x-home.landscape-card
                                                    :route="route('fitarena.show', $event)"
                                                    :title="$event->title"
                                                    :image="$event->banner_image_path ? $event->banner_image_path : null"
                                                    :badge="$badge"
                                                    :meta="[ '<i class=\'fas fa-calendar\'></i> ' . ($event->created_at?->format('M d, Y') ?? '') ]"
                                                />
                                {{-- <x-home.portrait-card
                                        :video="$event"
                                        badge="Live"
                                        badgeClass="badge-live"
                                        url="fitarena.show"
                                    /> --}}
                                @endforeach

                            </div>

                            <button class="slider-controls slider-prev"
                                onclick="slideContent('fitarena-live-slider', -1)">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button class="slider-controls slider-next"
                                onclick="slideContent('fitarena-live-slider', 1)">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </section>
            @endif

            <!-- FitGuide Section -->
            @if ($fitGuideCategories->count() > 0)
                <section class="content-section mt-4">
                    <a href="{{ route('fitguide.index') }}" class="text-decoration-none">
                    <div class="section-header">
                        <h2 class="section-title">
                            {{-- <i class="fas fa-dumbbell"></i> --}}
                             FitGuide
                        </h2>
                        <span class="opacity-75 view-all-btn">View All</span>
                    </div>
                    </a>

                    @foreach ($fitGuideCategories as $category)
                        @php
                            $allContent = $category->singles->merge($category->series);
                        @endphp
                        @if ($allContent->count() > 0)
                            <div class="category-section">
                                <h3 class="category-title">{{ $category->name }}</h3>
                                <div class="content-slider">
                                    <div class="slider-container" id="fitguide-{{ $category->id }}-slider">
                                    @foreach ($allContent as $content)
                                        @php
                                            $isFitcastLive = $category->slug === 'fitcast-live';
                                        @endphp

                                        @if ($isFitcastLive)
                                            <x-home.landscape-card
                                                :route="route('fitguide.index', ['category' => $category->slug])"
                                                :title="$content->title"
                                                :image="$content->banner_image ? asset('storage/app/public/' . $content->banner_image) : null"
                                                :badge="['label' => 'Live', 'class' => 'badge-live']"
                                                :meta="[ '<i class=\'fas fa-calendar\'></i> ' . ($content->created_at?->format('M d, Y') ?? '') ]"
                                            />
                                        @else
                                            <x-home.portrait-card
                                                :video="$content"
                                                url="fitguide.index"
                                                :categorySlug="$category->slug"
                                            />
                                        @endif
                                    @endforeach

                                    </div>
                                    <button class="slider-controls slider-prev"
                                        onclick="slideContent('fitguide-{{ $category->id }}-slider', -1)">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button class="slider-controls slider-next"
                                        onclick="slideContent('fitguide-{{ $category->id }}-slider', 1)">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>

                            </div>
                        @endif
                    @endforeach
                </section>
            @endif

            <!-- FitNews Section -->

            {{-- @if ($fitNewsLive->count() > 0 || $fitNewsArchive->count() > 0) --}}
            @if (count($fitNewsLive ?? []) > 0 || count($fitNewsArchive ?? []) > 0)

            <section class="content-section mt-4">
                <a href="{{ route('fitnews.index') }}" class="text-decoration-none">
                    <div class="section-header">
                        <h2 class="section-title">
                            {{-- <i class="fas fa-newspaper"></i>  --}}
                            FitNews
                        </h2>
                        <span class="opacity-75 view-all-btn">View All</span>
                    </div>
                </a>

                    <div class="content-slider">
                        <div class="slider-container" id="fitnews-slider">
                        @foreach ($fitNewsLive as $news)
                        <x-home.landscape-card
                                :route="route('fitnews.show', $news)"
                                :title="$news->title"
                                :image="$news->thumbnail ? asset('storage/app/public/' . $news->thumbnail) : null"
                                :badge="['label' => 'LIVE', 'class' => 'badge-live']"
                                :meta="[
                                    '<i class=\'fas fa-user\'></i> ' . ($news->creator->name ?? 'Admin'),
                                    '<i class=\'fas fa-eye\'></i> ' . ($news->viewer_count ?? 0) . ' watching'
                                ]"
                            />
                        @endforeach

                        @foreach ($fitNewsArchive as $news)
                            <x-home.landscape-card
                                :route="route('fitnews.show', $news)"
                                :title="$news->title"
                                :image="$news->thumbnail ? asset('storage/app/public/' . $news->thumbnail) : null"
                                :badge="[
                                    'label' => $news->status === 'scheduled' ? 'Upcoming' : 'Archive',
                                    'class' => 'badge-single'
                                ]"
                                :meta="[
                                    '<i class=\'fas fa-user\'></i> ' . ($news->creator->name ?? 'Admin'),
                                    '<i class=\'fas fa-calendar\'></i> ' . ($news->scheduled_at ? $news->scheduled_at->format('M d') : 'TBD')
                                ]"
                            />
                        @endforeach

                        </div>
                        <button class="slider-controls slider-prev" onclick="slideContent('fitnews-slider', -1)">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="slider-controls slider-next" onclick="slideContent('fitnews-slider', 1)">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </section>
            @endif

            <!-- FitInsights Section -->
            @if ($fitInsights->count() > 0)
                <section class="content-section my-4">
                    <a href="{{ route('fitinsight.index') }}" class="text-decoration-none">
                    <div class="section-header">
                        <h2 class="section-title">
                            FitInsights
                        </h2>
                        <span class="opacity-75 view-all-btn">View All</span>
                    </div>
                    </a>

                    <div class="content-slider">
                        <div class="slider-container" id="fitinsights-slider">
                            @foreach ($fitInsights as $insight)
                                <x-home.portrait-card
                                    :video="$insight"
                                    badge="Article"
                                    badgeClass="badge-single"
                                    url="fitinsight.index"
                                />
                            @endforeach
                        </div>
                        <button class="slider-controls slider-prev" onclick="slideContent('fitinsights-slider', -1)">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="slider-controls slider-next" onclick="slideContent('fitinsights-slider', 1)">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>

                </section>
            @endif
        </div>
    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
    <script src="https://www.youtube.com/iframe_api"></script>
    <script src="{{ asset('assets/home/js/homepage.js') }}?v={{ time() }}"></script>
@endpush
