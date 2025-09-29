@extends('layouts.admin')

@section('title', 'Subscription Analytics Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Subscription Analytics</h1>
        <div class="btn-group">
            <button class="btn btn-outline-primary" onclick="exportReport()">Export Report</button>
            <button class="btn btn-primary" onclick="refreshData()">Refresh Data</button>
        </div>
    </div>

    <!-- Key Metrics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Revenue (This Month)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($metrics['monthly_revenue'], 2) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Active Subscriptions
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($metrics['active_subscriptions']) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                New Subscriptions (This Month)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($metrics['new_subscriptions']) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Churn Rate
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($metrics['churn_rate'], 1) }}%</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Chart -->
    <div class="row mb-4">
        <div class="col-xl-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Monthly Revenue Trend</h6>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" width="400" height="100"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Plan Distribution</h6>
                </div>
                <div class="card-body">
                    <canvas id="planChart" width="300" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Referral & Influencer Metrics -->
    <div class="row mb-4">
        <div class="col-xl-6">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Referral Program Performance</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center">
                                <h5 class="text-primary">{{ number_format($metrics['total_referrals']) }}</h5>
                                <p class="text-muted mb-0">Total Referrals</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <h5 class="text-success">${{ number_format($metrics['referral_savings'], 2) }}</h5>
                                <p class="text-muted mb-0">Customer Savings</p>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h6>Top Referrers This Month</h6>
                    @foreach($metrics['top_referrers'] as $referrer)
                    <div class="d-flex justify-content-between">
                        <span>{{ $referrer->name }}</span>
                        <span class="badge badge-primary">{{ $referrer->referrals_count }} referrals</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Influencer Program Performance</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center">
                                <h5 class="text-primary">{{ number_format($metrics['active_influencers']) }}</h5>
                                <p class="text-muted mb-0">Active Influencers</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <h5 class="text-warning">${{ number_format($metrics['pending_commissions'], 2) }}</h5>
                                <p class="text-muted mb-0">Pending Payouts</p>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h6>Top Performers This Month</h6>
                    @foreach($metrics['top_influencers'] as $influencer)
                    <div class="d-flex justify-content-between">
                        <span>{{ $influencer->user->name }}</span>
                        <span class="badge badge-success">${{ number_format($influencer->monthly_commission, 2) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Subscriptions -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Recent Subscriptions</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="subscriptionsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Plan</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Payment Method</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recent_subscriptions as $subscription)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle me-2" width="40" height="40" 
                                         src="{{ $subscription->user->avatar ?? asset('default-avatar.png') }}" alt="Avatar">
                                    <div>
                                        <strong>{{ $subscription->user->name }}</strong><br>
                                        <small class="text-muted">{{ $subscription->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <strong>{{ $subscription->subscriptionPlan->name }}</strong><br>
                                <small class="text-muted">${{ $subscription->subscriptionPlan->price }}/{{ $subscription->subscriptionPlan->billing_cycle }}</small>
                            </td>
                            <td>
                                @if($subscription->discount_amount > 0)
                                <s class="text-muted">${{ number_format($subscription->subscriptionPlan->price, 2) }}</s><br>
                                <strong class="text-success">${{ number_format($subscription->amount, 2) }}</strong>
                                <small class="badge badge-success">{{ $subscription->discount_percentage }}% off</small>
                                @else
                                <strong>${{ number_format($subscription->amount, 2) }}</strong>
                                @endif
                            </td>
                            <td>
                                @switch($subscription->status)
                                    @case('active')
                                        <span class="badge badge-success">Active</span>
                                        @break
                                    @case('trial')
                                        <span class="badge badge-info">Trial</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge badge-warning">Cancelled</span>
                                        @break
                                    @case('expired')
                                        <span class="badge badge-danger">Expired</span>
                                        @break
                                    @default
                                        <span class="badge badge-secondary">{{ ucfirst($subscription->status) }}</span>
                                @endswitch
                            </td>
                            <td>{{ $subscription->starts_at->format('M d, Y') }}</td>
                            <td>{{ $subscription->ends_at->format('M d, Y') }}</td>
                            <td>
                                <span class="badge badge-primary">{{ ucfirst($subscription->payment_method ?? 'N/A') }}</span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary" onclick="viewSubscription({{ $subscription->id }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @if($subscription->status === 'active')
                                    <button class="btn btn-outline-warning" onclick="cancelSubscription({{ $subscription->id }})">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    @endif
                                    <button class="btn btn-outline-danger" onclick="refundSubscription({{ $subscription->id }})">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($metrics['revenue_chart']['labels']) !!},
        datasets: [{
            label: 'Revenue',
            data: {!! json_encode($metrics['revenue_chart']['data']) !!},
            borderColor: 'rgb(54, 162, 235)',
            backgroundColor: 'rgba(54, 162, 235, 0.1)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '$' + value.toLocaleString();
                    }
                }
            }
        }
    }
});

// Plan Distribution Chart
const planCtx = document.getElementById('planChart').getContext('2d');
const planChart = new Chart(planCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($metrics['plan_chart']['labels']) !!},
        datasets: [{
            data: {!! json_encode($metrics['plan_chart']['data']) !!},
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

// Functions
function viewSubscription(id) {
    window.location.href = `/admin/subscriptions/user-subscriptions/${id}`;
}

function cancelSubscription(id) {
    if (confirm('Are you sure you want to cancel this subscription?')) {
        fetch(`/admin/subscriptions/user-subscriptions/${id}/cancel`, {
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
        });
    }
}

function refundSubscription(id) {
    if (confirm('Are you sure you want to process a refund for this subscription?')) {
        // Implement refund logic
        alert('Refund functionality would be implemented here');
    }
}

function exportReport() {
    window.location.href = '/admin/subscriptions/export';
}

function refreshData() {
    location.reload();
}

// Initialize DataTable
$(document).ready(function() {
    $('#subscriptionsTable').DataTable({
        order: [[4, 'desc']], // Sort by start date descending
        pageLength: 25
    });
});
</script>
@endsection
