@extends('layouts.admin')

@section('title', 'Commission Payouts')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Commission Payouts</h1>
            <p class="mb-0">Manage influencer commission payouts</p>
        </div>
        <a href="{{ route('admin.influencers.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left"></i> Back to Influencers
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Requested</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">₹{{ number_format($stats['total_requested'] ?? 0, 2) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-rupee-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Paid</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">₹{{ number_format($stats['total_paid'] ?? 0, 2) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Approval</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['pending_approval'] ?? 0) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Approved Pending Payment</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['approved_pending_payment'] ?? 0) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-credit-card fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payouts Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Payout Requests</h6>
        </div>
        <div class="card-body">
            @if($payouts->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Influencer</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Requested</th>
                                <th>Approved By</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payouts as $payout)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="font-weight-bold">{{ $payout->influencerProfile->user->name }}</div>
                                                <div class="text-muted small">{{ $payout->influencerProfile->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>₹{{ number_format($payout->amount, 2) }}</strong>
                                    </td>
                                    <td>
                                        @if($payout->status === 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($payout->status === 'approved')
                                            <span class="badge badge-info">Approved</span>
                                        @elseif($payout->status === 'completed')
                                            <span class="badge badge-success">Completed</span>
                                        @elseif($payout->status === 'failed')
                                            <span class="badge badge-danger">Failed</span>
                                        @else
                                            <span class="badge badge-secondary">{{ ucfirst($payout->status) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $payout->requested_at->format('M d, Y') }}</td>
                                    <td>
                                        @if($payout->approvedBy)
                                            <span class="text-success">{{ $payout->approvedBy->name }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($payout->admin_notes)
                                            <small>{{ Str::limit($payout->admin_notes, 50) }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($payout->status === 'pending')
                                            <button type="button" class="btn btn-sm btn-success" 
                                                    onclick="approvePayout('{{ $payout->id }}')" title="Approve">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @elseif($payout->status === 'approved')
                                            <form method="POST" action="{{ route('admin.influencers.payouts.complete', $payout) }}" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-primary" title="Mark as Completed">
                                                    <i class="fas fa-credit-card"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $payouts->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-money-check-alt fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-muted">No payout requests found</h5>
                    <p class="text-muted">Payout requests from influencers will appear here.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Approve Payout Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve Payout</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="approveForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="admin_notes">Admin Notes (Optional)</label>
                        <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3" 
                                  placeholder="Add any notes about this payout approval..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Approve Payout</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function approvePayout(payoutId) {
    $('#approveForm').attr('action', `/admin/influencers/payouts/${payoutId}/approve`);
    $('#approveModal').modal('show');
}

$(document).ready(function() {
    $('#dataTable').DataTable({
        "pageLength": 25,
        "order": [[ 3, "desc" ]]
    });
});
</script>
@endpush 