@extends('layouts.admin')

@section('title', 'Subscription Plans Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-credit-card fa-fw mr-2"></i>Subscription Plans
        </h1>
        <a href="{{ route('admin.subscriptions.plans.create') }}" class="btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50 mr-1"></i>Add New Plan
        </a>
    </div>

    <!-- Success/Error Messages -->
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

    <!-- Plans Table Card -->
<!-- Plans Table Card -->
<div class="card shadow mb-4 bg-dark text-light">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-secondary text-light">
        <h6 class="m-0 font-weight-bold text-light">All Subscription Plans</h6>
        <div class="dropdown no-arrow">
            <a class="dropdown-toggle text-light" href="#" role="button" data-toggle="dropdown">
                <i class="fas fa-ellipsis-v fa-sm fa-fw"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                <div class="dropdown-header">Actions:</div>
                <a class="dropdown-item" href="{{ route('admin.subscriptions.analytics') }}">
                    <i class="fas fa-chart-bar fa-sm fa-fw mr-2 text-gray-400"></i>View Analytics
                </a>
            </div>
        </div>
    </div>
    <div class="card-body bg-dark">
        @if($plans->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-light bg-dark" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Plan Name</th>
                            <th>Price</th>
                            <th>Billing Cycle</th>
                            <th>Trial Days</th>
                            <th>Subscribers</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($plans as $plan)
                            <tr class="hover-row">
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($plan->is_popular)
                                            <span class="badge badge-warning mr-2">
                                                <i class="fas fa-star"></i> Popular
                                            </span>
                                        @endif
                                        <div>
                                            <strong>{{ $plan->name }}</strong>
                                            @if($plan->description)
                                                <br><small class="text-muted">{{ Str::limit($plan->description, 50) }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-light font-weight-bold">
                                        ₹{{ number_format($plan->price, 2) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-info">
                                        {{ ucfirst($plan->billing_cycle) }}
                                        @if($plan->billing_cycle_count > 1)
                                            ({{ $plan->billing_cycle_count }}x)
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    @if($plan->trial_days > 0)
                                        <span class="badge badge-success">{{ $plan->trial_days }} days</span>
                                    @else
                                        <span class="text-muted">No trial</span>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $plan->active_subscriptions_count }}</strong> active
                                        <br><small class="text-muted">{{ $plan->subscriptions_count }} total</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox"
                                               class="custom-control-input status-toggle"
                                               id="status-{{ $plan->id }}"
                                               data-plan-id="{{ $plan->id }}"
                                               {{ $plan->is_active ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="status-{{ $plan->id }}">
                                            <span class="badge badge-{{ $plan->is_active ? 'success' : 'secondary' }}">
                                                {{ $plan->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.subscriptions.plans.show', $plan) }}"
                                           class="btn btn-sm btn-outline-info text-light" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.subscriptions.plans.edit', $plan) }}"
                                           class="btn btn-sm btn-outline-primary text-light" title="Edit Plan">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($plan->active_subscriptions_count == 0)
                                            <form method="POST"
                                                  action="{{ route('admin.subscriptions.plans.destroy', $plan) }}"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this plan?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger text-light" title="Delete Plan">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-sm btn-outline-secondary text-light"
                                                    title="Cannot delete - has active subscribers" disabled>
                                                <i class="fas fa-trash"></i>
                                            </button>
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
                    Showing {{ $plans->firstItem() }} to {{ $plans->lastItem() }} of {{ $plans->total() }} plans
                </div>
                {{ $plans->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-credit-card fa-3x text-gray-300 mb-3"></i>
                <h5 class="text-gray-500">No subscription plans found</h5>
                <p class="text-gray-400">Create your first subscription plan to get started.</p>
                <a href="{{ route('admin.subscriptions.plans.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus mr-2"></i>Create First Plan
                </a>
            </div>
        @endif
    </div>
</div>

<style>
    /* Custom Dark Mode Table Styles */
    .table {
        background-color: #222 !important; /* Force dark background for table */
        --bs-table-bg: #222 !important;
    }
    .table th, .table td {
        color: #eaeaea; /* Light text for table cells */
    }
    .table-hover tbody tr:hover {
        background-color: #444 !important; /* Darker hover effect */
    }
    .btn-outline-info, .btn-outline-primary, .btn-outline-danger {
        color: #fff;
        border-color: #555;
    }
    .btn-outline-info:hover, .btn-outline-primary:hover, .btn-outline-danger:hover {
        background-color: #444;
    }
    .badge-warning {
        background-color: #f39c12;
    }
    .badge-info {
        background-color: #17a2b8;
    }
    .badge-success {
        background-color: #28a745;
    }
    .badge-secondary {
        background-color: #6c757d;
    }
</style>

</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Handle status toggle
    $('.status-toggle').change(function() {
        const planId = $(this).data('plan-id');
        const isActive = $(this).is(':checked');
        const toggle = $(this);
        const label = toggle.next('label').find('.badge');

        $.ajax({
            url: `/admin/subscriptions/plans/${planId}/toggle-status`,
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                toggle.prop('disabled', true);
            },
            success: function(response) {
                if (response.success) {
                    // Update badge
                    if (response.is_active) {
                        label.removeClass('badge-secondary').addClass('badge-success').text('Active');
                    } else {
                        label.removeClass('badge-success').addClass('badge-secondary').text('Inactive');
                    }

                    // Show success message
                    showAlert('success', response.message);
                } else {
                    // Revert checkbox state
                    toggle.prop('checked', !isActive);
                    showAlert('error', response.message);
                }
            },
            error: function() {
                // Revert checkbox state
                toggle.prop('checked', !isActive);
                showAlert('error', 'Error updating plan status. Please try again.');
            },
            complete: function() {
                toggle.prop('disabled', false);
            }
        });
    });

    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';

        const alert = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <i class="fas ${iconClass} mr-2"></i>${message}
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;

        $('.container-fluid').prepend(alert);

        // Auto-hide after 5 seconds
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000);
    }
});
</script>
@endpush
@endsection
