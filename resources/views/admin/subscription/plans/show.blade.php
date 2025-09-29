@extends('layouts.admin')

@section('title', 'Plan Details - ' . $subscriptionPlan->name)

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-eye fa-fw mr-2"></i>Plan Details
        </h1>
        <div>
            <a href="{{ route('admin.subscriptions.plans.edit', $subscriptionPlan) }}" class="btn btn-primary btn-sm shadow-sm mr-2">
                <i class="fas fa-edit fa-sm text-white-50 mr-1"></i>Edit Plan
            </a>
            <a href="{{ route('admin.subscriptions.plans.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i>Back to Plans
            </a>
        </div>
    </div>

    <!-- Plan Overview -->
    <div class="row">
        <!-- Plan Details Card -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4 bg-dark text-white">
                <div class="card-header py-3 bg-dark border-bottom border-secondary d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $subscriptionPlan->name }}</h6>
                    <div>
                        @if($subscriptionPlan->is_popular)
                            <span class="badge badge-warning mr-2"><i class="fas fa-star"></i> Popular</span>
                        @endif
                        @if($subscriptionPlan->is_active)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-secondary">Inactive</span>
                        @endif
                    </div>
                </div>
                <div class="card-body bg-dark">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-primary">Basic Information</h5>
                            <table class="table table-borderless text-white">
                                <tr>
                                    <td><strong>Plan Name:</strong></td>
                                    <td>{{ $subscriptionPlan->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Price:</strong></td>
                                    <td class="text-success">₹{{ number_format($subscriptionPlan->price, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Billing Cycle:</strong></td>
                                    <td>{{ ucfirst($subscriptionPlan->billing_cycle) }} ({{ $subscriptionPlan->billing_cycle_count }})</td>
                                </tr>
                                <tr>
                                    <td><strong>Trial Period:</strong></td>
                                    <td>{{ $subscriptionPlan->trial_days }} days</td>
                                </tr>
                                <tr>
                                    <td><strong>Sort Order:</strong></td>
                                    <td>{{ $subscriptionPlan->sort_order }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Created:</strong></td>
                                    <td>{{ $subscriptionPlan->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-primary">Description</h5>
                            <p class="text-muted">{{ $subscriptionPlan->description ?: 'No description provided.' }}</p>
                            
                            <h5 class="text-primary mt-4">Features</h5>
                            @if($subscriptionPlan->features && count($subscriptionPlan->features) > 0)
                                <ul class="list-unstyled">
                                    @foreach($subscriptionPlan->features as $feature)
                                        <li class="mb-1">
                                            <i class="fas fa-check text-success mr-2"></i>{{ $feature }}
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">No features listed.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Card -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4 bg-dark text-white">
                <div class="card-header py-3 bg-dark border-bottom border-secondary">
                    <h6 class="m-0 font-weight-bold text-info">Plan Statistics</h6>
                </div>
                <div class="card-body bg-dark">
                    <div class="text-center mb-3">
                        <div class="h4 text-primary">₹{{ number_format($stats['total_revenue'] ?? 0, 2) }}</div>
                        <div class="text-muted">Total Revenue</div>
                    </div>
                    
                    <hr class="border-secondary">
                    
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="h5 text-info">{{ $stats['total_subscriptions'] ?? 0 }}</div>
                            <div class="text-muted small">Total Subs</div>
                        </div>
                        <div class="col-6">
                            <div class="h5 text-success">{{ $stats['active_subscriptions'] ?? 0 }}</div>
                            <div class="text-muted small">Active Subs</div>
                        </div>
                    </div>
                    
                    <hr class="border-secondary">
                    
                    <div class="text-center">
                        <div class="h5 text-warning">₹{{ number_format($stats['monthly_revenue'] ?? 0, 2) }}</div>
                        <div class="text-muted small">This Month</div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow mb-4 bg-dark text-white">
                <div class="card-header py-3 bg-dark border-bottom border-secondary">
                    <h6 class="m-0 font-weight-bold text-info">Quick Actions</h6>
                </div>
                <div class="card-body bg-dark">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary btn-sm mb-2" onclick="togglePlanStatus()">
                            @if($subscriptionPlan->is_active)
                                <i class="fas fa-pause mr-1"></i>Deactivate Plan
                            @else
                                <i class="fas fa-play mr-1"></i>Activate Plan
                            @endif
                        </button>
                        
                        <button class="btn btn-outline-warning btn-sm mb-2" onclick="togglePopular()">
                            @if($subscriptionPlan->is_popular)
                                <i class="fas fa-star-o mr-1"></i>Remove Popular
                            @else
                                <i class="fas fa-star mr-1"></i>Mark Popular
                            @endif
                        </button>
                        
                        <a href="{{ route('admin.subscriptions.plans.edit', $subscriptionPlan) }}" class="btn btn-outline-info btn-sm mb-2">
                            <i class="fas fa-edit mr-1"></i>Edit Plan
                        </a>
                        
                        @if($stats['active_subscriptions'] == 0)
                            <button class="btn btn-outline-danger btn-sm" onclick="deletePlan()">
                                <i class="fas fa-trash mr-1"></i>Delete Plan
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Subscriptions -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4 bg-dark text-white">
                <div class="card-header py-3 bg-dark border-bottom border-secondary">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Subscriptions</h6>
                </div>
                <div class="card-body bg-dark">
                    @if($subscriptionPlan->subscriptions && $subscriptionPlan->subscriptions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subscriptionPlan->subscriptions as $subscription)
                                    <tr>
                                        <td>
                                            <div>
                                                <strong>{{ $subscription->user->name ?? 'N/A' }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $subscription->user->email ?? 'N/A' }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            @switch($subscription->status)
                                                @case('active')
                                                    <span class="badge badge-success">Active</span>
                                                    @break
                                                @case('expired')
                                                    <span class="badge badge-warning">Expired</span>
                                                    @break
                                                @case('cancelled')
                                                    <span class="badge badge-danger">Cancelled</span>
                                                    @break
                                                @default
                                                    <span class="badge badge-secondary">{{ ucfirst($subscription->status) }}</span>
                                            @endswitch
                                        </td>
                                        <td class="text-success">₹{{ number_format($subscription->amount_paid, 2) }}</td>
                                        <td>{{ $subscription->started_at ? $subscription->started_at->format('M d, Y') : 'N/A' }}</td>
                                        <td>{{ $subscription->ends_at ? $subscription->ends_at->format('M d, Y') : 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('admin.subscriptions.show', $subscription) }}" 
                                               class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-3x text-gray-300 mb-3"></i>
                            <p class="text-gray-500">No subscriptions found for this plan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function togglePlanStatus() {
    if (confirm('Are you sure you want to change the plan status?')) {
        $.ajax({
            url: '{{ route("admin.subscriptions.plans.toggle-status", $subscriptionPlan) }}',
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
                toastr.error('Error updating plan status');
            }
        });
    }
}

function togglePopular() {
    if (confirm('Are you sure you want to change the popular status?')) {
        $.ajax({
            url: '{{ route("admin.subscriptions.plans.toggle-status", $subscriptionPlan) }}',
            method: 'PATCH',
            data: {
                _token: '{{ csrf_token() }}',
                toggle_popular: true
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
                toastr.error('Error updating popular status');
            }
        });
    }
}

function deletePlan() {
    if (confirm('Are you sure you want to delete this plan? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.subscriptions.plans.destroy", $subscriptionPlan) }}';
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        
        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = '{{ csrf_token() }}';
        
        form.appendChild(methodInput);
        form.appendChild(tokenInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush
@endsection
