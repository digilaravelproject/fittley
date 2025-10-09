

<?php $__env->startSection('title', 'FITTELLY - Your Ultimate Fitness Destination'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/home/css/homepage.css')); ?>?v=<?php echo e(time()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="homepage-container">
        <!-- Hero Section -->
        <section class="hero-section">
            <?php if($hero && isset($hero['play_button_link'])): ?>
                <!-- Local Background Video -->
                <video class="hero-video" autoplay muted loop playsinline preload="auto"
                    controlslist="nodownload nofullscreen noremoteplayback" disablepictureinpicture
                    oncontextmenu="return false;">
                    <source
                        src="<?php echo e(asset(str_replace('/storage/app/public/', '/storage/app/public/', $hero['play_button_link']))); ?>"
                        type="video/mp4">
                </video>
            <?php elseif($hero && isset($hero['youtube_video_id'])): ?>
                <!-- YouTube Video Background -->
                <iframe id="yt-hero-video" class="hero-video"
                    src="https://www.youtube.com/embed/<?php echo e($hero['youtube_video_id']); ?>?autoplay=1&mute=1&loop=1&playlist=<?php echo e($hero['youtube_video_id']); ?>&controls=0&modestbranding=1&rel=0&showinfo=0&disablekb=1&fs=0&iv_load_policy=3&cc_load_policy=0&playsinline=1&enablejsapi=1&origin=<?php echo e(request()->getSchemeAndHttpHost()); ?>"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen loading="lazy">
                </iframe>
            <?php endif; ?>

            <!-- Video Overlay -->
            <div class="hero-overlay"></div>

            <div class="container">
                <div class="hero-content">
                    <?php if($hero && $hero->category): ?>
                        <div class="hero-category mt-4"><?php echo e($hero->category); ?></div>
                    <?php endif; ?>
                    <h1><?php echo e($hero ? $hero->title : 'Transform Your Fitness Journey'); ?></h1>
                    <?php if($hero && ($hero->duration || $hero->year)): ?>
                        <div class="hero-meta">
                            <?php if($hero->duration): ?>
                                <span><i class="fas fa-clock"></i> <?php echo e($hero->duration); ?></span>
                            <?php endif; ?>
                            <?php if($hero->year): ?>
                                <span><i class="fas fa-calendar"></i> <?php echo e($hero->year); ?></span>
                            <?php endif; ?>
                            <span><i class="fas fa-star"></i> Premium Content</span>
                        </div>
                    <?php endif; ?>
                    <p><?php echo e($hero ? $hero->description : 'Discover world-class fitness documentaries, live training sessions,
                        expert guides, and the latest fitness news - all in one place.'); ?>

                    </p>
                    <div class="hero-buttons">
                        <a href="<?php echo e($hero && $hero->play_button_link ? $hero->play_button_link : '#'); ?>"
                            class="btn-hero primary">
                            <i class="fas fa-play"></i>
                            <?php echo e($hero && $hero->play_button_text ? $hero->play_button_text : 'Start Watching'); ?>

                        </a>
                        <?php if($hero && $hero->trailer_button_text): ?>
                            <a href="<?php echo e($hero->trailer_button_link ?? '#'); ?>" class="btn-hero btn btn-outline-light border">
                                <i class="fas fa-info-circle"></i> <?php echo e($hero->trailer_button_text); ?>

                            </a>
                        <?php else: ?>
                            <a href="#" class="btn-hero btn btn-outline-light border">
                                <i class="fas fa-info-circle"></i> Learn More
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <div class="container-fluid">
            <!-- FitDoc Section -->
            <?php if($fitDocVideos->count() > 0 || $fitDocSeries->count() > 0): ?>
                <section class="content-section mt-2">
                    <a href="<?php echo e(route('fitdoc.index')); ?>" class="text-decoration-none">
                        <div class="section-header">
                            <h2 class="section-title">
                                
                                FitSeries
                            </h2>
                            <span class="view-all-btn opacity-75">View All</span>
                        </div>
                    </a>

                    <!-- FitDoc Videos -->
                    <?php if($fitDocVideos->count() > 0): ?>
                        <div class="category-section mb-1">
                            <h3 class="category-title">Documentory</h3>
                            <div class="content-slider">

                                <div class="slider-container" id="fitdoc-videos-slider">
                                    <?php $__currentLoopData = $fitDocVideos->sortByDesc('id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if (isset($component)) { $__componentOriginal6fb9a3a5133c0cbd1e59f8d65daeecd1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6fb9a3a5133c0cbd1e59f8d65daeecd1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.portrait-card-second','data' => ['video' => $video,'url' => 'fitdoc.single.show']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.portrait-card-second'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['video' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($video),'url' => 'fitdoc.single.show']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6fb9a3a5133c0cbd1e59f8d65daeecd1)): ?>
<?php $attributes = $__attributesOriginal6fb9a3a5133c0cbd1e59f8d65daeecd1; ?>
<?php unset($__attributesOriginal6fb9a3a5133c0cbd1e59f8d65daeecd1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6fb9a3a5133c0cbd1e59f8d65daeecd1)): ?>
<?php $component = $__componentOriginal6fb9a3a5133c0cbd1e59f8d65daeecd1; ?>
<?php unset($__componentOriginal6fb9a3a5133c0cbd1e59f8d65daeecd1); ?>
<?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>

                                <button class="slider-controls slider-prev" onclick="slideContent('fitdoc-videos-slider', -1)">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="slider-controls slider-next" onclick="slideContent('fitdoc-videos-slider', 1)">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>

                        </div>
                    <?php endif; ?>

                    <!-- FitDoc Series -->
                    <?php if($fitDocSeries->count() > 0): ?>
                        <div class="category-section mb-1">
                            <h3 class="category-title">Season</h3>
                            <div class="content-slider">
                                <div class="slider-container" id="fitdoc-series-slider">
                                    <?php $__currentLoopData = $fitDocSeries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if (isset($component)) { $__componentOriginal41b15c4f427e6d22976473ee4b2336e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal41b15c4f427e6d22976473ee4b2336e9 = $attributes; } ?>
<?php $component = App\View\Components\Home\PortraitCard::resolve(['video' => $video,'badge' => 'Series','badgeClass' => 'badge-series','url' => 'fitdoc.series.show'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.portrait-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Home\PortraitCard::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal41b15c4f427e6d22976473ee4b2336e9)): ?>
<?php $attributes = $__attributesOriginal41b15c4f427e6d22976473ee4b2336e9; ?>
<?php unset($__attributesOriginal41b15c4f427e6d22976473ee4b2336e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal41b15c4f427e6d22976473ee4b2336e9)): ?>
<?php $component = $__componentOriginal41b15c4f427e6d22976473ee4b2336e9; ?>
<?php unset($__componentOriginal41b15c4f427e6d22976473ee4b2336e9); ?>
<?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </div>
                                <button class="slider-controls slider-prev" onclick="slideContent('fitdoc-series-slider', -1)">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="slider-controls slider-next" onclick="slideContent('fitdoc-series-slider', 1)">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>
                </section>
            <?php endif; ?>

            <!-- FitLive Section -->
            <?php if($fitLiveCategories->count() > 0): ?>
                <section class="content-section mt-4">
                    <a href="<?php echo e(route('fitlive.index')); ?>" class="text-decoration-none">
                        <div class="section-header">
                            <h2 class="section-title">
                                FitLive
                            </h2>
                            <span class="opacity-75 view-all-btn">View All</span>
                        </div>
                    </a>

                    <?php $__currentLoopData = $fitLiveCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $allContent = $category->subCategories->sortBy('sort_order')->values();
                        ?>
                        <?php if($allContent->count() > 0): ?>
                            <div class="category-section mb-1">
                            <?php if($category->id == 21): ?>
                                <?php
                                    $route = route('fitlive.daily-classes.show', 19);
                                ?>
                            <?php else: ?>
                                <?php
                                    $route = route('fitlive.fitexpert');
                                ?>
                            <?php endif; ?>
                            <a href="<?php echo e($route); ?>" class="text-decoration-none">
                                <h3 class="category-title"><?php echo e($category->name); ?></h3>
                            </a>
                                <div class="content-slider">
                                    <div class="slider-container" id="fitlive-<?php echo e($category->id); ?>-slider">

                                        <?php $__currentLoopData = $allContent; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <?php if($category->id == 21): ?>
                                                <?php if (isset($component)) { $__componentOriginal2b707d9f7bf07249f74fec5563c397f4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2b707d9f7bf07249f74fec5563c397f4 = $attributes; } ?>
<?php $component = App\View\Components\Home\LandscapeCard::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.landscape-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Home\LandscapeCard::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('fitlive.daily-classes.show', $subCategory->id)),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($subCategory->name),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($subCategory->banner_image ? asset('storage/app/public/' . $subCategory->banner_image) : null),'badge' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['label' => 'Live', 'class' => 'badge-live']),'meta' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['<i class=\'fas fa-calendar\'></i> ' . ($subCategory->created_at?->format('M d, Y') ?? '')])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2b707d9f7bf07249f74fec5563c397f4)): ?>
<?php $attributes = $__attributesOriginal2b707d9f7bf07249f74fec5563c397f4; ?>
<?php unset($__attributesOriginal2b707d9f7bf07249f74fec5563c397f4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2b707d9f7bf07249f74fec5563c397f4)): ?>
<?php $component = $__componentOriginal2b707d9f7bf07249f74fec5563c397f4; ?>
<?php unset($__componentOriginal2b707d9f7bf07249f74fec5563c397f4); ?>
<?php endif; ?>
                                            <?php else: ?>
                                                <?php $__currentLoopData = $subCategory->fitLiveSessions->sortByDesc('id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        if ($category->id == 21) {
                                                            $route = 'fitlive.daily-classes.show';
                                                        } else {
                                                            $route = 'fitlive.fitexpert';
                                                        }
                                                    ?>

                                                    <?php if (isset($component)) { $__componentOriginal41b15c4f427e6d22976473ee4b2336e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal41b15c4f427e6d22976473ee4b2336e9 = $attributes; } ?>
