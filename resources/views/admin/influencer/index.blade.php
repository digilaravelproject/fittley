@extends('layouts.admin')

@section('title', 'Influencer Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-tie fa-fw mr-2"></i>Influencer Management
        </h1>
        <div>
            <a href="{{ route('admin.influencers.analytics') }}" class="btn btn-success btn-sm shadow-sm mr-2">
                <i class="fas fa-chart-bar fa-sm text-white-50 mr-1"></i>Analytics
            </a>
            <button type="button" class="btn btn-primary btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#addInfluencerModal">
                <i class="fas fa-plus fa-sm text-white-50 mr-1"></i>Add Influencer
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 bg-dark">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Influencers
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-white">{{ $stats['total'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 bg-dark">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Approved
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-white">{{ $stats['approved'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2 bg-dark">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pending
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-white">{{ $stats['pending'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2 bg-dark">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Sales
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-white">₹{{ number_format($stats['total_sales'] ?? 0, 2) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-rupee-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Influencers Table -->
    <div class="card shadow mb-4 bg-dark">
        <div class="card-header py-3 bg-dark">
            <h6 class="m-0 font-weight-bold text-primary">All Influencers</h6>
        </div>
        <div class="card-body bg-dark">
            <div class="table-responsive">
                <table class="table table-dark table-hover" id="influencersTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Influencer</th>
                            <th>Contact</th>
                            <th>Social Media</th>
                            <th>Status</th>
                            <th>Commission Rate</th>
                            <th>Total Sales</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($influencers as $influencer)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm mr-3">
                                        @if($influencer->profile_image)
                                            <img src="{{ asset('storage/app/public/' . $influencer->profile_image) }}" 
                                                 class="img-fluid rounded-circle" style="width: 40px; height: 40px;" alt="Profile">
                                        @else
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 40px;">
                                                {{ substr($influencer->user->name ?? 'U', 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <strong>{{ $influencer->user->name ?? 'N/A' }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            Joined {{ $influencer->created_at->format('M d, Y') }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <i class="fas fa-envelope text-muted mr-1"></i>
                                    {{ $influencer->user->email ?? 'N/A' }}
                                </div>
                                @if($influencer->phone)
                                <div class="mt-1">
                                    <i class="fas fa-phone text-muted mr-1"></i>
                                    {{ $influencer->phone }}
                                </div>
                                @endif
                            </td>
                            <td>
                                <div class="social-links">
                                    @if($influencer->social_media)
                                        @php $social = is_string($influencer->social_media) ? json_decode($influencer->social_media, true) : $influencer->social_media @endphp
                                        @if(isset($social['instagram']))
                                            <a href="{{ $social['instagram'] }}" target="_blank" class="btn btn-sm btn-outline-danger mr-1">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                        @endif
                                        @if(isset($social['youtube']))
                                            <a href="{{ $social['youtube'] }}" target="_blank" class="btn btn-sm btn-outline-danger mr-1">
                                                <i class="fab fa-youtube"></i>
                                            </a>
                                        @endif
                                        @if(isset($social['tiktok']))
                                            <a href="{{ $social['tiktok'] }}" target="_blank" class="btn btn-sm btn-outline-dark">
                                                <i class="fab fa-tiktok"></i>
                                            </a>
                                        @endif
                                    @else
                                        <span class="text-muted">No links</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @switch($influencer->status)
                                    @case('approved')
                                        <span class="badge badge-success">Approved</span>
                                        @break
                                    @case('pending')
                                        <span class="badge badge-warning">Pending</span>
                                        @break
                                    @case('rejected')
                                        <span class="badge badge-danger">Rejected</span>
                                        @break
                                    @case('suspended')
                                        <span class="badge badge-secondary">Suspended</span>
                                        @break
                                @endswitch
                            </td>
                            <td>{{ $influencer->commission_rate ?? 10 }}%</td>
                            <td>₹{{ number_format($influencer->total_sales ?? 0, 2) }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.influencers.show', $influencer) }}" 
                                       class="btn btn-info btn-sm" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.influencers.edit', $influencer) }}" 
                                       class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($influencer->status === 'pending')
                                        <form method="POST" action="{{ route('admin.influencers.approve', $influencer) }}" style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm" title="Approve">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($influencer->status === 'pending')
                                        <button class="btn btn-success btn-sm" 
                                                onclick="updateStatus({{ $influencer->id }}, 'approved')"
                                                title="Approve">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" 
                                                onclick="updateStatus({{ $influencer->id }}, 'rejected')"
                                                title="Reject">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @elseif($influencer->status === 'approved')
                                        <button class="btn btn-warning btn-sm" 
                                                onclick="updateStatus({{ $influencer->id }}, 'suspended')"
                                                title="Suspend">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    @elseif($influencer->status === 'suspended')
                                        <button class="btn btn-success btn-sm" 
                                                onclick="updateStatus({{ $influencer->id }}, 'approved')"
                                                title="Reactivate">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-user-tie fa-3x text-gray-300 mb-3"></i>
                                <h5 class="text-gray-500">No influencers found.</h5>
                                <p class="text-gray-500">Start by adding your first influencer.</p>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addInfluencerModal">
                                    <i class="fas fa-plus mr-1"></i>Add Influencer
                                </button>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($influencers->hasPages())
                <div class="mt-4">
                    {{ $influencers->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Influencer Modal -->
<div class="modal fade" id="addInfluencerModal" tabindex="-1" role="dialog" aria-labelledby="addInfluencerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header bg-dark border-bottom border-secondary">
                <h5 class="modal-title text-primary" id="addInfluencerModalLabel">
                    <i class="fas fa-user-plus mr-2"></i>Add New Influencer
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.influencers.store') }}" method="POST">
                @csrf
                <div class="modal-body bg-dark">
                    <div class="form-group">
                        <label for="user_id" class="text-white">Select User *</label>
                        <select class="form-control bg-dark text-white border-secondary" id="user_id" name="user_id" required>
                            <option value="">Choose a user...</option>
                            @foreach($availableUsers ?? [] as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Select a user who will become an influencer</small>
                    </div>

                    <div class="form-group">
                        <label for="commission_rate" class="text-white">Commission Rate (%) *</label>
                        <input type="number" class="form-control bg-dark text-white border-secondary" 
                               id="commission_rate" name="commission_rate" 
                               value="10" min="5" max="30" step="0.1" required>
                        <small class="form-text text-muted">Commission rate between 5% and 30%</small>
                    </div>

                    <div class="form-group">
                        <label for="bio" class="text-white">Bio (Optional)</label>
                        <textarea class="form-control bg-dark text-white border-secondary" 
                                  id="bio" name="bio" rows="3" 
                                  placeholder="Brief bio about the influencer..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-dark border-top border-secondary">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>Add Influencer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#influencersTable').DataTable({
        "pageLength": 25,
        "order": [[ 5, "desc" ]],
        "responsive": true
    });
});

function updateStatus(influencerId, status) {
    if (confirm(`Are you sure you want to ${status} this influencer?`)) {
        $.ajax({
            url: `/admin/influencers/${influencerId}/${status}`,
            method: 'PATCH',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    setTimeout(() => location.reload(), 1500);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function() {
                toastr.error('Error updating influencer status');
            }
        });
    }
}
</script>
@endpush 