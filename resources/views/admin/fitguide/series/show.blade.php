@extends('layouts.admin')

@section('content')
<div class="series-show">
    <!-- Header Section -->
    <div class="page-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-video me-3"></i>{{ $fgSeries->title }}
                </h1>
                <p class="page-subtitle">Series Details & Episodes</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="btn-group" role="group">
                    <a href="{{ route('admin.fitguide.series.edit', $fgSeries) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit Series
                    </a>
                    <a href="{{ route('admin.fitguide.series.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Series
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Series Information -->
            <div class="content-card mb-4">
                <div class="content-card-header">
                    <h3 class="content-card-title">
                        <i class="fas fa-info-circle me-2"></i>Series Information
                    </h3>
                </div>
                <div class="content-card-body">
                    @if($fgSeries->banner_image_path)
                        <div class="mb-4">
                            <img src="{{ $fgSeries->banner_image_url }}" alt="{{ $fgSeries->title }}" class="img-fluid rounded" style="max-height: 300px; width: 100%; object-fit: cover;">
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Category</h5>
                            <p class="text-muted">{{ $fgSeries->category->name }}</p>
                        </div>
                        @if($fgSeries->subCategory)
                        <div class="col-md-6">
                            <h5>Subcategory</h5>
                            <p class="text-muted">{{ $fgSeries->subCategory->name }}</p>
                        </div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <h5>Description</h5>
                        <p class="text-muted">{{ $fgSeries->description }}</p>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <h6>Language</h6>
                            <p class="text-muted">{{ ucfirst($fgSeries->language) }}</p>
                        </div>
                        <div class="col-md-3">
                            <h6>Release Date</h6>
                            <p class="text-muted">{{ $fgSeries->release_date->format('M d, Y') }}</p>
                        </div>
                        <div class="col-md-3">
                            <h6>Total Episodes</h6>
                            <p class="text-muted">{{ $fgSeries->total_episodes }}</p>
                        </div>
                        <div class="col-md-3">
                            <h6>Cost</h6>
                            <p class="text-muted">${{ number_format($fgSeries->cost, 2) }}</p>
                        </div>
                    </div>

                    @if($fgSeries->feedback)
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <h6>Rating</h6>
                            <p class="text-muted">
                                {{ $fgSeries->feedback }}/5
                                <span class="ms-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $fgSeries->feedback)
                                            <i class="fas fa-star text-warning"></i>
                                        @else
                                            <i class="far fa-star text-muted"></i>
                                        @endif
                                    @endfor
                                </span>
                            </p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Episodes Section -->
            <div class="content-card">
                <div class="content-card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="content-card-title">
                            <i class="fas fa-list me-2"></i>Episodes ({{ $fgSeries->episodes->count() }})
                        </h3>
                        <a href="{{ route('admin.fitguide.series.episodes', $fgSeries) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-cog me-1"></i>Manage Episodes
                        </a>
                    </div>
                </div>
                <div class="content-card-body">
                    @if($fgSeries->episodes->count() > 0)
                        <div class="episodes-list">
                            @foreach($fgSeries->episodes->take(5) as $episode)
                                <div class="episode-item d-flex align-items-center p-3 mb-3 border rounded">
                                    <div class="episode-number me-3">
                                        <span class="badge bg-primary">{{ $episode->episode_number }}</span>
                                    </div>
                                    <div class="episode-info flex-grow-1">
                                        <h6 class="mb-1">{{ $episode->title }}</h6>
                                        @if($episode->description)
                                            <p class="text-muted mb-1 small">{{ Str::limit($episode->description, 100) }}</p>
                                        @endif
                                        @if($episode->duration_minutes)
                                            <small class="text-muted">{{ $episode->formatted_duration }}</small>
                                        @endif
                                    </div>
                                    <div class="episode-status">
                                        @if($episode->is_published)
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-secondary">Draft</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-film fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Episodes Yet</h5>
                            <p class="text-muted">Start adding episodes to this series.</p>
                            <a href="{{ route('admin.fitguide.series.episodes', $fgSeries) }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Add First Episode
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Status & Actions -->
            <div class="content-card mb-4">
                <div class="content-card-header">
                    <h3 class="content-card-title">
                        <i class="fas fa-cog me-2"></i>Status & Actions
                    </h3>
                </div>
                <div class="content-card-body">
                    <div class="mb-3">
                        <label class="form-label">Publication Status</label>
                        <div>
                            @if($fgSeries->is_published)
                                <span class="badge bg-success fs-6">
                                    <i class="fas fa-check-circle me-1"></i>Published
                                </span>
                            @else
                                <span class="badge bg-secondary fs-6">
                                    <i class="fas fa-clock me-1"></i>Draft
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-primary" onclick="toggleStatus({{ $fgSeries->id }})">
                            @if($fgSeries->is_published)
                                <i class="fas fa-eye-slash me-2"></i>Unpublish
                            @else
                                <i class="fas fa-eye me-2"></i>Publish
                            @endif
                        </button>
                        
                        <a href="{{ route('admin.fitguide.series.edit', $fgSeries) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Edit Series
                        </a>
                        
                        <a href="{{ route('admin.fitguide.series.episodes', $fgSeries) }}" class="btn btn-outline-info">
                            <i class="fas fa-list me-2"></i>Manage Episodes
                        </a>
                        
                        <button type="button" class="btn btn-outline-danger" onclick="deleteSeries({{ $fgSeries->id }})">
                            <i class="fas fa-trash me-2"></i>Delete Series
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleStatus(seriesId) {
    if (confirm('Are you sure you want to change the publication status?')) {
        fetch(`/admin/fitguide/series/${seriesId}/toggle-status`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the status.');
        });
    }
}

function deleteSeries(seriesId) {
    if (confirm('Are you sure you want to delete this series? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/fitguide/series/${seriesId}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection 