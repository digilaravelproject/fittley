@extends('layouts.public')

@section('title', 'Progress Insights')

@section('content')
<div class="container py-4">
    <!-- Page header (matches your dashboard style) -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title mb-1">
                    <i class="fas fa-chart-line me-2 text-warning"></i>
                    Progress Insights
                </h1>
                <p class="page-subtitle text-white">Weekly / Monthly / Yearly body & PR trends</p>
            </div>
        </div>
    </div>

    <!-- Main card area (centered) -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card bg-dark border-0 mb-4" style="background: linear-gradient(180deg,#141414,#0f0f0f);">
                <div class="card-body">

                    <!-- Period selector (Bootstrap button group) -->
                    <div class="d-flex justify-content-center mb-3">
                        <div class="btn-group" role="group" aria-label="Period">
                            <button type="button" class="btn btn-outline-light period-btn active" data-period="Weekly">Weekly</button>
                            <button type="button" class="btn btn-outline-light period-btn" data-period="Monthly">Monthly</button>
                            <button type="button" class="btn btn-outline-light period-btn" data-period="Yearly">Yearly</button>
                        </div>
                    </div>

                    <!-- Nav / tabs-like row -->
                    <div class="d-flex justify-content-around mb-3">
                        <div class="nav-item active text-white">Body Weight</div>
                        <div class="nav-item text-muted">Workout PRs</div>
                        <div class="nav-item text-muted">Nutrition</div>
                        <div class="nav-item text-muted">Measurements</div>
                    </div>

                    <!-- Charts -->
                    <div class="row">
                        <div class="col-12 mb-3">
                            <h5 class="text-white">Body Weight</h5>
                            <div style="height:240px;">
                                <canvas id="bodyWeightChart"></canvas>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <h5 class="text-white">Workout PRs</h5>
                            <div style="height:240px;">
                                <canvas id="workoutPrsChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Latest Stats -->
                    <div class="mt-4">
                        <h5 class="text-white">Latest Stats</h5>
                        <div class="row g-3 mt-2">
                            <div class="col-6">
                                <div class="card bg-secondary text-white p-3">
                                    <small class="text-light">Weight</small>
                                    <div class="h5 fw-bold" id="statWeight">{{ $progressData['stats']['weight'] }}</div>
                                    <small class="text-success"><i class="fas fa-arrow-up"></i> 0.5 kg from last week</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card bg-secondary text-white p-3">
                                    <small class="text-light">Chest</small>
                                    <div class="h5 fw-bold" id="statChest">{{ $progressData['stats']['chest'] }}</div>
                                    <small class="text-success"><i class="fas fa-arrow-up"></i> 1 cm from last week</small>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="card bg-secondary text-white p-3">
                                    <small class="text-light">Squat PR</small>
                                    <div class="h5 fw-bold" id="statSquat">{{ $progressData['stats']['squat_pr'] }}</div>
                                    <small class="text-success"><i class="fas fa-arrow-up"></i> 3 kg from last month</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Rings -->
                    <div class="mt-4">
                        <h5 class="text-white">Progress Goals</h5>
                        <div class="d-flex justify-content-between mt-3">
                            <div class="text-center">
                                <svg width="72" height="72" viewBox="0 0 100 100">
                                    <circle cx="50" cy="50" r="40" stroke="#1f2937" stroke-width="8" fill="none" />
                                    <circle cx="50" cy="50" r="40" stroke="#f59e0b" stroke-width="8" fill="none"
                                            stroke-dasharray="251.2" stroke-dashoffset="50.24" stroke-linecap="round"/>
                                </svg>
                                <div class="mt-1 text-white fw-bold">70%</div>
                                <small class="text-muted">Weight Goal</small>
                            </div>

                            <div class="text-center">
                                <svg width="72" height="72" viewBox="0 0 100 100">
                                    <circle cx="50" cy="50" r="40" stroke="#1f2937" stroke-width="8" fill="none" />
                                    <circle cx="50" cy="50" r="40" stroke="#10b981" stroke-width="8" fill="none"
                                            stroke-dasharray="251.2" stroke-dashoffset="125.6" stroke-linecap="round"/>
                                </svg>
                                <div class="mt-1 text-white fw-bold">50%</div>
                                <small class="text-muted">Strength</small>
                            </div>

                            <div class="text-center">
                                <svg width="72" height="72" viewBox="0 0 100 100">
                                    <circle cx="50" cy="50" r="40" stroke="#1f2937" stroke-width="8" fill="none" />
                                    <circle cx="50" cy="50" r="40" stroke="#3b82f6" stroke-width="8" fill="none"
                                            stroke-dasharray="251.2" stroke-dashoffset="75.36" stroke-linecap="round"/>
                                </svg>
                                <div class="mt-1 text-white fw-bold">80%</div>
                                <small class="text-muted">Consistency</small>
                            </div>
                        </div>
                    </div>

                </div> <!-- card-body -->
            </div> <!-- card -->
        </div> <!-- col -->
    </div> <!-- row -->
</div>
@endsection

@push('scripts')
<!-- Chart.js (only) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // initial data from backend (controller must pass $progressData)
    const initialBodyLabels = @json($progressData['charts']['body_weight']['labels']);
    const initialBodyData   = @json($progressData['charts']['body_weight']['data']);
    const initialPrLabels   = @json($progressData['charts']['workout_prs']['labels']);
    const initialPrData     = @json($progressData['charts']['workout_prs']['data']);

    // Create charts
    const bodyCtx = document.getElementById('bodyWeightChart').getContext('2d');
    const bodyWeightChart = new Chart(bodyCtx, {
        type: 'line',
        data: {
            labels: initialBodyLabels,
            datasets: [{
                label: 'Body Weight (kg)',
                data: initialBodyData,
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59,130,246,0.08)',
                tension: 0.35,
                fill: true,
                pointRadius: 3
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    const prCtx = document.getElementById('workoutPrsChart').getContext('2d');
    const workoutPrsChart = new Chart(prCtx, {
        type: 'bar',
        data: {
            labels: initialPrLabels,
            datasets: [{
                label: 'Weight (kg)',
                data: initialPrData,
                backgroundColor: ['#ef4444','#3b82f6','#f59e0b'],
                borderRadius: 6
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // Update helper
    function updateFromResponse(data) {
        // charts
        bodyWeightChart.data.labels = data.charts.body_weight.labels;
        bodyWeightChart.data.datasets[0].data = data.charts.body_weight.data;
        bodyWeightChart.update();

        workoutPrsChart.data.labels = data.charts.workout_prs.labels;
        workoutPrsChart.data.datasets[0].data = data.charts.workout_prs.data;
        workoutPrsChart.update();

        // stats
        document.getElementById('statWeight').textContent = data.stats.weight;
        document.getElementById('statChest').textContent = data.stats.chest;
        document.getElementById('statSquat').textContent = data.stats.squat_pr;
    }

    // Period buttons
    document.querySelectorAll('.period-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.period-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const period = this.dataset.period || this.textContent.trim();

            fetch(`{{ route('progress-insights') }}?period=${encodeURIComponent(period)}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(json => {
                if (json && json.charts && json.stats) {
                    updateFromResponse(json);
                } else {
                    console.warn('Invalid response from progress-insights:', json);
                }
            })
            .catch(err => console.error('Fetch error', err));
        });
    });
});
</script>
@endpush
