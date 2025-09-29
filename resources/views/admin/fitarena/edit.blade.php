@extends('layouts.admin')

@section('title', 'Edit FitArena Event')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between mb-3">
                <h4 class="mb-sm-0 font-size-18">Edit Event</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.fitarena.index') }}">FitArena Events</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.fitarena.show', $event->id) }}">{{ $event->title }}</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-dark text-white">
        <div class="card-header border-secondary">
            <h4 class="card-title text-white">Edit Event</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.fitarena.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Event Information -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">Event Title *</label>
                            <input type="text" class="form-control bg-secondary text-white border-secondary" id="title" name="title" required
                                   placeholder="Enter event title" value="{{ old('title', $event->title) }}">
                            @error('title')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Event Slug</label>
                            <input type="text" class="form-control bg-secondary text-white border-secondary" id="slug" name="slug" 
                                   placeholder="auto-generated-from-title" value="{{ old('slug', $event->slug) }}" readonly>
                            <small class="text-muted">This will be auto-generated from the title</small>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description *</label>
                            <textarea class="form-control bg-secondary text-white border-secondary" id="description" name="description" rows="4" required
                                      placeholder="Describe your event...">{{ old('description', $event->description) }}</textarea>
                            @error('description')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Start Date *</label>
                                    <input type="date" class="form-control bg-secondary text-white border-secondary" id="start_date" name="start_date" required
                                           value="{{ old('start_date', $event->start_date ? $event->start_date->format('Y-m-d') : '') }}">
                                    @error('start_date')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" class="form-control bg-secondary text-white border-secondary" id="end_date" name="end_date"
                                           value="{{ old('end_date', $event->end_date ? $event->end_date->format('Y-m-d') : '') }}">
                                    @error('end_date')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control bg-secondary text-white border-secondary" id="location" name="location"
                                   placeholder="Event location (e.g., Online, New York, etc.)" value="{{ old('location', $event->location) }}">
                            @error('location')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="instructor_id" class="form-label">Assign Instructor</label>
                            <select class="form-select bg-secondary text-white border-secondary" id="instructor_id" name="instructor_id">
                                <option value="">Select an instructor (optional)</option>
                                @foreach($instructors as $instructor)
                                    <option value="{{ $instructor->id }}" {{ old('instructor_id', $currentInstructorId) == $instructor->id ? 'selected' : '' }}>
                                        {{ $instructor->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Change instructor assignment for this event</small>
                            @error('instructor_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="organizers" class="form-label">Organizers</label>
                            <textarea class="form-control bg-secondary text-white border-secondary" id="organizers" name="organizers" rows="3"
                                      placeholder="Enter organizers, one per line: Name | Role">{{ old('organizers', $event->organizers ? implode("\n", array_map(fn($org) => $org['name'] . ' | ' . $org['role'], $event->organizers)) : '') }}</textarea>
                            <small class="text-muted">Format: Name | Role (one per line)</small>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <!-- Current Banner Image -->
                        @if($event->banner_image)
                            <div class="mb-3">
                                <label class="form-label">Current Banner Image</label>
                                <div class="border border-secondary rounded p-2">
                                    <img src="{{ Storage::url($event->banner_image) }}" alt="Banner" class="img-fluid rounded">
                                </div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="banner_image" class="form-label">{{ $event->banner_image ? 'Replace Banner Image' : 'Banner Image' }}</label>
                            <input type="file" class="form-control bg-secondary text-white border-secondary" id="banner_image" name="banner_image" accept="image/*">
                            <small class="text-muted">Recommended size: 1920x1080px</small>
                            @error('banner_image')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Current Logo -->
                        @if($event->logo)
                            <div class="mb-3">
                                <label class="form-label">Current Logo</label>
                                <div class="border border-secondary rounded p-2 text-center">
                                    <img src="{{ Storage::url($event->logo) }}" alt="Logo" class="img-fluid" style="max-height: 100px;">
                                </div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="logo" class="form-label">{{ $event->logo ? 'Replace Logo' : 'Event Logo' }}</label>
                            <input type="file" class="form-control bg-secondary text-white border-secondary" id="logo" name="logo" accept="image/*">
                            <small class="text-muted">Recommended size: 400x400px</small>
                            @error('logo')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="visibility" class="form-label">Visibility *</label>
                            <select class="form-select bg-secondary text-white border-secondary" id="visibility" name="visibility" required>
                                <option value="public" {{ old('visibility', $event->visibility) === 'public' ? 'selected' : '' }}>Public</option>
                                <option value="private" {{ old('visibility', $event->visibility) === 'private' ? 'selected' : '' }}>Private</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="expected_viewers" class="form-label">Expected Viewers</label>
                            <input type="number" class="form-control bg-secondary text-white border-secondary" id="expected_viewers" name="expected_viewers" min="0"
                                   value="{{ old('expected_viewers', $event->expected_viewers) }}">
                        </div>
                    </div>
                </div>

                <!-- Advanced Settings -->
                <div class="card bg-secondary border-secondary mt-4">
                    <div class="card-header">
                        <h5 class="card-title text-white mb-0">DVR & Recording Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="dvr_enabled" name="dvr_enabled" value="1" 
                                           {{ old('dvr_enabled', $event->dvr_enabled) ? 'checked' : '' }}>
                                    <label class="form-check-label text-white" for="dvr_enabled">
                                        Enable DVR (Digital Video Recording)
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="dvr_hours" class="form-label">DVR Hours</label>
                                    <input type="number" class="form-control bg-dark text-white border-secondary" id="dvr_hours" name="dvr_hours" 
                                           min="1" max="168" value="{{ old('dvr_hours', $event->dvr_hours ?: 24) }}">
                                    <small class="text-muted">Hours to keep recording available (1-168)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Event Status -->
                <div class="card bg-secondary border-secondary mt-4">
                    <div class="card-header">
                        <h5 class="card-title text-white mb-0">Event Options</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" 
                                   {{ old('is_featured', $event->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label text-white" for="is_featured">
                                Featured Event
                            </label>
                            <small class="text-muted d-block">Featured events appear prominently on the homepage</small>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="text-end">
                            <a href="{{ route('admin.fitarena.show', $event->id) }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Event
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Auto-generate slug from title
document.getElementById('title').addEventListener('input', function() {
    const title = this.value;
    const slug = title.toLowerCase()
        .replace(/[^\w\s-]/g, '') // Remove special characters
        .replace(/\s+/g, '-') // Replace spaces with hyphens
        .replace(/-+/g, '-') // Replace multiple hyphens with single hyphen
        .trim('-'); // Remove leading/trailing hyphens
    
    document.getElementById('slug').value = slug;
});

// Toggle DVR hours input based on DVR enabled checkbox
document.getElementById('dvr_enabled').addEventListener('change', function() {
    const dvrHoursInput = document.getElementById('dvr_hours');
    dvrHoursInput.disabled = !this.checked;
    if (!this.checked) {
        dvrHoursInput.value = '';
    } else {
        dvrHoursInput.value = '24';
    }
});
</script>
@endpush
@endsection 