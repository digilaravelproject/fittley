@extends('layouts.admin')

@section('title', 'Subscription Analytics')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-chart-line fa-fw mr-2"></i>Subscription Analytics
        </h1>
        <div class="d-flex">
            <select class="form-control form-control-sm mr-2" id="timeRange">
                <option value="7">Last 7 days</option>
                <option value="30" selected>Last 30 days</option>
                <option value="90">Last 90 days</option>
                <option value="365">Last year</option>
            </select>
            <button class="btn btn-primary btn-sm" onclick="refreshData()">
                <i class="fas fa-sync-alt mr-1"></i>Refresh
            </button>
        </div>
    </div>

    <!-- Statistics Row -->
    <div class="row">
        <!-- Total Subscriptions -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Subscriptions
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($data['subscriptions_created'] ?? 0) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Revenue
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                ₹{{ number_format($data['revenue'] ?? 0, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-rupee-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Subscriptions -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Active Subscriptions
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($data['active_subscriptions'] ?? 0) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Churn Rate -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Churn Rate
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($data['churn_rate'] ?? 0, 1) }}%
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Daily Subscriptions Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Daily Subscriptions</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="dailySubscriptionsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Popular Plans Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Popular Plans</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="popularPlansChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        @foreach($data['popular_plans'] ?? [] as $plan)
                            <span class="mr-2">
                                <i class="fas fa-circle text-primary"></i> {{ $plan['name'] }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Plans Performance Table -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Plan Performance</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="plansTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Plan Name</th>
                                    <th>Price</th>
                                    <th>Total Subscriptions</th>
                                    <th>Active Subscriptions</th>
                                    <th>Revenue</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['popular_plans'] ?? [] as $plan)
                                <tr>
                                    <td>
                                        <strong>{{ $plan['name'] }}</strong>
                                        @if($plan['is_popular'])
                                            <span class="badge badge-warning ml-1">Popular</span>
                                        @endif
                                    </td>
                                    <td>₹{{ number_format($plan['price'], 2) }}</td>
                                    <td>{{ number_format($plan['subscriptions_count'] ?? 0) }}</td>
                                    <td>
                                        <span class="badge badge-success">
                                            {{ number_format($plan['subscriptions_count'] ?? 0) }}
                                        </span>
                                    </td>
                                    <td>₹{{ number_format(($plan['subscriptions_count'] ?? 0) * $plan['price'], 2) }}</td>
                                    <td>
                                        @if($plan['is_active'])
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.subscriptions.plans.show', $plan) }}" 
                                           class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.subscriptions.plans.edit', $plan) }}" 
                                           class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#plansTable').DataTable({
        "order": [[ 2, "desc" ]],
        "pageLength": 10,
        "responsive": true
    });

    // Daily Subscriptions Chart
    const dailyData = @json($data['daily_subscriptions'] ?? []);
    const ctxDaily = document.getElementById('dailySubscriptionsChart').getContext('2d');
    new Chart(ctxDaily, {
        type: 'line',
        data: {
            labels: dailyData.map(item => item.date),
            datasets: [{
                label: 'Subscriptions',
                data: dailyData.map(item => item.count),
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Popular Plans Chart
    const plansData = @json($data['popular_plans'] ?? []);
    const ctxPlans = document.getElementById('popularPlansChart').getContext('2d');
    new Chart(ctxPlans, {
        type: 'doughnut',
        data: {
            labels: plansData.map(plan => plan.name),
            datasets: [{
                data: plansData.map(plan => plan.subscriptions_count || 0),
                backgroundColor: [
                    '#4e73df',
                    '#1cc88a',
                    '#36b9cc',
                    '#f6c23e',
                    '#e74a3b'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
});

function refreshData() {
    const timeRange = $('#timeRange').val();
    window.location.href = `{{ route('admin.subscriptions.analytics') }}?range=${timeRange}`;
}
</script>
@endpush
@endsection 