<?php $__env->startSection('title', 'FitInsight - Fitness Blog'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/home/css/fitinsight.css')); ?>?v=<?php echo e(time()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="fitinsight-page">

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>FitInsight</h1>
            <p>Get the latest articles on health, fitness, nutrition, workouts, and wellness.</p>
            <div class="hero-search">
                <input type="text" id="search-input" placeholder="Search articles..." value="<?php echo e(request('search')); ?>">
                <i class="fas fa-search search-icon"></i>
            </div>
        </div>
    </section>

    <!-- Categories -->
    <?php if($categories->count() > 0): ?>
    <section class="categories-section">
        <div class="categories-wrapper">
            <a href="<?php echo e(route('fitinsight.index')); ?>" class="cat-btn <?php echo e(!request('category') ? 'active' : ''); ?>">All</a>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('fitinsight.category', $category)); ?>"
                class="cat-btn <?php echo e(request('category') == $category->id ? 'active' : ''); ?>">
                <?php if($category->icon): ?> <i class="<?php echo e($category->icon); ?> me-1"></i> <?php endif; ?>
                <?php echo e($category->name); ?>

            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- Main Content -->
    <section class="content-section">
        <div class="container">
            <div class="row">
                <!-- Articles Column -->
                <div class="col-lg-8 col-md-12" id="articles-wrapper">
                    <?php if($blogs->count() > 0): ?>
                    <div class="row">
                        <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6 mb-4">
                            <div class="content-card" onclick="window.location='<?php echo e(route('fitinsight.show', $blog)); ?>'">
                                <img src="<?php echo e($blog->featured_image_url ?? 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b'); ?>"
                                    alt="<?php echo e($blog->title); ?>" class="card-image">
                                <div class="type-badge"><?php echo e($blog->category->name); ?></div>
                                <div class="card-content">
                                    <h3 class="card-title"><?php echo e($blog->title); ?></h3>
                                    <div class="card-meta">
                                        <span><i class="fas fa-eye"></i> <?php echo e(number_format($blog->views_count)); ?></span>
                                        <span><i class="fas fa-heart"></i> <?php echo e(number_format($blog->likes_count)); ?></span>
                                    </div>
                                    <p class="card-description"><?php echo e($blog->excerpt_or_content); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="pagination-wrapper mt-4">
                        <?php echo e($blogs->links()); ?>

                    </div>
                    <?php else: ?>
                    <div class="no-articles">
                        <h4>No articles found</h4>
                        <p>Try searching with different keywords or check back later.</p>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Sidebar Column -->
                <div class="col-lg-4 col-md-12">
                    <?php if($featuredBlogs->count() > 0): ?>
                    <div class="sidebar-card">
                        <div class="card-header">Featured Articles</div>
                        <div class="card-body">
                            <?php $__currentLoopData = $featuredBlogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="sidebar-item">
                                <img src="<?php echo e($feat->featured_image_url); ?>" alt="<?php echo e($feat->title); ?>"
                                    class="sidebar-thumb">
                                <div>
                                    <a href="<?php echo e(route('fitinsight.show', $feat)); ?>"><?php echo e(Str::limit($feat->title, 50)); ?></a>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if($trendingBlogs->count() > 0): ?>
                    <div class="sidebar-card">
                        <div class="card-header">Trending Now</div>
                        <div class="card-body">
                            <?php $__currentLoopData = $trendingBlogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="sidebar-item">
                                <img src="<?php echo e($trend->featured_image_url); ?>" alt="<?php echo e($trend->title); ?>"
                                    class="sidebar-thumb">
                                <div>
                                    <a href="<?php echo e(route('fitinsight.show', $trend)); ?>"><?php echo e(Str::limit($trend->title, 50)); ?></a>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="newsletter-card">
                        <h5>Subscribe</h5>
                        <p>Stay updated with new articles delivered to your inbox.</p>
                        <form id="newsletter-form">
                            <input type="email" placeholder="Your email address" required>
                            <button type="submit">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');

        searchInput.addEventListener('input', function(e) {
            const q = e.target.value.trim();
            // If you want debounce so not every keystroke triggers heavy load
            clearTimeout(this._timeout);
            this._timeout = setTimeout(() => {
                const url = new URL(window.location.href);
                if (q) url.searchParams.set('search', q);
                else url.searchParams.delete('search');
                // optionally also reset page number
                url.searchParams.delete('page');
                window.history.replaceState({}, '', url.toString());
                // fetch via AJAX
                fetch(url.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.text())
                .then(html => {
                    // parse returned HTML and replace articles part
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newArticles = doc.getElementById('articles-wrapper');
                    if (newArticles) {
                        document.getElementById('articles-wrapper').innerHTML = newArticles.innerHTML;
                    }
                })
                .catch(err => console.error(err));
            }, 500); // wait 500ms after user stops typing
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Digi_Laravel_Prrojects\Fittelly_github\fittley\resources\views/public/fitinsight/index.blade.php ENDPATH**/ ?>