<?php $component = App\View\Components\Home\PortraitCard::resolve(['video' => $data,'badge' => 'Live','badgeClass' => 'badge-live','url' => $route] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.portrait-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Home\PortraitCard::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal41b15c4f427e6d22976473ee4b2336e9)): ?>
<?php $attributes = $__attributesOriginal41b15c4f427e6d22976473ee4b2336e9; ?>
<?php unset($__attributesOriginal41b15c4f427e6d22976473ee4b2336e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal41b15c4f427e6d22976473ee4b2336e9)): ?>
<?php $component = $__componentOriginal41b15c4f427e6d22976473ee4b2336e9; ?>
<?php unset($__componentOriginal41b15c4f427e6d22976473ee4b2336e9); ?>
<?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>

                                    <button class="slider-controls slider-prev"
                                        onclick="slideContent('fitlive-<?php echo e($category->id); ?>-slider', -1)">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button class="slider-controls slider-next"
                                        onclick="slideContent('fitlive-<?php echo e($category->id); ?>-slider', 1)">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </section>
            <?php endif; ?>

            <!-- FitArena Live Section -->
            <?php if($fitarenaliveEvents->count() > 0 || $fitarenaliveEvents->count() > 0): ?>
                <section class="content-section mt-4">
                    <a href="<?php echo e(route('fitarena.index')); ?>" class="text-decoration-none">
                        <div class="section-header">
                            <h2 class="section-title">
                                FitArena Live
                            </h2>
                            <span class="view-all-btn opacity-75">View All</span>
                        </div>
                    </a>

                    <div class="category-section mb-1">
                        <a href="<?php echo e(route('fitarena.index')); ?>" class="text-decoration-none">
                            <h3 class="category-title">Live Events</h3>
                        </a>
                        <div class="content-slider">
                            <div class="slider-container" id="fitarena-live-slider">
                                <?php
                                    $fitarenaliveEvents = $fitarenaliveEvents->sortBy('created_at')->values();
                                ?>

                                <?php $__currentLoopData = $fitarenaliveEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $badge = match ($event->status) {
                                            'upcoming' => ['label' => 'Upcoming', 'class' => 'badge-upcoming'],
                                            'live' => ['label' => 'Live', 'class' => 'badge-live'],
                                            'ended' => ['label' => 'Ended', 'class' => 'badge-ended'],
                                        };
                                    ?>
                                    <?php if (isset($component)) { $__componentOriginal2b707d9f7bf07249f74fec5563c397f4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2b707d9f7bf07249f74fec5563c397f4 = $attributes; } ?>
