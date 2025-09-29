@extends('layouts.app')

@section('title', 'Analytics Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-chart-bar text-primary"></i>
            Analytics Dashboard
        </h1>
        <div class="btn-group">
            <a href="{{ route('instructor.dashboard') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
            <button class="btn btn-outline-secondary" onclick="window.print()">
                <i class="fas fa-print"></i> Print Report
            </button>
        </div>
    </div>

    <!-- Overview Stats -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Sessions
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $analytics['total_sessions'] }}
                            </div>
                            <div class="text-xs text-muted">
                                This month: {{ $analytics['this_month_sessions'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-video fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Viewers
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($analytics['total_viewers']) }}
                            </div>
                            <div class="text-xs text-muted">
                                Avg: {{ number_format($analytics['average_viewers'], 1) }} per session
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
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
                                Completed Sessions
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $analytics['completed_sessions'] }}
                            </div>
                            <div class="text-xs text-muted">
                                Success rate: {{ $analytics['total_sessions'] > 0 ? number_format(($analytics['completed_sessions'] / $analytics['total_sessions']) * 100, 1) : 0 }}%
                            </div>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Chat Messages
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($analytics['total_chat_messages']) }}
                            </div>
                            <div class="text-xs text-muted">
                                Avg: {{ $analytics['total_sessions'] > 0 ? number_format($analytics['total_chat_messages'] / $analytics['total_sessions'], 1) : 0 }} per session
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <!-- Monthly Performance Chart -->
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Monthly Performance Trends</h6>
                </div>
                <div class="card-body">
                    <canvas id="monthlyTrendsChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Category Performance -->
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Sessions by Category</h6>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Analytics -->
    <div class="row">
        <!-- Top Performing Sessions -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Top Performing Sessions</h6>
                </div>
                <div class="card-body">
                    @if($topSessions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Session Title</th>
                                    <th>Category</th>
                                    <th>Date</th>
                                    <th>Peak Viewers</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topSessions as $index => $session)
                                <tr>
                                    <td>
                                        <span class="badge badge-{{ $index < 3 ? 'warning' : 'secondary' }}">
                                            #{{ $index + 1 }}
                                        </span>
                                    </td>
                                    <td>
                                        <strong>{{ $session->title }}</strong>
                                    </td>
                                    <td>{{ $session->category->name ?? 'N/A' }}</td>
                                    <td>{{ $session->scheduled_at->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge badge-info">{{ $session->viewer_peak }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $session->status_color }}">
                                            {{ ucfirst($session->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-chart-line fa-3x text-gray-300 mb-3"></i>
                        <p class="text-muted">No session data available yet.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Category Performance Details -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Category Performance</h6>
                </div>
                <div class="card-body">
                    @if($categoryPerformance->count() > 0)
                        @foreach($categoryPerformance as $categoryName => $performance)
                        <div class="mb-3 p-3 bg-light rounded">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">{{ $categoryName }}</h6>
                                <span class="badge badge-primary">{{ $performance['sessions'] }} sessions</span>
                            </div>
                            <div class="small text-muted">
                                <div class="d-flex justify-content-between">
                                    <span>Total Viewers:</span>
                                    <strong>{{ number_format($performance['total_viewers']) }}</strong>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Avg. Viewers:</span>
                                    <strong>{{ number_format($performance['avg_viewers'], 1) }}</strong>
                                </div>
                            </div>
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar" role="progressbar" 
                                     style="width: {{ $analytics['total_sessions'] > 0 ? ($performance['sessions'] / $analytics['total_sessions']) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-tags fa-2x text-gray-300 mb-2"></i>
                            <p class="text-muted mb-0">No category data available</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Stats</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="h4 mb-0 font-weight-bold text-primary">
                                {{ $analytics['this_week_sessions'] }}
                            </div>
                            <div class="small text-muted">This Week</div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="h4 mb-0 font-weight-bold text-success">
                                {{ $analytics['live_sessions'] }}
                            </div>
                            <div class="small text-muted">Currently Live</div>
                        </div>
                        <div class="col-6">
                            <div class="h4 mb-0 font-weight-bold text-info">
                                {{ $analytics['scheduled_sessions'] }}
                            </div>
                            <div class="small text-muted">Scheduled</div>
                        </div>
                        <div class="col-6">
                            <div class="h4 mb-0 font-weight-bold text-warning">
                                {{ $analytics['sessions_by_category']->count() }}
                            </div>
                            <div class="small text-muted">Categories</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly Trends Chart
    const monthlyCtx = document.getElementById('monthlyTrendsChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: @json(collect($analytics['monthly_stats'])->pluck('month')),
            datasets: [{
                label: 'Sessions',
                data: @json(collect($analytics['monthly_stats'])->pluck('sessions')),
                borderColor: 'rgb(78, 115, 223)',
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                tension: 0.3,
                fill: true
            }, {
                label: 'Total Viewers',
                data: @json(collect($analytics['monthly_stats'])->pluck('viewers')),
                borderColor: 'rgb(28, 200, 138)',
                backgroundColor: 'rgba(28, 200, 138, 0.1)',
                tension: 0.3,
                fill: true,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Sessions'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Viewers'
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });

    // Category Performance Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const categoryData = @json($analytics['sessions_by_category']);
    
    new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(categoryData),
            datasets: [{
                data: Object.values(categoryData),
                backgroundColor: [
                    '#4e73df',
                    '#1cc88a',
                    '#36b9cc',
                    '#f6c23e',
                    '#e74a3b',
                    '#858796'
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                }
            }
        }
    });
});
</script>

<style>
@media print {
    .btn-group, .sidebar, .topbar {
        display: none !important;
    }
    
    .container-fluid {
        margin: 0;
        padding: 0;
    }
    
    .card {
        border: 1px solid #dee2e6 !important;
        box-shadow: none !important;
    }
}
</style>
@endsection 