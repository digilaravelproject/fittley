@extends('layouts.admin')

@section('title', 'Edit FitNews Stream')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Edit FitNews Stream</h3>
                    <a href="{{ route('admin.fitnews.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.fitnews.update', $fitNews) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Stream Title *</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title', $fitNews->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="4">{{ old('description', $fitNews->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="thumbnail" class="form-label">Thumbnail Image</label>
                                    @if($fitNews->thumbnail)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/app/public/' . $fitNews->thumbnail) }}" 
                                                 alt="Current thumbnail" class="img-thumbnail" style="max-height: 100px;">
                                            <small class="text-muted d-block">Current thumbnail</small>
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" 
                                           id="thumbnail" name="thumbnail" accept="image/*">
                                    @error('thumbnail')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Upload a new thumbnail image (JPEG, PNG, JPG, GIF - Max: 2MB)</div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status *</label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="draft" {{ old('status', $fitNews->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="scheduled" {{ old('status', $fitNews->status) === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                        <option value="live" {{ old('status', $fitNews->status) === 'live' ? 'selected' : '' }}>Live</option>
                                        <option value="ended" {{ old('status', $fitNews->status) === 'ended' ? 'selected' : '' }}>Ended</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3" id="scheduled-time-group" style="display: none;">
                                    <label for="scheduled_at" class="form-label">Scheduled Time</label>
                                    <input type="datetime-local" class="form-control @error('scheduled_at') is-invalid @enderror" 
                                           id="scheduled_at" name="scheduled_at" 
                                           value="{{ old('scheduled_at', $fitNews->scheduled_at ? $fitNews->scheduled_at->format('Y-m-d\TH:i') : '') }}">
                                    @error('scheduled_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="recording_enabled" 
                                               name="recording_enabled" value="1" 
                                               {{ old('recording_enabled', $fitNews->recording_enabled) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="recording_enabled">
                                            Enable Recording
                                        </label>
                                    </div>
                                    <div class="form-text">Record this stream for later viewing</div>
                                </div>

                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">Stream Info</h6>
                                        <ul class="list-unstyled mb-0">
                                            <li><small><strong>Channel:</strong> {{ $fitNews->channel_name }}</small></li>
                                            <li><small><strong>Viewers:</strong> {{ $fitNews->viewer_count }}</small></li>
                                            @if($fitNews->started_at)
                                                <li><small><strong>Started:</strong> {{ $fitNews->started_at->format('M d, Y H:i') }}</small></li>
                                            @endif
                                            @if($fitNews->ended_at)
                                                <li><small><strong>Ended:</strong> {{ $fitNews->ended_at->format('M d, Y H:i') }}</small></li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Stream
                                    </button>
                                    @if($fitNews->status === 'draft' || $fitNews->status === 'scheduled')
                                        <a href="{{ route('admin.fitnews.stream', $fitNews) }}" class="btn btn-success">
                                            <i class="fas fa-video"></i> Go to Stream
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.fitnews.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const scheduledGroup = document.getElementById('scheduled-time-group');
    
    function toggleScheduledTime() {
        if (statusSelect.value === 'scheduled') {
            scheduledGroup.style.display = 'block';
            document.getElementById('scheduled_at').required = true;
        } else {
            scheduledGroup.style.display = 'none';
            document.getElementById('scheduled_at').required = false;
        }
    }
    
    statusSelect.addEventListener('change', toggleScheduledTime);
    toggleScheduledTime(); // Initial check
});
</script>
@endsection 