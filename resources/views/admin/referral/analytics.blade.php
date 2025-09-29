@extends('layouts.admin')

@section('title', 'Referral Analytics')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Referral Analytics</h1>
            <p class="mb-0">Track referral performance and statistics</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.subscriptions.referrals.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Back to Referrals
            </a>
            <a href="{{ route('admin.subscriptions.referrals.analytics') }}?range=7" 
               class="btn btn-sm btn-outline-secondary {{ request('range') == '7' ? 'active' : '' }}">7 Days</a>
            <a href="{{ route('admin.subscriptions.referrals.analytics') }}?range=30" 
               class="btn btn-sm btn-outline-secondary {{ request('range', '30') == '30' ? 'active' : '' }}">30 Days</a>
            <a href="{{ route('admin.subscriptions.referrals.analytics') }}?range=90" 
               class="btn btn-sm btn-outline-secondary {{ request('range') == '90' ? 'active' : '' }}">90 Days</a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Codes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($data['total_codes'] ?? 0) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-ticket-alt fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Active Codes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($data['active_codes'] ?? 0) }}</div>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Usages</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($data['total_usages'] ?? 0) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Revenue Generated</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">₹{{ number_format($data['revenue_from_referrals'] ?? 0, 2) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-rupee-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <!-- Daily Usage Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daily Referral Usage</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="dailyUsageChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Rate Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Usage Success Rate</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="successRateChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Successful
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-danger"></i> Failed
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Performing Codes -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Top Performing Codes</h6>
                </div>
                <div class="card-body">
                    @if(isset($data['top_codes']) && $data['top_codes']->count() > 0)
                        @foreach($data['top_codes'] as $code)
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <code class="bg-light px-2 py-1 rounded">{{ $code->code }}</code>
                                    </div>
                                    <div>
                                        <div class="font-weight-bold">{{ $code->user->name ?? 'Unknown' }}</div>
                                        <div class="text-muted small">{{ $code->user->email ?? '' }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-weight-bold text-success">{{ $code->usages_count ?? 0 }} uses</div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-chart-line fa-3x text-gray-300 mb-3"></i>
                            <p class="text-muted">No usage data available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Activity</h6>
                </div>
                <div class="card-body">
                    <div class="text-center py-4">
                        <i class="fas fa-clock fa-3x text-gray-300 mb-3"></i>
                        <p class="text-muted">Recent referral activities will appear here</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    // Daily Usage Chart
    const dailyUsageCtx = document.getElementById('dailyUsageChart').getContext('2d');
    const dailyUsageChart = new Chart(dailyUsageCtx, {
        type: 'line',
        data: {
            labels: [
                @if(isset($data['daily_usage']))
                    @foreach($data['daily_usage'] as $usage)
                        '{{ \Carbon\Carbon::parse($usage->date)->format('M d') }}',
                    @endforeach
                @endif
            ],
            datasets: [{
                label: 'Usage Count',
                data: [
                    @if(isset($data['daily_usage']))
                        @foreach($data['daily_usage'] as $usage)
                            {{ $usage->count }},
                        @endforeach
                    @endif
                ],
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Success Rate Chart
    const successRateCtx = document.getElementById('successRateChart').getContext('2d');
    const totalUsages = {{ $data['total_usages'] ?? 0 }};
    const successfulUsages = {{ $data['successful_usages'] ?? 0 }};
    const failedUsages = totalUsages - successfulUsages;
    
    const successRateChart = new Chart(successRateCtx, {
        type: 'doughnut',
        data: {
            labels: ['Successful', 'Failed'],
            datasets: [{
                data: [successfulUsages, failedUsages],
                backgroundColor: ['#1cc88a', '#e74a3b'],
                hoverBackgroundColor: ['#17a673', '#c0392b'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>
@endpush 