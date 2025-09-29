@extends('layouts.admin')

@section('title', 'Influencer Analytics')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-chart-area fa-fw mr-2"></i>Influencer Analytics
        </h1>
        <div class="d-flex">
            <select class="form-control form-control-sm mr-2 bg-dark text-white border-secondary" id="timeRange">
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
        <!-- Total Influencers -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 bg-dark">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Influencers
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-white">
                                {{ number_format($data['total_influencers'] ?? 0) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- New Applications -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 bg-dark">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                New Applications
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-white">
                                {{ number_format($data['new_applications'] ?? 0) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Sales -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2 bg-dark">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Sales
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-white">
                                ₹{{ number_format($data['total_sales'] ?? 0, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-rupee-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Commission -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2 bg-dark">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Commission
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-white">
                                ₹{{ number_format($data['total_commission'] ?? 0, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percentage fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Daily Sales Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4 bg-dark">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                    <h6 class="m-0 font-weight-bold text-primary">Daily Sales Performance</h6>
                </div>
                <div class="card-body bg-dark">
                    <div class="chart-area">
                        <canvas id="dailySalesChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Performers Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4 bg-dark">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                    <h6 class="m-0 font-weight-bold text-primary">Top Performers</h6>
                </div>
                <div class="card-body bg-dark">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="topPerformersChart" height="200"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        @foreach($data['top_performers'] ?? [] as $index => $performer)
                            <div class="mb-1 text-white">
                                <i class="fas fa-circle" style="color: {{ ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'][$index % 5] }}"></i> 
                                {{ $performer->user->name ?? 'Unknown' }} - ₹{{ number_format($performer->total_sales ?? 0, 2) }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Performers Table -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4 bg-dark">
                <div class="card-header py-3 bg-dark">
                    <h6 class="m-0 font-weight-bold text-primary">Top Performing Influencers</h6>
                </div>
                <div class="card-body bg-dark">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover" id="performersTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Influencer</th>
                                    <th>Total Sales</th>
                                    <th>Commission Earned</th>
                                    <th>Commission Rate</th>
                                    <th>Sales Count</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data['top_performers'] ?? [] as $index => $performer)
                                <tr>
                                    <td>
                                        <span class="badge badge-{{ $index < 3 ? ['warning', 'info', 'secondary'][$index] : 'dark' }}">
                                            #{{ $index + 1 }}
                                        </span>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $performer->user->name ?? 'Unknown' }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $performer->user->email ?? 'N/A' }}</small>
                                        </div>
                                    </td>
                                    <td class="text-success">₹{{ number_format($performer->total_sales ?? 0, 2) }}</td>
                                    <td class="text-warning">₹{{ number_format($performer->total_commission ?? 0, 2) }}</td>
                                    <td>{{ $performer->commission_rate ?? 10 }}%</td>
                                    <td>{{ $performer->sales_count ?? 0 }}</td>
                                    <td>
                                        <a href="{{ route('admin.influencers.show', $performer) }}" 
                                           class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.influencers.sales.index', ['influencer_id' => $performer->id]) }}" 
                                           class="btn btn-success btn-sm">
                                            <i class="fas fa-chart-bar"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="fas fa-chart-bar fa-3x text-gray-300 mb-3"></i>
                                        <p class="text-gray-500">No performance data available.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
<style>
    .chart-area {
        position: relative;
        height: 300px;
    }
    .chart-pie {
        position: relative;
        height: 250px;
    }
    .dataTables_wrapper .dataTables_filter input {
        background-color: #2d2d2d !important;
        color: white !important;
        border: 1px solid #555 !important;
    }
    .dataTables_wrapper .dataTables_length select {
        background-color: #2d2d2d !important;
        color: white !important;
        border: 1px solid #555 !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#performersTable').DataTable({
        "order": [[ 2, "desc" ]],
        "pageLength": 10,
        "responsive": true
    });

    // Daily Sales Chart
    const dailyData = @json($data['daily_sales'] ?? []);
    if (dailyData.length > 0) {
        const ctxDaily = document.getElementById('dailySalesChart').getContext('2d');
        new Chart(ctxDaily, {
            type: 'line',
            data: {
                labels: dailyData.map(item => item.date),
                datasets: [{
                    label: 'Sales (₹)',
                    data: dailyData.map(item => item.total_amount),
                    borderColor: '#1cc88a',
                    backgroundColor: 'rgba(28, 200, 138, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }, {
                    label: 'Commission (₹)',
                    data: dailyData.map(item => item.total_commission),
                    borderColor: '#f6c23e',
                    backgroundColor: 'rgba(246, 194, 62, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: 'white'
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: 'white'
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: 'white'
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        }
                    }
                }
            }
        });
    }

    // Top Performers Chart
    const performersData = @json($data['top_performers'] ?? []);
    if (performersData.length > 0) {
        const ctxPerformers = document.getElementById('topPerformersChart').getContext('2d');
        new Chart(ctxPerformers, {
            type: 'doughnut',
            data: {
                labels: performersData.slice(0, 5).map(performer => performer.user ? performer.user.name : 'Unknown'),
                datasets: [{
                    data: performersData.slice(0, 5).map(performer => performer.total_sales || 0),
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
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: 'white'
                        }
                    }
                }
            }
        });
    }
});

function refreshData() {
    const timeRange = $('#timeRange').val();
    window.location.href = `{{ route('admin.influencers.analytics') }}?range=${timeRange}`;
}
</script>
@endpush
@endsection 