<?php $component = App\View\Components\Home\LandscapeCard::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.landscape-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Home\LandscapeCard::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('fitarena.show', $event)),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event->title),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event->banner_image_path ? $event->banner_image_path : null),'badge' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($badge),'meta' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['<i class=\'fas fa-calendar\'></i> ' . ($event->created_at?->format('M d, Y') ?? '')])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2b707d9f7bf07249f74fec5563c397f4)): ?>
<?php $attributes = $__attributesOriginal2b707d9f7bf07249f74fec5563c397f4; ?>
<?php unset($__attributesOriginal2b707d9f7bf07249f74fec5563c397f4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2b707d9f7bf07249f74fec5563c397f4)): ?>
<?php $component = $__componentOriginal2b707d9f7bf07249f74fec5563c397f4; ?>
<?php unset($__componentOriginal2b707d9f7bf07249f74fec5563c397f4); ?>
<?php endif; ?>
                                    
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </div>

                            <button class="slider-controls slider-prev" onclick="slideContent('fitarena-live-slider', -1)">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button class="slider-controls slider-next" onclick="slideContent('fitarena-live-slider', 1)">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <!-- FitGuide Section -->
            <?php if($fitGuideCategories->count() > 0): ?>
                <section class="content-section mt-4">
                    <a href="<?php echo e(route('fitguide.index')); ?>" class="text-decoration-none">
                        <div class="section-header">
                            <h2 class="section-title">
                                
                                FitGuide
                            </h2>
                            <span class="opacity-75 view-all-btn">View All</span>
                        </div>
                    </a>

                    
                    <?php $__currentLoopData = $fitGuideCategories->sortBy('sort_order')->values(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $allContent = $category->singles->merge($category->series);
                        ?>
                        <?php if($allContent->count() > 0): ?>
                            <div class="category-section mb-1">
                                <?php
                                    $isFitcastLive = $category->slug === 'fitcast-live';
                                ?>
                                <?php if($isFitcastLive): ?>
                                    <a href="<?php echo e(route('fitguide.index', ['category' => $category->slug])); ?>" class="text-decoration-none">
                                        <div class="section-header">
                                            <h2 class="section-title">
                                                
                                                FitCasts
                                            </h2>
                                            <span class="opacity-75 view-all-btn">View All</span>
                                        </div>
                                    </a>
                                <?php else: ?>
                                    <a href="<?php echo e(route('fitguide.index', ['category' => $category->slug])); ?>" class="text-decoration-none">
                                        <h3 class="category-title"><?php echo e($category->name); ?></h3>
                                    </a>
                                <?php endif; ?>
                                <div class="content-slider">
                                    <div class="slider-container" id="fitguide-<?php echo e($category->id); ?>-slider">
                                        <?php $__currentLoopData = $allContent->sortByDesc('id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <?php if($isFitcastLive): ?>
                                                <?php if (isset($component)) { $__componentOriginal2b707d9f7bf07249f74fec5563c397f4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2b707d9f7bf07249f74fec5563c397f4 = $attributes; } ?>
<?php $component = App\View\Components\Home\LandscapeCard::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.landscape-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Home\LandscapeCard::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('fitguide.index', ['category' => $category->slug])),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($content->title),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($content->banner_image_path ? asset('storage/app/public/' . $content->banner_image_path) : null),'meta' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['<i class=\'fas fa-calendar\'></i> ' . ($content->created_at?->format('M d, Y') ?? '')])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2b707d9f7bf07249f74fec5563c397f4)): ?>
<?php $attributes = $__attributesOriginal2b707d9f7bf07249f74fec5563c397f4; ?>
<?php unset($__attributesOriginal2b707d9f7bf07249f74fec5563c397f4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2b707d9f7bf07249f74fec5563c397f4)): ?>
<?php $component = $__componentOriginal2b707d9f7bf07249f74fec5563c397f4; ?>
<?php unset($__componentOriginal2b707d9f7bf07249f74fec5563c397f4); ?>
<?php endif; ?>
                                            <?php else: ?>
                                                <?php if (isset($component)) { $__componentOriginal41b15c4f427e6d22976473ee4b2336e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal41b15c4f427e6d22976473ee4b2336e9 = $attributes; } ?>
