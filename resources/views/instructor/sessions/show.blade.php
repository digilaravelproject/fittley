@extends('layouts.admin')

@section('title', 'Session Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Session Details</h3>
                    <div class="btn-group">
                        <a href="{{ route('instructor.sessions') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Sessions
                        </a>
                        @if($session->status === 'scheduled' || $session->status === 'live')
                            <a href="{{ route('instructor.sessions.stream', $session) }}" class="btn btn-primary">
                                <i class="fas fa-video"></i> 
                                {{ $session->status === 'live' ? 'Join Stream' : 'Start Stream' }}
                            </a>
                        @endif
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h4>{{ $session->title }}</h4>
                            <p class="text-muted">{{ $session->description }}</p>
                            
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <h6>Session Information</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                <span class="badge badge-{{ $session->status === 'live' ? 'success' : ($session->status === 'scheduled' ? 'warning' : 'secondary') }}">
                                                    {{ ucfirst($session->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Category:</strong></td>
                                            <td>{{ $session->category->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Subcategory:</strong></td>
                                            <td>{{ $session->subCategory->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Scheduled:</strong></td>
                                            <td>{{ $session->scheduled_at ? $session->scheduled_at->format('M d, Y h:i A') : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Visibility:</strong></td>
                                            <td>{{ ucfirst($session->visibility) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Chat Mode:</strong></td>
                                            <td>{{ ucfirst($session->chat_mode) }}</td>
                                        </tr>
                                    </table>
                                </div>
                                
                                <div class="col-md-6">
                                    <h6>Session Stats</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td><strong>Current Viewers:</strong></td>
                                            <td>{{ $session->viewer_count ?? 0 }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Peak Viewers:</strong></td>
                                            <td>{{ $session->viewer_peak ?? 0 }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Messages:</strong></td>
                                            <td>{{ $session->chatMessages->count() }}</td>
                                        </tr>
                                        @if($session->started_at)
                                            <tr>
                                                <td><strong>Started:</strong></td>
                                                <td>{{ $session->started_at->format('M d, Y h:i A') }}</td>
                                            </tr>
                                        @endif
                                        @if($session->ended_at)
                                            <tr>
                                                <td><strong>Ended:</strong></td>
                                                <td>{{ $session->ended_at->format('M d, Y h:i A') }}</td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            @if($session->banner_image)
                                <div class="mb-3">
                                    <h6>Banner Image</h6>
                                    <img src="{{ $session->banner_image }}" alt="Session Banner" class="img-fluid rounded">
                                </div>
                            @endif
                            
                            @if($streamingConfig && $streamingConfig['configured'])
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-info-circle"></i> Streaming Ready</h6>
                                    <p class="mb-0">Your streaming configuration is ready. Click "Start Stream" to begin broadcasting.</p>
                                </div>
                            @elseif($streamingConfig)
                                <div class="alert alert-warning">
                                    <h6><i class="fas fa-exclamation-triangle"></i> Configuration Required</h6>
                                    <p class="mb-0">Streaming configuration is incomplete. Please contact administrator.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    @if($session->chatMessages->count() > 0)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h6>Recent Chat Messages</h6>
                                <div class="chat-messages" style="max-height: 300px; overflow-y: auto;">
                                    @foreach($session->chatMessages as $message)
                                        <div class="chat-message mb-2 p-2 border rounded">
                                            <div class="d-flex justify-content-between">
                                                <strong>{{ $message->user->name ?? 'Anonymous' }}</strong>
                                                <small class="text-muted">{{ $message->sent_at->format('M d, h:i A') }}</small>
                                            </div>
                                            <div>{{ $message->message }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection