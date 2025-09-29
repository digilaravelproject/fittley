@extends('layouts.admin')

@section('title', 'Referral Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">
                    <i class="fas fa-code me-2"></i>Referral Management
                </h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.subscriptions.referrals.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add New Referral Code
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Display any errors -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    @if(isset($stats))
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title mb-0">Total Codes</h5>
                            <h2 class="mb-0">{{ number_format($stats['total_codes']) }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-code fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title mb-0">Active Codes</h5>
                            <h2 class="mb-0">{{ number_format($stats['active_codes']) }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title mb-0">Total Uses</h5>
                            <h2 class="mb-0">{{ number_format($stats['total_usages']) }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title mb-0">Revenue</h5>
                            <h2 class="mb-0">${{ number_format($stats['revenue_from_referrals'], 2) }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-dollar-sign fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Referral Codes Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>Referral Codes
                    </h5>
                </div>
                <div class="card-body">
                    @if(isset($referralCodes) && $referralCodes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Code</th>
                                        <th>User</th>
                                        <th>Discount</th>
                                        <th>Max Uses</th>
                                        <th>Current Uses</th>
                                        <th>Status</th>
                                        <th>Expires</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($referralCodes as $code)
                                        <tr>
                                            <td>
                                                <strong class="text-primary">{{ $code->code }}</strong>
                                            </td>
                                            <td>
                                                @if($code->user)
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm me-2">
                                                            <span class="avatar-title bg-primary rounded-circle">
                                                                {{ substr($code->user->name, 0, 1) }}
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">{{ $code->user->name }}</h6>
                                                            <small class="text-muted">{{ $code->user->email }}</small>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">No User</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($code->discount_type === 'percentage')
                                                    <span class="badge bg-success">{{ $code->discount_value }}%</span>
                                                @else
                                                    <span class="badge bg-info">${{ $code->discount_value }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $code->max_uses ? number_format($code->max_uses) : 'Unlimited' }}
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    {{ $code->usages ? $code->usages->count() : 0 }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($code->is_active)
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check me-1"></i>Active
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-times me-1"></i>Inactive
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($code->expires_at)
                                                    <small class="text-muted">
                                                        {{ $code->expires_at->format('M d, Y') }}
                                                    </small>
                                                @else
                                                    <small class="text-muted">Never</small>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.subscriptions.referrals.show', $code) }}" 
                                                       class="btn btn-info btn-sm" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.subscriptions.referrals.edit', $code) }}" 
                                                       class="btn btn-warning btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm" title="Delete"
                                                            onclick="confirmDelete('{{ $code->id }}', '{{ $code->code }}')">
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
                        @if(method_exists($referralCodes, 'links'))
                            <div class="d-flex justify-content-center mt-3">
                                {{ $referralCodes->links() }}
                            </div>
                        @endif
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-code fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted">No referral codes found</h5>
                                <p class="text-muted mb-4">
                                    Create your first referral code to start tracking referrals<br>
                                    and reward users for bringing in new subscribers.
                                </p>
                                <a href="{{ route('admin.subscriptions.referrals.create') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-plus me-2"></i>Create First Referral Code
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
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
                <p>Are you sure you want to delete the referral code <strong id="deleteCodeName"></strong>?</p>
                <p class="text-danger"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(codeId, codeName) {
    document.getElementById('deleteCodeName').textContent = codeName;
    document.getElementById('deleteForm').action = '{{ route("admin.subscriptions.referrals.destroy", ":id") }}'.replace(':id', codeId);
    
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
        alerts.forEach(function(alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});
</script>
@endpush 