<?php $component = App\View\Components\Home\PortraitCard::resolve(['video' => $content,'url' => 'fitguide.index'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.portrait-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Home\PortraitCard::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['categorySlug' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($category->slug)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal41b15c4f427e6d22976473ee4b2336e9)): ?>
<?php $attributes = $__attributesOriginal41b15c4f427e6d22976473ee4b2336e9; ?>
<?php unset($__attributesOriginal41b15c4f427e6d22976473ee4b2336e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal41b15c4f427e6d22976473ee4b2336e9)): ?>
<?php $component = $__componentOriginal41b15c4f427e6d22976473ee4b2336e9; ?>
<?php unset($__componentOriginal41b15c4f427e6d22976473ee4b2336e9); ?>
<?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <button class="slider-controls slider-prev"
                                        onclick="slideContent('fitguide-<?php echo e($category->id); ?>-slider', -1)">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button class="slider-controls slider-next"
                                        onclick="slideContent('fitguide-<?php echo e($category->id); ?>-slider', 1)">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>

                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </section>
            <?php endif; ?>

            <!-- FitNews Section -->

            
            <?php if(count($fitNewsLive ?? []) > 0 || count($fitNewsArchive ?? []) > 0): ?>

                <section class="content-section mt-4">
                    <a href="<?php echo e(route('fitnews.index')); ?>" class="text-decoration-none">
                        <div class="section-header">
                            <h2 class="section-title">
                                
                                FitNews
                            </h2>
                            <span class="opacity-75 view-all-btn">View All</span>
                        </div>
                    </a>

                    <div class="content-slider">
                        <div class="slider-container" id="fitnews-slider">
                            <?php $__currentLoopData = $fitNewsLive; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if (isset($component)) { $__componentOriginal2b707d9f7bf07249f74fec5563c397f4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2b707d9f7bf07249f74fec5563c397f4 = $attributes; } ?>
