@extends('layouts.admin')

@section('content')
<style>
body {
    background-color: #191919 !important;
}
.episodes-page {
    background-color: #191919;
}

/* Table background color overrides */
.table {
    --bs-table-bg: #191919 !important;
    --bs-table-color: #ffffff !important;
    background-color: #191919 !important;
}

.table > :not(caption) > * > * {
    background-color: #191919 !important;
    color: #ffffff !important;
    border-color: #333333 !important;
}

.table-hover > tbody > tr:hover > * {
    --bs-table-bg-state: #2a2a2a !important;
    background-color: #2a2a2a !important;
}

.table thead th {
    background-color: #191919 !important;
    color: #ffffff !important;
    border-color: #333333 !important;
}

.table tbody td {
    background-color: #191919 !important;
    color: #ffffff !important;
    border-color: #333333 !important;
}

/* Content cards dark theme */
.content-card {
    background-color: #2a2a2a !important;
    border-color: #333333 !important;
}

.content-card-header {
    background-color: #333333 !important;
    color: #ffffff !important;
    border-color: #333333 !important;
}

.content-card-body {
    background-color: #2a2a2a !important;
    color: #ffffff !important;
}
</style>

<div class="episodes-page">
    <!-- Header Section -->
    <div class="page-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-list me-3"></i>Episodes
                </h1>
                <p class="page-subtitle">Series: {{ $fgSeries->title }}</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="btn-group" role="group">
                    <a href="{{ route('admin.fitguide.series.episodes.create', $fgSeries) }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add Episode
                    </a>
                    <a href="{{ route('admin.fitguide.series.show', $fgSeries) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Series
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Series Info Card -->
    <div class="content-card mb-4">
        <div class="content-card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-1">{{ $fgSeries->title }}</h5>
                    <p class="text-muted mb-0">{{ $fgSeries->category->name }} @if($fgSeries->subCategory) > {{ $fgSeries->subCategory->name }} @endif</p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="d-flex gap-3">
                        <div class="text-center">
                            <div class="h4 mb-0 text-primary">{{ $episodes->total() }}</div>
                            <small class="text-muted">Total Episodes</small>
                        </div>
                        <div class="text-center">
                            <div class="h4 mb-0 text-success">{{ $episodes->where('is_published', true)->count() }}</div>
                            <small class="text-muted">Published</small>
                        </div>
                        <div class="text-center">
                            <div class="h4 mb-0 text-warning">{{ $episodes->where('is_published', false)->count() }}</div>
                            <small class="text-muted">Draft</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Episodes List -->
    <div class="content-card">
        <div class="content-card-header">
            <h3 class="content-card-title">
                <i class="fas fa-film me-2"></i>Episodes List
            </h3>
        </div>
        <div class="content-card-body">
            @if($episodes->count() > 0)
                <div class="table-responsive" style="background-color: #191919 !important;">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Duration</th>
                                <th>Video Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($episodes as $episode)
                                <tr>
                                    <td>
                                        <span class="badge bg-primary">{{ $episode->episode_number }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-1">{{ $episode->title }}</h6>
                                            @if($episode->description)
                                                <small class="text-muted">{{ Str::limit($episode->description, 60) }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($episode->duration_minutes)
                                            <span class="text-muted">{{ $episode->formatted_duration }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ ucfirst($episode->video_type) }}</span>
                                    </td>
                                    <td>
                                        @if($episode->is_published)
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-secondary">Draft</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.fitguide.series.episodes.edit', [$fgSeries, $episode]) }}" 
                                               class="btn btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-outline-warning" 
                                                    onclick="toggleEpisodeStatus({{ $fgSeries->id }}, {{ $episode->id }})"
                                                    title="Toggle Status">
                                                @if($episode->is_published)
                                                    <i class="fas fa-eye-slash"></i>
                                                @else
                                                    <i class="fas fa-eye"></i>
                                                @endif
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-outline-danger" 
                                                    onclick="deleteEpisode({{ $fgSeries->id }}, {{ $episode->id }})"
                                                    title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($episodes->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $episodes->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-film fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No Episodes Yet</h5>
                    <p class="text-muted">Start adding episodes to this series.</p>
                    <a href="{{ route('admin.fitguide.series.episodes.create', $fgSeries) }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add First Episode
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function toggleEpisodeStatus(seriesId, episodeId) {
    if (confirm('Are you sure you want to change the episode status?')) {
        fetch(`/admin/fitguide/series/${seriesId}/episodes/${episodeId}/toggle-status`, {
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

function deleteEpisode(seriesId, episodeId) {
    if (confirm('Are you sure you want to delete this episode? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/fitguide/series/${seriesId}/episodes/${episodeId}`;
        
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
