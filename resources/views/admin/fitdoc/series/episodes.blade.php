@extends('layouts.admin')

@section('title', 'Manage Episodes - ' . $series->title)

@section('content')
<div class="container-fluid">
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-list me-3"></i>Manage Episodes
                </h1>
                <p class="page-subtitle">{{ $series->title }} - {{ $series->episodes->count() }} episodes</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('admin.fitdoc.series.episodes.create', $series) }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add Episode
                </a>
                <a href="{{ route('admin.fitdoc.series.show', $series) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Series
                </a>
            </div>
        </div>
    </div>

    <!-- Series Info Card -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-2">
                    @if($series->banner_image_path)
                        <img src="{{ asset('storage/app/public/' . $series->banner_image_path) }}" 
                             alt="{{ $series->title }}" class="img-fluid rounded">
                    @else
                        <div class="series-placeholder">
                            <i class="fas fa-tv"></i>
                        </div>
                    @endif
                </div>
                <div class="col-md-10">
                    <h4>{{ $series->title }}</h4>
                    <p class="text-muted mb-2">{{ $series->description }}</p>
                    <div class="series-stats">
                        <span class="badge bg-primary me-2">{{ $series->episodes->count() }} Episodes</span>
                        <span class="badge bg-info me-2">{{ ucfirst($series->language) }}</span>
                        @if($series->is_published)
                            <span class="badge bg-success">Published</span>
                        @else
                            <span class="badge bg-secondary">Draft</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Episodes List -->
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5><i class="fas fa-video me-2"></i>Episodes</h5>
                </div>
                <div class="col-md-6">
                    <div class="search-box">
                        <input type="text" id="episode-search" class="form-control" 
                               placeholder="Search episodes...">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($series->episodes->count() > 0)
                <div class="episodes-grid" id="episodes-container">
                    @foreach($series->episodes->sortBy('episode_number') as $episode)
                        <div class="episode-card" data-episode-title="{{ strtolower($episode->title) }}" 
                             data-episode-number="{{ $episode->episode_number }}">
                            <div class="episode-poster">
                                @if($episode->banner_image_path)
                                    <img src="{{ asset('storage/app/public/' . $episode->banner_image_path) }}" 
                                         alt="Episode {{ $episode->episode_number }}">
                                @else
                                    <div class="no-poster">
                                        <i class="fas fa-play-circle"></i>
                                    </div>
                                @endif
                                <div class="episode-number-badge">{{ $episode->episode_number }}</div>
                                <div class="episode-status">
                                    @if($episode->is_published)
                                        <span class="status-badge published">
                                            <i class="fas fa-check-circle"></i>
                                        </span>
                                    @else
                                        <span class="status-badge draft">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="episode-content">
                                <div class="episode-title">{{ $episode->title }}</div>
                                <div class="episode-description">{{ Str::limit($episode->description, 80) }}</div>
                                
                                <div class="episode-meta">
                                    <div class="meta-item">
                                        <i class="fas fa-clock"></i>
                                        <span>{{ $episode->formatted_duration }}</span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="fas fa-calendar"></i>
                                        <span>{{ $episode->release_date ? $episode->release_date->format('M j') : 'TBD' }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="episode-actions">
                                <div class="action-buttons">
                                    <a href="{{ route('admin.fitdoc.series.episodes.edit', [$series, $episode]) }}" 
                                       class="btn btn-sm btn-outline-primary" title="Edit Episode">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-info toggle-status" 
                                            data-episode-id="{{ $episode->id }}" 
                                            data-current-status="{{ $episode->is_published ? 'published' : 'draft' }}"
                                            title="Toggle Status">
                                        <i class="fas fa-toggle-{{ $episode->is_published ? 'on' : 'off' }}"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger delete-episode" 
                                            data-episode-id="{{ $episode->id }}" 
                                            data-episode-title="{{ $episode->title }}"
                                            title="Delete Episode">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- No Search Results -->
                <div id="no-results" class="empty-state" style="display: none;">
                    <div class="empty-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3>No Episodes Found</h3>
                    <p>Try adjusting your search terms.</p>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-video"></i>
                    </div>
                    <h3>No Episodes Yet</h3>
                    <p>Start building your series by adding episodes.</p>
                    <a href="{{ route('admin.fitdoc.series.episodes.create', $series) }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add First Episode
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the episode "<span id="episode-title-to-delete"></span>"?</p>
                <p class="text-danger"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="delete-form" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Episode</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('episode-search');
    const episodesContainer = document.getElementById('episodes-container');
    const noResults = document.getElementById('no-results');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const episodes = document.querySelectorAll('.episode-card');
            let visibleCount = 0;
            
            episodes.forEach(episode => {
                const title = episode.dataset.episodeTitle;
                const number = episode.dataset.episodeNumber;
                
                if (title.includes(searchTerm) || number.includes(searchTerm)) {
                    episode.style.display = 'block';
                    visibleCount++;
                } else {
                    episode.style.display = 'none';
                }
            });
            
            if (visibleCount === 0 && searchTerm !== '') {
                noResults.style.display = 'block';
                episodesContainer.style.display = 'none';
            } else {
                noResults.style.display = 'none';
                episodesContainer.style.display = 'grid';
            }
        });
    }
    
    // Status toggle functionality
    document.querySelectorAll('.toggle-status').forEach(button => {
        button.addEventListener('click', function() {
            const episodeId = this.dataset.episodeId;
            const currentStatus = this.dataset.currentStatus;
            const newStatus = currentStatus === 'published' ? 'draft' : 'published';
            
            fetch(`{{ route('admin.fitdoc.series.index') }}/${episodeId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update button
                    this.dataset.currentStatus = newStatus;
                    this.innerHTML = `<i class="fas fa-toggle-${newStatus === 'published' ? 'on' : 'off'}"></i>`;
                    
                    // Update status badge
                    const statusBadge = this.closest('.episode-card').querySelector('.status-badge');
                    statusBadge.className = `status-badge ${newStatus}`;
                    statusBadge.innerHTML = newStatus === 'published' 
                        ? '<i class="fas fa-check-circle"></i>' 
                        : '<i class="fas fa-clock"></i>';
                        
                    // Show success message
                    showToast('Status updated successfully', 'success');
                } else {
                    showToast('Failed to update status', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred', 'error');
            });
        });
    });
    
    // Delete functionality
    document.querySelectorAll('.delete-episode').forEach(button => {
        button.addEventListener('click', function() {
            const episodeId = this.dataset.episodeId;
            const episodeTitle = this.dataset.episodeTitle;
            
            document.getElementById('episode-title-to-delete').textContent = episodeTitle;
            document.getElementById('delete-form').action = 
                `{{ route('admin.fitdoc.series.episodes', $series) }}/${episodeId}`;
            
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });
});

function showToast(message, type) {
    // Simple toast notification - you can enhance this
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} toast-notification`;
    toast.textContent = message;
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
</script>
@endpush

@push('styles')
<style>
.series-placeholder {
    width: 100%;
    height: 80px;
    background: var(--bg-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    color: var(--text-muted);
    font-size: 2rem;
}

.series-stats {
    margin-top: 1rem;
}

.search-box {
    position: relative;
}

.episodes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.5rem;
    margin-top: 1rem;
}

.episode-card {
    background: #1d1d1d;
    border: 1px solid var(--border-primary);
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    position: relative;
}

.episode-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    border-color: var(--primary-color);
}

.episode-poster {
    position: relative;
    width: 100%;
    height: 180px;
    overflow: hidden;
}

.episode-poster img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.episode-card:hover .episode-poster img {
    transform: scale(1.05);
}

.no-poster {
    width: 100%;
    height: 100%;
    background: var(--bg-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
    font-size: 3rem;
}

.episode-number-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 600;
}

.episode-status {
    position: absolute;
    top: 10px;
    right: 10px;
}

.status-badge {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
}

.status-badge.published {
    background: rgba(34, 197, 94, 0.9);
    color: white;
}

.status-badge.draft {
    background: rgba(156, 163, 175, 0.9);
    color: white;
}

.episode-content {
    padding: 1rem;
    flex: 1;
}

.episode-title {
    font-weight: 600;
    color: white;
    margin-bottom: 0.5rem;
    line-height: 1.3;
    font-size: 1rem;
}

.episode-description {
    color: var(--text-secondary);
    font-size: 0.9rem;
    line-height: 1.4;
    margin-bottom: 1rem;
}

.episode-meta {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.8rem;
    color: var(--text-muted);
}

.episode-actions {
    padding: 0 1rem 1rem;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}

.action-buttons .btn {
    flex: 1;
    max-width: 80px;
}

.empty-state {
    text-align: center;
    padding: 3rem 1rem;
}

.empty-icon {
    font-size: 4rem;
    color: var(--text-muted);
    margin-bottom: 1rem;
}

.empty-state h3 {
    color: white;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: var(--text-secondary);
    margin-bottom: 2rem;
}

.toast-notification {
    animation: slideIn 0.3s ease;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Modal dark theme */
.modal-content {
    background: #1d1d1d;
    border: 1px solid var(--border-primary);
}

.modal-header {
    border-bottom: 1px solid var(--border-primary);
}

.modal-footer {
    border-top: 1px solid var(--border-primary);
}
</style>
@endpush
@endsection 