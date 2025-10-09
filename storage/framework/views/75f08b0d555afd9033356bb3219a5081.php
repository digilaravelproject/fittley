<?php $__env->startSection('title', 'FitInsight - Fitness Blog'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    :root {
        --fittelly-orange: #f7a31a;
        --fittelly-orange-hover: #e8941a;
        --netflix-black: #000;
        --netflix-dark-gray: #141414;
        --netflix-gray: #2f2f2f;
        --netflix-light-gray: #8c8c8c;
        --netflix-white: #ffffff;
    }

    body {
        background-color: var(--netflix-black);
        color: var(--netflix-white);
    }

    /* Hero Section */
    .hero-section {
        height: 50vh;
        background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.8)), 
                    url('https://images.unsplash.com/photo-1571019613914-85f342c75c29?ixlib=rb-4.0.3') center/cover;
        display: flex;
        align-items: center;
    }
    .hero-content h1 {
        font-size: 4rem;
        font-weight: 800;
        margin-bottom: 1rem;
        background: linear-gradient(45deg, var(--fittelly-orange), var(--netflix-white));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .hero-content p {
        font-size: 1.2rem;
        color: var(--netflix-light-gray);
        max-width: 600px;
    }
    .hero-content form input {
        background: var(--netflix-gray);
        border: none;
        color: var(--netflix-white);
    }
    .hero-content form button {
        background: var(--fittelly-orange);
        color: #000;
        border: none;
    }

    /* Category Buttons */
    .categories-section {
        padding: 2rem 0;
        background: var(--netflix-dark-gray);
        border-top: 1px solid #333;
        border-bottom: 1px solid #333;
    }
    .categories-section a.btn {
        background: var(--netflix-gray);
        color: var(--netflix-white);
        border-radius: 25px;
        padding: 0.5rem 1rem;
        font-weight: 500;
    }
    .categories-section a.btn.btn-primary {
        background: var(--fittelly-orange);
        color: #000;
    }

    /* Article Cards */
    .content-section {
        padding: 4rem 0;
    }
    .content-card {
        background: var(--netflix-dark-gray);
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        height: 400px;
        margin-bottom: 2rem;
    }
    .content-card:hover {
        transform: scale(1.05);
        z-index: 10;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.8);
    }
    .card-image {
        width: 100%;
        height: 220px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .content-card:hover .card-image {
        transform: scale(1.1);
    }
    .card-content {
        padding: 1.5rem;
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(20, 20, 20, 0.95));
    }
    .card-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--netflix-white);
        margin-bottom: 0.5rem;
    }
    .card-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        color: var(--netflix-light-gray);
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }
    .card-description {
        color: var(--netflix-light-gray);
        font-size: 0.85rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .type-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: var(--fittelly-orange);
        color: var(--netflix-black);
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    /* Sidebar */
    .sidebar-card {
        background: var(--netflix-dark-gray);
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 2rem;
    }
    .sidebar-card .card-header {
        background: var(--fittelly-orange);
        color: #000;
        font-weight: 600;
    }
    .sidebar-card .text-muted {
        color: var(--netflix-light-gray) !important;
    }

    /* Newsletter */
    .newsletter-card {
        background: var(--fittelly-orange);
        color: #000;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
    }
    .newsletter-card input {
        border: none;
        border-radius: 25px;
        padding: 0.5rem 1rem;
    }
    .newsletter-card button {
        border: none;
        border-radius: 25px;
        padding: 0.5rem 1rem;
        background: #000;
        color: var(--fittelly-orange);
        width: 100%;
    }

    /* Pagination */
    .pagination {
        --bs-pagination-bg: var(--netflix-dark-gray);
        --bs-pagination-border-color: #333;
        --bs-pagination-color: var(--netflix-white);
        --bs-pagination-hover-bg: #333;
        --bs-pagination-hover-color: #fff;
        --bs-pagination-active-bg: var(--fittelly-orange);
        --bs-pagination-active-border-color: var(--fittelly-orange);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1><i class="fas fa-dumbbell me-3"></i>FitInsight</h1>
            <p>Discover expert fitness tips, nutrition guides, and wellness insights to transform your health journey.</p>
            <form method="GET" class="d-flex mt-4">
                <input type="text" name="search" class="form-control form-control-lg me-2"
                       placeholder="Search articles..." value="<?php echo e(request('search')); ?>">
                <button type="submit" class="btn btn-lg">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Categories -->
<?php if($categories->count() > 0): ?>
<section class="categories-section">
    <div class="container">
        <div class="d-flex flex-wrap gap-2">
            <a href="<?php echo e(route('fitinsight.index')); ?>" 
               class="btn <?php echo e(!request('category') ? 'btn-primary' : ''); ?>">
                All Articles
            </a>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('fitinsight.category', $category)); ?>" 
                   class="btn <?php echo e(request('category') == $category->id ? 'btn-primary' : ''); ?>">
                    <?php if($category->icon): ?>
                        <i class="<?php echo e($category->icon); ?> me-1"></i>
                    <?php endif; ?>
                    <?php echo e($category->name); ?>

                    <span class="badge bg-light text-dark ms-1"><?php echo e($category->published_blogs_count); ?></span>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Main Content -->
<section class="content-section">
    <div class="container">
        <div class="row">
            <!-- Articles -->
            <div class="col-lg-8">
                <?php if(request('search')): ?>
                    <div class="mb-4">
                        <h4>Search Results for "<?php echo e(request('search')); ?>"</h4>
                        <p class="text-muted"><?php echo e($blogs->total()); ?> articles found</p>
                    </div>
                <?php endif; ?>

                <?php if($blogs->count() > 0): ?>
                    <div class="row">
                        <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-lg-6 mb-4">
                                <div class="content-card" onclick="window.location.href='<?php echo e(route('fitinsight.show', $blog)); ?>'">
                                    <?php if($blog->featured_image_path): ?>
                                        <img src="<?php echo e($blog->featured_image_url); ?>" class="card-image" 
                                             alt="<?php echo e($blog->featured_image_alt ?: $blog->title); ?>">
                                    <?php else: ?>
                                        <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3" class="card-image" 
                                             alt="<?php echo e($blog->title); ?>">
                                    <?php endif; ?>
                                    <div class="type-badge"><?php echo e($blog->category->name); ?></div>
                                    <div class="card-content">
                                        <h3 class="card-title"><?php echo e($blog->title); ?></h3>
                                        <div class="card-meta">
                                            <span><i class="fas fa-eye"></i> <?php echo e(number_format($blog->views_count)); ?></span>
                                            <span><i class="fas fa-heart"></i> <?php echo e(number_format($blog->likes_count)); ?></span>
                                            <span><i class="fas fa-share"></i> <?php echo e(number_format($blog->shares_count)); ?></span>
                                        </div>
                                        <p class="card-description"><?php echo e($blog->excerpt_or_content); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        <?php echo e($blogs->links()); ?>

                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No articles found</h4>
                        <p class="text-muted">
                            <?php if(request('search')): ?>
                                Try adjusting your search terms or browse our categories.
                            <?php else: ?>
                                Check back soon for new fitness insights and tips.
                            <?php endif; ?>
                        </p>
                        <?php if(request('search')): ?>
                            <a href="<?php echo e(route('fitinsight.index')); ?>" class="btn btn-primary">
                                View All Articles
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <?php if($featuredBlogs->count() > 0): ?>
                <div class="sidebar-card mb-4">
                    <div class="card-header">
                        <i class="fas fa-star me-2"></i>Featured Articles
                    </div>
                    <div class="card-body">
                        <?php $__currentLoopData = $featuredBlogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $featured): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="d-flex mb-3 <?php echo e(!$loop->last ? 'border-bottom pb-3' : ''); ?>">
                                <?php if($featured->featured_image_path): ?>
                                    <img src="<?php echo e($featured->featured_image_url); ?>" alt="<?php echo e($featured->title); ?>" 
                                         class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                <?php else: ?>
                                    <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3" alt="<?php echo e($featured->title); ?>" 
                                         class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                <?php endif; ?>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">
                                        <a href="<?php echo e(route('fitinsight.show', $featured)); ?>" class="text-white text-decoration-none">
                                            <?php echo e(Str::limit($featured->title, 50)); ?>

                                        </a>
                                    </h6>
                                    <small class="text-muted"><?php echo e($featured->published_at_formatted); ?></small>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if($trendingBlogs->count() > 0): ?>
                <div class="sidebar-card mb-4">
                    <div class="card-header">
                        <i class="fas fa-fire me-2"></i>Trending Now
                    </div>
                    <div class="card-body">
                        <?php $__currentLoopData = $trendingBlogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trending): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="d-flex mb-3 <?php echo e(!$loop->last ? 'border-bottom pb-3' : ''); ?>">
                                <?php if($trending->featured_image_path): ?>
                                    <img src="<?php echo e($trending->featured_image_url); ?>" alt="<?php echo e($trending->title); ?>" 
                                         class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                <?php else: ?>
                                    <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3" alt="<?php echo e($trending->title); ?>" 
                                         class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                <?php endif; ?>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">
                                        <a href="<?php echo e(route('fitinsight.show', $trending)); ?>" class="text-white text-decoration-none">
                                            <?php echo e(Str::limit($trending->title, 50)); ?>

                                        </a>
                                    </h6>
                                    <div class="d-flex justify-content-between">
                                        <small class="text-muted"><?php echo e($trending->published_at_formatted); ?></small>
                                        <small class="text-muted">
                                            <i class="fas fa-eye me-1"></i><?php echo e(number_format($trending->views_count)); ?>

                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>

                <div class="newsletter-card">
                    <i class="fas fa-envelope fa-2x mb-3"></i>
                    <h6 class="mb-3">Stay Updated</h6>
                    <p class="mb-3">Get the latest fitness insights delivered to your inbox.</p>
                    <form>
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Your email address">
                        </div>
                        <button type="submit" class="btn">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/purple-gaur-534336.hostingersite.com/public_html/resources/views/public/fitinsight/index.blade.php ENDPATH**/ ?>