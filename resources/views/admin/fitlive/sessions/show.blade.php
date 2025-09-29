@extends('layouts.admin')

@section('title', 'Session Details')

@section('content')
<div class="container-fluid">
    <!-- Session Header -->
    <div class="row">
        <div class="col-12">
            <div class="card bg-dark border-secondary">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title text-white mb-0">
                        <i class="fas fa-video me-2"></i>{{ $session->title }}
                        @if($session->status == 'live')
                            <span class="badge bg-danger ms-2 blink">LIVE</span>
                        @endif
                    </h3>
                    <div class="btn-group">
                        @if($session->status == 'scheduled')
                            <form action="{{ route('admin.fitlive.sessions.start', $session) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success" onclick="return confirm('Start this live session?')">
                                    <i class="fas fa-play me-1"></i>Start Live
                                </button>
                            </form>
                        @elseif($session->status == 'live')
                            <form action="{{ route('admin.fitlive.sessions.end', $session) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger" onclick="return confirm('End this live session?')">
                                    <i class="fas fa-stop me-1"></i>End Live
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('admin.fitlive.sessions.edit', $session) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <a href="{{ route('admin.fitlive.sessions.index') }}" class="btn btn-secondary">
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
                                    <td>{{ $session->id }}</td>
                                </tr>
                                <tr>
                                    <th>Title:</th>
                                    <td>{{ $session->title }}</td>
                                </tr>
                                <tr>
                                    <th>Description:</th>
                                    <td>{{ $session->description ?: 'No description provided' }}</td>
                                </tr>
                                <tr>
                                    <th>Category:</th>
                                    <td>
                                        <a href="{{ route('admin.fitlive.categories.show', $session->category) }}" 
                                           class="text-info text-decoration-none">
                                            {{ $session->category->name }}
                                        </a>
                                        @if($session->subCategory)
                                            <br><small class="text-muted">{{ $session->subCategory->name }}</small>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Instructor:</th>
                                    <td>{{ $session->instructor->name }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        @switch($session->status)
                                            @case('scheduled')
                                                <span class="badge bg-warning fs-6">Scheduled</span>
                                                @break
                                            @case('live')
                                                <span class="badge bg-success fs-6">Live</span>
                                                @break
                                            @case('ended')
                                                <span class="badge bg-secondary fs-6">Ended</span>
                                                @break
                                        @endswitch
                                    </td>
                                </tr>
                                <tr>
                                    <th>Scheduled:</th>
                                    <td>
                                        @if($session->scheduled_at)
                                            {{ $session->scheduled_at->format('F d, Y \a\t g:i A') }}
                                        @else
                                            <span class="text-muted">Not scheduled</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Chat Mode:</th>
                                    <td>
                                        @switch($session->chat_mode)
                                            @case('during')
                                                <span class="badge bg-success">During Live</span>
                                                @break
                                            @case('after')
                                                <span class="badge bg-warning">After Live</span>
                                                @break
                                            @case('off')
                                                <span class="badge bg-danger">Disabled</span>
                                                @break
                                        @endswitch
                                    </td>
                                </tr>
                                <tr>
                                    <th>Session Type:</th>
                                    <td>
                                        @switch($session->session_type)
                                            @case('daily')
                                                <span class="badge bg-success">Daily</span>
                                                @break
                                            @case('one_time')
                                                <span class="badge bg-success">One Time</span>
                                                @break
                                        @endswitch
                                    </td>
                                </tr>
                                <tr>
                                    <th>Visibility:</th>
                                    <td>
                                        @if($session->visibility == 'public')
                                            <span class="badge bg-success">Public</span>
                                        @else
                                            <span class="badge bg-warning">Private</span>
                                        @endif
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
                                            <h3 class="text-info">{{ $session->viewer_peak ?? 0 }}</h3>
                                            <p class="mb-0">Peak Viewers</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card bg-secondary border-success">
                                        <div class="card-body">
                                            <h3 class="text-success">{{ $session->chatMessages->count() }}</h3>
                                            <p class="mb-0">Chat Messages</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card bg-secondary border-warning">
                                        <div class="card-body">
                                            <h3 class="text-warning">
                                                @if($session->scheduled_at && $session->status == 'ended')
                                                    {{ $session->updated_at->diffInMinutes($session->scheduled_at) }}m
                                                @else
                                                    --
                                                @endif
                                            </h3>
                                            <p class="mb-0">Duration</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($session->banner_image)
                                <div class="mb-3">
                                    <label class="form-label text-white">Banner Image:</label>
                                    <div>
                                        <img src="{{ Storage::url($session->banner_image) }}" 
                                             alt="Session banner" 
                                             class="img-fluid rounded border">
                                    </div>
                                </div>
                            @endif

                            <!-- Technical Details -->
                            <div class="mb-3">
                                <label class="form-label text-white">Technical Details:</label>
                                <table class="table table-dark table-sm">
                                    <tr>
                                        <th>LiveKit Room:</th>
                                        <td><code class="text-info">{{ $session->livekit_room ?: 'Not assigned' }}</code></td>
                                    </tr>
                                    <tr>
                                        <th>HLS URL:</th>
                                        <td>
                                            @if($session->hls_url)
                                                <code class="text-success">{{ $session->hls_url }}</code>
                                            @else
                                                <span class="text-muted">Not available</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Recording:</th>
                                        <td>
                                            @if($session->mp4_path)
                                                <code class="text-success">{{ $session->mp4_path }}</code>
                                            @else
                                                <span class="text-muted">Not recorded</span>
                                            @endif
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
    @if($session->status == 'live' && $session->hls_url)
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
                                <source src="{{ asset('storage/app/public/recordings/' . $session->recording_filename) }}" type="video/mp4">
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
                                       <small><code>{{ $session->hls_url }}</code></small>
                                    </p>
                                    <p><strong>Room:</strong><br>
                                       <small><code>{{ $session->livekit_room }}</code></small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Recent Chat Messages -->
    @if($session->chatMessages->count() > 0)
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
                        @foreach($session->chatMessages->take(50) as $message)
                            <div class="d-flex mb-2">
                                <div class="flex-shrink-0">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 32px; height: 32px;">
                                        <small class="text-white fw-bold">
                                            {{ substr($message->user->name, 0, 1) }}
                                        </small>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <div class="d-flex align-items-center">
                                        <strong class="text-white me-2">{{ $message->user->name }}</strong>
                                        <small class="text-muted">{{ $message->sent_at->format('g:i A') }}</small>
                                    </div>
                                    <div class="text-light">{{ $message->body }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
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

@if($session->status == 'live' && $session->hls_url)
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const video = document.getElementById('livePlayer');
    const hlsUrl = '{{ $session->hls_url }}';
    
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
@endif
@endsection 