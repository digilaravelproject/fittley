@extends('layouts.admin')

@section('title', 'Community Moderation')

@section('content')
<div class="admin-dashboard">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h1 class="page-title-text">
                    <i class="fas fa-shield-alt page-title-icon"></i>
                    Community Moderation
                </h1>
                <p class="page-subtitle">Monitor and moderate community content and users</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.community.dashboard') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
                <button type="button" class="btn btn-warning" onclick="refreshStats()">
                    <i class="fas fa-sync-alt me-2"></i>Refresh
                </button>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Moderation Stats -->
    <div class="stats-grid mb-5">
        <div class="row g-4">
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card stat-card-warning">
                    <div class="stat-card-body">
                        <div class="stat-icon">
                            <i class="fas fa-flag"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $stats['flagged_posts'] ?? 0 }}</div>
                            <div class="stat-label">Flagged Posts</div>
                            <div class="stat-trend">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span>Needs Review</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card stat-card-info">
                    <div class="stat-card-body">
                        <div class="stat-icon">
                            <i class="fas fa-comment"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $stats['flagged_comments'] ?? 0 }}</div>
                            <div class="stat-label">Flagged Comments</div>
                            <div class="stat-trend">
                                <i class="fas fa-eye"></i>
                                <span>Pending Review</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card stat-card-danger">
                    <div class="stat-card-body">
                        <div class="stat-icon">
                            <i class="fas fa-user-slash"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $stats['blocked_users'] ?? 0 }}</div>
                            <div class="stat-label">Blocked Users</div>
                            <div class="stat-trend">
                                <i class="fas fa-ban"></i>
                                <span>Currently Blocked</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card stat-card-success">
                    <div class="stat-card-body">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ ($stats['total_posts'] ?? 0) - ($stats['flagged_posts'] ?? 0) }}</div>
                            <div class="stat-label">Clean Posts</div>
                            <div class="stat-trend">
                                <i class="fas fa-thumbs-up"></i>
                                <span>No Issues</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4 mb-5">
        <div class="col-xl-12">
            <div class="dashboard-card">
                <div class="card-header">
                    <h3 class="card-title">Quick Moderation Actions</h3>
                </div>
                <div class="card-body">
                    <div class="quick-actions-grid">
                        <a href="{{ route('admin.community.moderation.flagged-posts') }}" class="quick-action-card">
                            <div class="action-icon bg-warning">
                                <i class="fas fa-flag"></i>
                            </div>
                            <div class="action-content">
                                <h5>Review Flagged Posts</h5>
                                <p>{{ $stats['flagged_posts'] ?? 0 }} posts need review</p>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>

                        <?php /*<a href="{{ route('admin.community.moderation.flagged-comments') }}" class="quick-action-card">
                            <div class="action-icon bg-info">
                                <i class="fas fa-comment"></i>
                            </div>
                            <div class="action-content">
                                <h5>Review Flagged Comments</h5>
                                <p>{{ $stats['flagged_comments'] ?? 0 }} comments flagged</p>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a> */?>

                        <button type="button" class="quick-action-card" data-bs-toggle="modal" data-bs-target="#moderationRulesModal">
                            <div class="action-icon bg-primary">
                                <i class="fas fa-rules"></i>
                            </div>
                            <div class="action-content">
                                <h5>Community Rules</h5>
                                <p>Review and update guidelines</p>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Flagged Content -->
    <div class="row g-4">
        <div class="col-xl-12">
            <div class="dashboard-card">
                <div class="card-header">
                    <h3 class="card-title">Recent Flagged Posts</h3>
                    <a href="{{ route('admin.community.moderation.flagged-posts') }}" class="view-all">View All</a>
                </div>
                <div class="card-body">
                    @if(isset($flaggedPosts) && $flaggedPosts->count() > 0)
                        <div class="flagged-posts-list">
                            @foreach($flaggedPosts as $post)
                                <div class="flagged-post-item">
                                    <div class="post-content">
                                        <div class="post-header">
                                            <div class="user-info">
                                                <i class="fas fa-user-circle me-2"></i>
                                                <strong>{{ $post->user->name ?? 'Unknown User' }}</strong>
                                                <span class="text-muted">in</span>
                                                <span class="category-badge" style="background-color: {{ $post->category->color ?? '#6c757d' }};">
                                                    {{ $post->category->name ?? 'Uncategorized' }}
                                                </span>
                                            </div>
                                            <div class="post-meta">
                                                <small class="text-muted">
                                                    <i class="fas fa-flag me-1"></i>
                                                    Flagged {{ $post->flagged_at ? \Carbon\Carbon::parse($post->flagged_at)->diffForHumans() : 'recently' }}
                                                </small>
                                            </div>
                                        </div>
                                        <div class="post-text">
                                            <p>{{ Str::limit($post->content, 200) }}</p>
                                        </div>
                                        @if($post->flag_reason)
                                            <div class="flag-reason">
                                                <strong>Reason:</strong> {{ $post->flag_reason }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="post-actions">
                                        <button type="button" class="btn btn-sm btn-success" onclick="approvePost({{ $post->id }})">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                        <button type="button" class="btn btn-sm btn-warning" onclick="reviewPost({{ $post->id }})">
                                            <i class="fas fa-eye"></i> Review
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="removePost({{ $post->id }})">
                                            <i class="fas fa-trash"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state text-center py-4">
                            <i class="fas fa-shield-check fa-3x text-success mb-3"></i>
                            <h4>All Clean!</h4>
                            <p class="text-muted">No flagged posts require your attention right now.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Community Rules Modal -->
<div class="modal fade" id="moderationRulesModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Community Guidelines & Rules</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="rules-content">
                    <h6>Content Guidelines</h6>
                    <ul>
                        <li>Keep content relevant to fitness and wellness</li>
                        <li>No spam, self-promotion, or irrelevant links</li>
                        <li>Respect others and maintain a positive environment</li>
                        <li>No offensive, discriminatory, or harmful content</li>
                        <li>Share authentic experiences and advice</li>
                    </ul>

                    <h6 class="mt-4">Automatic Flagging Triggers</h6>
                    <ul>
                        <li>Posts with excessive profanity</li>
                        <li>Content reported by multiple users</li>
                        <li>Suspected spam or promotional content</li>
                        <li>Posts containing external links to suspicious sites</li>
                    </ul>

                    <h6 class="mt-4">Moderator Actions</h6>
                    <ul>
                        <li><strong>Approve:</strong> Remove flag and allow content</li>
                        <li><strong>Remove:</strong> Delete content and notify user</li>
                        <li><strong>Block User:</strong> Restrict user access</li>
                        <li><strong>Warning:</strong> Send warning to user</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Update Rules</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
.quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.quick-action-card {
    display: flex;
    align-items: center;
    padding: 1.5rem;
    background: var(--bg-tertiary);
    border: 1px solid var(--border-primary);
    border-radius: 12px;
    text-decoration: none;
    color: inherit;
    transition: all var(--transition-fast);
    cursor: pointer;
}

.quick-action-card:hover {
    background: var(--bg-hover);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    text-decoration: none;
    color: inherit;
}

.action-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    margin-right: 1rem;
    flex-shrink: 0;
}

