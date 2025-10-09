

<?php $__env->startSection('title', 'Steps Tracker'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <!-- Page header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-title mb-1">
                    <i class="fas fa-shoe-prints me-2 text-warning"></i>
                    Steps Tracker
                </h1>
                <p class="page-subtitle text-white">
                    Track your daily, weekly and monthly steps progress
                </p>
            </div>
            <div class="col-auto">
                <a href="<?php echo e(route('tools.index')); ?>" class="btn btn-sm btn-outline-light">
                    ← Back to Tools
                </a>
            </div>
        </div>
    </div>

    <!-- Tracker Card -->
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card bg-dark text-white border-0 shadow">
                <div class="card-body text-center">
                    
                    <!-- Progress Circle -->
                    <div class="relative d-flex justify-content-center align-items-center mb-4">
                        <canvas id="stepsChart" width="220" height="220"></canvas>
                        <div class="position-absolute text-center">
                            <p class="h3 fw-bold mb-0" id="stepsCount">0</p>
                            <p class="small text-muted">Goal: <span id="goalSteps">300,000</span></p>
                        </div>
                    </div>

                    <!-- Period Buttons -->
                    <div class="btn-group mb-4" role="group">
                        <button type="button" class="btn btn-warning period-btn active" data-period="daily">Daily</button>
                        <button type="button" class="btn btn-outline-light period-btn" data-period="weekly">Weekly</button>
                        <button type="button" class="btn btn-outline-light period-btn" data-period="monthly">Monthly</button>
                    </div>

                    <!-- Stats -->
                    <div class="row text-center">
                        <div class="col bg-secondary bg-opacity-25 p-3 rounded me-2">
                            <p class="small text-muted mb-1">Today</p>
                            <p class="fw-bold h5 mb-0" id="todaySteps">0</p>
                        </div>
                        <div class="col bg-secondary bg-opacity-25 p-3 rounded me-2">
                            <p class="small text-muted mb-1">Week</p>
                            <p class="fw-bold h5 mb-0" id="weekSteps">0</p>
                        </div>
                        <div class="col bg-secondary bg-opacity-25 p-3 rounded">
                            <p class="small text-muted mb-1">Month</p>
                            <p class="fw-bold h5 mb-0" id="monthSteps">0</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Dummy Data (replace with backend if needed)
    let stepData = {
        daily: { steps: 6500, goal: 10000 },
        weekly: { steps: 45600, goal: 70000 },
        monthly: { steps: 198234, goal: 300000 }
    };

    let ctx = document.getElementById("stepsChart").getContext("2d");
    let stepsChart = new Chart(ctx, {
        type: "doughnut",
        data: {
            labels: ["Steps", "Remaining"],
            datasets: [{
                data: [0, 1],
                backgroundColor: ["#facc15", "#1f2937"],
                borderWidth: 0
            }]
        },
        options: {
            cutout: "80%",
            plugins: { legend: { display: false } }
        }
    });

    function updateSteps(period) {
        let current = stepData[period];
        let steps = current.steps;
        let goal = current.goal;
        let remaining = Math.max(goal - steps, 0);

        stepsChart.data.datasets[0].data = [steps, remaining];
        stepsChart.update();

        document.getElementById("stepsCount").textContent = steps.toLocaleString();
        document.getElementById("goalSteps").textContent = goal.toLocaleString();

        document.getElementById("todaySteps").textContent = stepData.daily.steps.toLocaleString();
        document.getElementById("weekSteps").textContent = stepData.weekly.steps.toLocaleString();
        document.getElementById("monthSteps").textContent = stepData.monthly.steps.toLocaleString();
    }

    document.querySelectorAll(".period-btn").forEach(btn => {
        btn.addEventListener("click", function () {
            document.querySelectorAll(".period-btn").forEach(b => b.classList.remove("btn-warning", "active"));
            document.querySelectorAll(".period-btn").forEach(b => b.classList.add("btn-outline-light"));
            this.classList.remove("btn-outline-light");
            this.classList.add("btn-warning", "active");

            updateSteps(this.dataset.period);
        });
    });

    updateSteps("monthly");
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/purple-gaur-534336.hostingersite.com/public_html/resources/views/tools/steps-tracker.blade.php ENDPATH**/ ?>