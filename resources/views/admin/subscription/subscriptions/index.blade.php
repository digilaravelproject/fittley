@extends('layouts.admin')

@section('title', 'User Subscriptions Management')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-users fa-fw mr-2"></i>User Subscriptions
        </h1>
        <div>
            <a href="{{ route('admin.subscriptions.analytics') }}" class="btn btn-success btn-sm shadow-sm mr-2">
                <i class="fas fa-chart-bar fa-sm text-white-50 mr-1"></i>Analytics
            </a>
            <a href="{{ route('admin.subscriptions.plans.index') }}" class="btn btn-primary btn-sm shadow-sm">
                <i class="fas fa-credit-card fa-sm text-white-50 mr-1"></i>Manage Plans
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle mr-2"></i>{{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Active Subscriptions
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['active'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Trial Subscriptions
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['trial'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Expired Subscriptions
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['expired'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Cancelled Subscriptions
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['cancelled'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Subscriptions Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">All User Subscriptions</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                    <div class="dropdown-header">Filter by Status:</div>
                    <a class="dropdown-item" href="{{ route('admin.subscriptions.index') }}">All Subscriptions</a>
                    <a class="dropdown-item" href="{{ route('admin.subscriptions.index', ['status' => 'active']) }}">Active Only</a>
                    <a class="dropdown-item" href="{{ route('admin.subscriptions.index', ['status' => 'trial']) }}">Trial Only</a>
                    <a class="dropdown-item" href="{{ route('admin.subscriptions.index', ['status' => 'expired']) }}">Expired Only</a>
                    <a class="dropdown-item" href="{{ route('admin.subscriptions.index', ['status' => 'cancelled']) }}">Cancelled Only</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($subscriptions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Plan</th>
                                <th>Status</th>
                                <th>Started</th>
                                <th>Ends</th>
                                <th>Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subscriptions as $subscription)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <strong>{{ $subscription->user->name }}</strong>
                                                <br><small class="text-muted">{{ $subscription->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>{{ $subscription->subscriptionPlan->name }}</strong>
                                        <br><small class="text-muted">₹{{ number_format($subscription->subscriptionPlan->price, 2) }} / {{ $subscription->subscriptionPlan->billing_cycle }}</small>
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = match($subscription->status) {
                                                'active' => 'success',
                                                'trial' => 'info',
                                                'expired' => 'warning',
                                                'cancelled' => 'danger',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge badge-{{ $statusClass }}">
                                            {{ ucfirst($subscription->status) }}
                                        </span>
                                        @if($subscription->auto_renew)
                                            <br><small class="text-success"><i class="fas fa-sync"></i> Auto-renew</small>
                                        @endif
                                    </td>
                                    <td>{{ $subscription->started_at->format('M d, Y') }}</td>
                                    <td>
                                        @if($subscription->ends_at)
                                            {{ $subscription->ends_at->format('M d, Y') }}
                                            @if($subscription->ends_at->isPast() && $subscription->status !== 'expired')
                                                <br><small class="text-danger">Overdue</small>
                                            @elseif($subscription->ends_at->diffInDays() <= 7 && $subscription->status === 'active')
                                                <br><small class="text-warning">Expires soon</small>
                                            @endif
                                        @else
                                            <span class="text-muted">No end date</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($subscription->amount_paid)
                                            <strong>₹{{ number_format($subscription->amount_paid, 2) }}</strong>
                                        @else
                                            <span class="text-muted">Free</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.subscriptions.show', $subscription) }}" 
                                               class="btn btn-sm btn-outline-info" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($subscription->status === 'active')
                                                <form method="POST" 
                                                      action="{{ route('admin.subscriptions.cancel', $subscription) }}" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Are you sure you want to cancel this subscription?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-warning" title="Cancel Subscription">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            @if($subscription->status === 'active' || $subscription->status === 'cancelled')
                                                <form method="POST" 
                                                      action="{{ route('admin.subscriptions.refund', $subscription) }}" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Are you sure you want to process a refund for this subscription?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Process Refund">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted small">
                        Showing {{ $subscriptions->firstItem() }} to {{ $subscriptions->lastItem() }} of {{ $subscriptions->total() }} subscriptions
                    </div>
                    {{ $subscriptions->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-500">No subscriptions found</h5>
                    <p class="text-gray-400">When users subscribe to plans, they will appear here.</p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-refresh every 30 seconds for real-time updates
    setInterval(function() {
        if (document.visibilityState === 'visible') {
            // Only refresh if page is visible
            location.reload();
        }
    }, 30000);
});
</script>
@endpush
@endsection