<?php $component = App\View\Components\Home\LandscapeCard::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.landscape-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Home\LandscapeCard::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('fitnews.show', $news)),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($news->title),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($news->thumbnail ? asset('storage/app/public/' . $news->thumbnail) : null),'badge' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['label' => 'LIVE', 'class' => 'badge-live']),'meta' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                                    '<i class=\'fas fa-user\'></i> ' . ($news->creator->name ?? 'Admin'),
                                    '<i class=\'fas fa-eye\'></i> ' . ($news->viewer_count ?? 0) . ' watching'
                                ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2b707d9f7bf07249f74fec5563c397f4)): ?>
<?php $attributes = $__attributesOriginal2b707d9f7bf07249f74fec5563c397f4; ?>
<?php unset($__attributesOriginal2b707d9f7bf07249f74fec5563c397f4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2b707d9f7bf07249f74fec5563c397f4)): ?>
<?php $component = $__componentOriginal2b707d9f7bf07249f74fec5563c397f4; ?>
<?php unset($__componentOriginal2b707d9f7bf07249f74fec5563c397f4); ?>
<?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php
                                $today = \Carbon\Carbon::today(); // Aaj ki date
                                $currentTime = \Carbon\Carbon::now(); // Abhi ka time
                            ?>

                            <?php $__currentLoopData = $fitNewsArchive; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(\Carbon\Carbon::parse($news->scheduled_at)->isToday()): ?>
                                        <!-- Check if scheduled_at is today -->
                                        <?php
                                            // Compare current time with scheduled_at
                                            $scheduledTime = \Carbon\Carbon::parse($news->scheduled_at);

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

                                        <?php if (isset($component)) { $__componentOriginal2b707d9f7bf07249f74fec5563c397f4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2b707d9f7bf07249f74fec5563c397f4 = $attributes; } ?>