.action-content {
    flex: 1;
}

.action-content h5 {
    margin: 0 0 0.5rem;
    color: var(--text-primary);
    font-weight: 600;
}

.action-content p {
    margin: 0;
    color: var(--text-muted);
    font-size: 0.875rem;
}

.action-arrow {
    color: var(--text-muted);
    font-size: 1.2rem;
}

.flagged-posts-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.flagged-post-item {
    display: flex;
    background: var(--bg-tertiary);
    border: 1px solid var(--border-primary);
    border-left: 4px solid #ffb020;
    border-radius: 8px;
    padding: 1.5rem;
    gap: 1rem;
}

.post-content {
    flex: 1;
}

.post-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.category-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    color: white;
    font-size: 0.75rem;
    font-weight: 500;
}

.post-text {
    margin-bottom: 1rem;
    color: var(--text-primary);
}

.flag-reason {
    padding: 0.75rem;
    background: rgba(255, 176, 32, 0.1);
    border-radius: 6px;
    font-size: 0.875rem;
    color: var(--warning);
}

.post-actions {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    align-items: flex-end;
}

.empty-state {
    color: var(--text-muted);
}

.rules-content h6 {
    color: var(--text-primary);
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.rules-content ul {
    margin-bottom: 0;
    padding-left: 1.5rem;
}

.rules-content li {
    margin-bottom: 0.5rem;
    color: var(--text-secondary);
}
</style>
@endpush

@push('scripts')
<script>
function refreshStats() {
    location.reload();
}

function approvePost(postId) {
    if (confirm('Are you sure you want to approve this post?')) {
        fetch(`/admin/community/moderation/posts/${postId}/unflag`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ action: 'approve' })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error approving post: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error approving post');
        });
    }
}

function reviewPost(postId) {
    window.open(`/admin/community/posts/${postId}`, '_blank');
}

function removePost(postId) {
    if (confirm('Are you sure you want to remove this post? This action cannot be undone.')) {
        fetch(`/admin/community/moderation/posts/${postId}/remove`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ action: 'remove' })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error removing post: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error removing post');
        });
    }
}
</script>
@endpush 