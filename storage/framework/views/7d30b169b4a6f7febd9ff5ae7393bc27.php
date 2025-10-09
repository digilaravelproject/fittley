<?php $__env->startSection('title', 'Session Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Session Header -->
    <div class="row">
        <div class="col-12">
            <div class="card bg-dark border-secondary">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title text-white mb-0">
                        <i class="fas fa-video me-2"></i><?php echo e($session->title); ?>

                        <?php if($session->status == 'live'): ?>
                            <span class="badge bg-danger ms-2 blink">LIVE</span>
                        <?php endif; ?>
                    </h3>
                    <div class="btn-group">
                        <?php if($session->status == 'scheduled'): ?>
                            <form action="<?php echo e(route('admin.fitlive.sessions.start', $session)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-success" onclick="return confirm('Start this live session?')">
                                    <i class="fas fa-play me-1"></i>Start Live
                                </button>
                            </form>
                        <?php elseif($session->status == 'live'): ?>
                            <form action="<?php echo e(route('admin.fitlive.sessions.end', $session)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-danger" onclick="return confirm('End this live session?')">
                                    <i class="fas fa-stop me-1"></i>End Live
                                </button>
                            </form>
                        <?php endif; ?>
                        <a href="<?php echo e(route('admin.fitlive.sessions.edit', $session)); ?>" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <a href="<?php echo e(route('admin.fitlive.sessions.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Session Details -->
                        <div class="col-md-6">
                            <table class="table table-dark table-borderless">
                                <tr>
                                    <th width="30%">ID:</th>
                                    <td><?php echo e($session->id); ?></td>
                                </tr>
                                <tr>
                                    <th>Title:</th>
                                    <td><?php echo e($session->title); ?></td>
                                </tr>
                                <tr>
                                    <th>Description:</th>
                                    <td><?php echo e($session->description ?: 'No description provided'); ?></td>
                                </tr>
                                <tr>
                                    <th>Category:</th>
                                    <td>
                                        <a href="<?php echo e(route('admin.fitlive.categories.show', $session->category)); ?>" 
                                           class="text-info text-decoration-none">
                                            <?php echo e($session->category->name); ?>

                                        </a>
                                        <?php if($session->subCategory): ?>
                                            <br><small class="text-muted"><?php echo e($session->subCategory->name); ?></small>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Instructor:</th>
                                    <td><?php echo e($session->instructor->name); ?></td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <?php switch($session->status):
                                            case ('scheduled'): ?>
                                                <span class="badge bg-warning fs-6">Scheduled</span>
                                                <?php break; ?>
                                            <?php case ('live'): ?>
                                                <span class="badge bg-success fs-6">Live</span>
                                                <?php break; ?>
                                            <?php case ('ended'): ?>
                                                <span class="badge bg-secondary fs-6">Ended</span>
                                                <?php break; ?>
                                        <?php endswitch; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Scheduled:</th>
                                    <td>
                                        <?php if($session->scheduled_at): ?>
                                            <?php echo e($session->scheduled_at->format('F d, Y \a\t g:i A')); ?>

                                        <?php else: ?>
                                            <span class="text-muted">Not scheduled</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Chat Mode:</th>
                                    <td>
                                        <?php switch($session->chat_mode):
                                            case ('during'): ?>
                                                <span class="badge bg-success">During Live</span>
                                                <?php break; ?>
                                            <?php case ('after'): ?>
                                                <span class="badge bg-warning">After Live</span>
                                                <?php break; ?>
                                            <?php case ('off'): ?>
                                                <span class="badge bg-danger">Disabled</span>
                                                <?php break; ?>
                                        <?php endswitch; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Session Type:</th>
                                    <td>
                                        <?php switch($session->session_type):
                                            case ('daily'): ?>
                                                <span class="badge bg-success">Daily</span>
                                                <?php break; ?>
                                            <?php case ('one_time'): ?>
                                                <span class="badge bg-success">One Time</span>
                                                <?php break; ?>
                                        <?php endswitch; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Visibility:</th>
                                    <td>
                                        <?php if($session->visibility == 'public'): ?>
                                            <span class="badge bg-success">Public</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">Private</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- Session Stats & Media -->
                        <div class="col-md-6">
                            <div class="row text-center mb-4">
                                <div class="col-4">
                                    <div class="card bg-secondary border-info">
                                        <div class="card-body">
                                            <h3 class="text-info"><?php echo e($session->viewer_peak ?? 0); ?></h3>
                                            <p class="mb-0">Peak Viewers</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card bg-secondary border-success">
                                        <div class="card-body">
                                            <h3 class="text-success"><?php echo e($session->chatMessages->count()); ?></h3>
                                            <p class="mb-0">Chat Messages</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card bg-secondary border-warning">
                                        <div class="card-body">
                                            <h3 class="text-warning">
                                                <?php if($session->scheduled_at && $session->status == 'ended'): ?>
                                                    <?php echo e($session->updated_at->diffInMinutes($session->scheduled_at)); ?>m
                                                <?php else: ?>
                                                    --
                                                <?php endif; ?>
                                            </h3>
                                            <p class="mb-0">Duration</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php if($session->banner_image): ?>
                                <div class="mb-3">
                                    <label class="form-label text-white">Banner Image:</label>
                                    <div>
                                        <img src="<?php echo e(Storage::url($session->banner_image)); ?>" 
                                             alt="Session banner" 
                                             class="img-fluid rounded border">
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Technical Details -->
                            <div class="mb-3">
                                <label class="form-label text-white">Technical Details:</label>
                                <table class="table table-dark table-sm">
                                    <tr>
                                        <th>LiveKit Room:</th>
                                        <td><code class="text-info"><?php echo e($session->livekit_room ?: 'Not assigned'); ?></code></td>
                                    </tr>
                                    <tr>
                                        <th>HLS URL:</th>
                                        <td>
                                            <?php if($session->hls_url): ?>
                                                <code class="text-success"><?php echo e($session->hls_url); ?></code>
                                            <?php else: ?>
                                                <span class="text-muted">Not available</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Recording:</th>
                                        <td>
                                            <?php if($session->mp4_path): ?>
                                                <code class="text-success"><?php echo e($session->mp4_path); ?></code>
                                            <?php else: ?>
                                                <span class="text-muted">Not recorded</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Live Stream Preview -->
    <?php if($session->status == 'live' && $session->hls_url): ?>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card bg-dark border-secondary">
                <div class="card-header">
                    <h4 class="card-title text-white mb-0">
                        <i class="fas fa-play-circle me-2"></i>Live Stream Preview
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <video id="livePlayer"
                                   class="video-player"
                                   controls
                                   preload="metadata"
                                   controlslist="nodownload noremoteplayback"
                                   disablepictureinpicture
                                   oncontextmenu="return false;">
                                <source src="<?php echo e(asset('storage/app/public/recordings/' . $session->recording_filename)); ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-secondary">
                                <div class="card-header">
                                    <h6 class="text-white mb-0">Stream Info</h6>
                                </div>
                                <div class="card-body">
                                    <p><strong>Status:</strong> <span class="text-success">Live</span></p>
                                    <p><strong>HLS URL:</strong><br>
                                       <small><code><?php echo e($session->hls_url); ?></code></small>
                                    </p>
                                    <p><strong>Room:</strong><br>
                                       <small><code><?php echo e($session->livekit_room); ?></code></small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Recent Chat Messages -->
    <?php if($session->chatMessages->count() > 0): ?>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card bg-dark border-secondary">
                <div class="card-header">
                    <h4 class="card-title text-white mb-0">
                        <i class="fas fa-comments me-2"></i>Recent Chat Messages
                    </h4>
                </div>
                <div class="card-body">
                    <div class="chat-messages" style="max-height: 300px; overflow-y: auto;">
                        <?php $__currentLoopData = $session->chatMessages->take(50); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="d-flex mb-2">
                                <div class="flex-shrink-0">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 32px; height: 32px;">
                                        <small class="text-white fw-bold">
                                            <?php echo e(substr($message->user->name, 0, 1)); ?>

                                        </small>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <div class="d-flex align-items-center">
                                        <strong class="text-white me-2"><?php echo e($message->user->name); ?></strong>
                                        <small class="text-muted"><?php echo e($message->sent_at->format('g:i A')); ?></small>
                                    </div>
                                    <div class="text-light"><?php echo e($message->body); ?></div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
.blink {
    animation: blink-animation 1s steps(5, start) infinite;
}

@keyframes blink-animation {
    to {
        visibility: hidden;
    }
}
</style>

<?php if($session->status == 'live' && $session->hls_url): ?>
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const video = document.getElementById('livePlayer');
    const hlsUrl = '<?php echo e($session->hls_url); ?>';
    
    if (Hls.isSupported()) {
        const hls = new Hls();
        hls.loadSource(hlsUrl);
        hls.attachMedia(video);
        hls.on(Hls.Events.MANIFEST_PARSED, function() {
            console.log('HLS manifest loaded, starting playback');
        });
    } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
        video.src = hlsUrl;
    } else {
        console.error('HLS is not supported in this browser');
    }
});
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fittley\resources\views/admin/fitlive/sessions/show.blade.php ENDPATH**/ ?>