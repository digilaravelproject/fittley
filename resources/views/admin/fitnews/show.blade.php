@extends('layouts.admin')

@section('title', $fitNews->title . ' - FitNews Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ $fitNews->title }}</h3>
                    <div class="d-flex gap-2">
                        <span class="badge bg-{{ $fitNews->isLive() ? 'success' : ($fitNews->isScheduled() ? 'warning' : 'secondary') }} fs-6">
                            {{ ucfirst($fitNews->status) }}
                        </span>
                        <a href="{{ route('admin.fitnews.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Stream Details -->
                        <div class="col-lg-8">
                            @if($fitNews->thumbnail)
                            <div class="mb-4">
                                <img src="{{ asset('storage/app/public/' . $fitNews->thumbnail) }}" 
                                     alt="Stream thumbnail" class="img-fluid rounded"
                                     style="max-height: 300px; width: 100%; object-fit: cover;">
                            </div>
                            @endif

                            @if($fitNews->description)
                            <div class="mb-4">
                                <h5>Description</h5>
                                <p class="text-muted">{{ $fitNews->description }}</p>
                            </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Stream Information</h6>
                                    <ul class="list-unstyled">
                                        <li><strong>Status:</strong> 
                                            <span class="badge bg-{{ $fitNews->isLive() ? 'success' : ($fitNews->isScheduled() ? 'warning' : 'secondary') }}">
                                                {{ ucfirst($fitNews->status) }}
                                            </span>
                                        </li>
                                        <li><strong>Creator:</strong> {{ $fitNews->creator->name }}</li>
                                        <li><strong>Viewers:</strong> {{ $fitNews->viewer_count }}</li>
                                        <li><strong>Recording:</strong> {{ $fitNews->recording_enabled ? 'Enabled' : 'Disabled' }}</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6>Timing</h6>
                                    <ul class="list-unstyled">
                                        <li><strong>Created:</strong> {{ $fitNews->created_at->format('M d, Y H:i') }}</li>
                                        @if($fitNews->scheduled_at)
                                            <li><strong>Scheduled:</strong> {{ $fitNews->scheduled_at->format('M d, Y H:i') }}</li>
                                        @endif
                                        @if($fitNews->started_at)
                                            <li><strong>Started:</strong> {{ $fitNews->started_at->format('M d, Y H:i') }}</li>
                                        @endif
                                        @if($fitNews->ended_at)
                                            <li><strong>Ended:</strong> {{ $fitNews->ended_at->format('M d, Y H:i') }}</li>
                                            <li><strong>Duration:</strong> {{ $fitNews->getDuration() }}</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Actions Panel -->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Actions</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        @if($fitNews->status !== 'ended')
                                            <a href="{{ route('admin.fitnews.stream', $fitNews) }}" class="btn btn-success">
                                                <i class="fas fa-video"></i> Stream Interface
                                            </a>
                                        @endif
                                        
                                        <a href="{{ route('admin.fitnews.edit', $fitNews) }}" class="btn btn-warning">
                                            <i class="fas fa-edit"></i> Edit Stream
                                        </a>
                                        
                                        <a href="{{ route('fitnews.show', $fitNews) }}" class="btn btn-info" target="_blank">
                                            <i class="fas fa-external-link-alt"></i> View Public Page
                                        </a>
                                        
                                        @if($fitNews->recording_url)
                                            <a href="{{ $fitNews->recording_url }}" class="btn btn-outline-primary">
                                                <i class="fas fa-play"></i> Watch Recording
                                            </a>
                                        @endif
                                        
                                        <hr>
                                        
                                        <form action="{{ route('admin.fitnews.destroy', $fitNews) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Are you sure you want to delete this stream? This action cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger w-100">
                                                <i class="fas fa-trash"></i> Delete Stream
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Technical Details -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h6>Technical Details</h6>
                                </div>
                                <div class="card-body">
                                    <small>
                                        <strong>Channel:</strong><br>
                                        <code>{{ $fitNews->channel_name }}</code><br><br>
                                        
                                        <strong>Stream ID:</strong><br>
                                        <code>{{ $fitNews->id }}</code><br><br>
                                        
                                        @if($fitNews->streaming_config)
                                            <strong>Agora Config:</strong><br>
                                            <code>{{ $fitNews->streaming_config['configured'] ? 'Active' : 'Inactive' }}</code>
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 