<?php $__env->startSection('title', 'Feature Unavailable'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="card shadow p-4 text-center" style="max-width: 500px; width: 100%;">
            <h2 class="mb-3 text-danger">Feature Unavailable on Web</h2>
            <p class="mb-4">
                This feature isn’t accessible in the web version. <br>
                Download our app to unlock exclusive tools and enjoy the full experience!
            </p>

            <div class="d-flex justify-content-center flex-wrap gap-2 mb-4">
                <a href="#" class="btn btn-primary" style="min-width: 150px;" disabled>
                    Download on App Store
                </a>
                <a href="#" class="btn btn-primary" style="min-width: 150px;" disabled>
                    Download on Google Play
                </a>
            </div>

            <div class="text-center">
                <p class="mb-2">Or scan the QR code to get the app instantly.</p>
                <?php
                    $appUrl = url('/');
                    $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=' . urlencode($appUrl);
                ?>

                <img src="<?php echo e($qrUrl); ?>" alt="QR Code" class="img-fluid" style="max-width: 180px;">

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Digi_Laravel_Prrojects\Fittelly_github\fittley\resources\views/errors/only-in-app.blade.php ENDPATH**/ ?>