<?php $component = App\View\Components\Home\LandscapeCard::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.landscape-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Home\LandscapeCard::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('fitnews.show', $news)),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($news->title),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($news->thumbnail ? asset('storage/app/public/' . $news->thumbnail) : null),'badge' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['label' => $statusLabel, 'class' => $badgeClass]),'meta' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                                        '<i class=\'fas fa-user\'></i> ' . ($news->creator->name ?? 'Admin'),
                                        '<i class=\'fas fa-calendar\'></i> ' . ($news->scheduled_at ? $news->scheduled_at->format('M d, h:i A') : 'TBD')
                                    ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2b707d9f7bf07249f74fec5563c397f4)): ?>
<?php $attributes = $__attributesOriginal2b707d9f7bf07249f74fec5563c397f4; ?>
<?php unset($__attributesOriginal2b707d9f7bf07249f74fec5563c397f4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2b707d9f7bf07249f74fec5563c397f4)): ?>
<?php $component = $__componentOriginal2b707d9f7bf07249f74fec5563c397f4; ?>
<?php unset($__componentOriginal2b707d9f7bf07249f74fec5563c397f4); ?>
<?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                        </div>
                        <button class="slider-controls slider-prev" onclick="slideContent('fitnews-slider', -1)">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="slider-controls slider-next" onclick="slideContent('fitnews-slider', 1)">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </section>
            <?php endif; ?>

            <!-- FitInsights Section -->
            <?php if($fitInsights->count() > 0): ?>
                <section class="content-section mt-4 mb-3">
                    <a href="<?php echo e(route('fitinsight.index')); ?>" class="text-decoration-none">
                        <div class="section-header">
                            <h2 class="section-title">
                                FitInsights
                            </h2>
                            <span class="opacity-75 view-all-btn">View All</span>
                        </div>
                    </a>

                    <div class="content-slider">
                        <div class="slider-container" id="fitinsights-slider">
                            <?php $__currentLoopData = $fitInsights->sortBy('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $insight): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if (isset($component)) { $__componentOriginal41b15c4f427e6d22976473ee4b2336e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal41b15c4f427e6d22976473ee4b2336e9 = $attributes; } ?>
<?php $component = App\View\Components\Home\PortraitCard::resolve(['video' => $insight,'url' => 'fitinsight.show'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.portrait-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Home\PortraitCard::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal41b15c4f427e6d22976473ee4b2336e9)): ?>
<?php $attributes = $__attributesOriginal41b15c4f427e6d22976473ee4b2336e9; ?>
<?php unset($__attributesOriginal41b15c4f427e6d22976473ee4b2336e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal41b15c4f427e6d22976473ee4b2336e9)): ?>
<?php $component = $__componentOriginal41b15c4f427e6d22976473ee4b2336e9; ?>
<?php unset($__componentOriginal41b15c4f427e6d22976473ee4b2336e9); ?>
<?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <button class="slider-controls slider-prev" onclick="slideContent('fitinsights-slider', -1)">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="slider-controls slider-next" onclick="slideContent('fitinsights-slider', 1)">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>

                </section>
            <?php endif; ?>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
    <script src="https://www.youtube.com/iframe_api"></script>
    <script src="<?php echo e(asset('assets/home/js/homepage.js')); ?>?v=<?php echo e(time()); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fittley\resources\views/homepage.blade.php ENDPATH**/ ?>