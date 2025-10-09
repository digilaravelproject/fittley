

<?php $__env->startSection('title', 'Protein Requirement'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-title mb-1">
                    <i class="fas fa-dumbbell me-2 text-warning"></i>
                    Protein Requirement
                </h1>
                <p class="page-subtitle text-white">
                    Calculate your daily protein needs
                </p>
            </div>
            <div class="col-auto">
                <a href="<?php echo e(route('tools.index')); ?>" class="btn btn-sm btn-outline-light">
                    ← Back to Tools
                </a>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card bg-dark text-white border-0 shadow">
                <div class="card-body">
                    <form id="proteinForm">
                        <div class="mb-3">
                            <label class="form-label">Weight (kg)</label>
                            <input type="number" id="weight" class="form-control form-control-lg" placeholder="Enter weight">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Activity Level</label>
                            <select id="activity" class="form-select form-select-lg">
                                <option value="1.2" selected>Sedentary</option>
                                <option value="1.375">Lightly Active</option>
                                <option value="1.55">Moderately Active</option>
                                <option value="1.725">Very Active</option>
                                <option value="1.9">Super Active</option>
                            </select>
                        </div>
                        
                        <div id="result" class="text-center mt-5">
                            <h5 class="text-white-50">Your Daily Protein Need:</h5>
                            <h2 class="text-warning fw-bold" id="protein-grams">0.0 grams</h2>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const weightInput = document.getElementById("weight");
    const activitySelect = document.getElementById("activity");
    const proteinGramsElement = document.getElementById("protein-grams");

    // Function to calculate and update protein
    const calculateProtein = () => {
        let weight = parseFloat(weightInput.value);
        let activityMultiplier = parseFloat(activitySelect.value);
        let proteinPerKg;

        if (isNaN(weight) || weight <= 0) {
            proteinGramsElement.textContent = "0.0 grams";
            return;
        }

        // Determine protein per kg based on activity level
        if (activityMultiplier === 1.2) {
            proteinPerKg = 0.8; // Sedentary
        } else if (activityMultiplier === 1.375) {
            proteinPerKg = 1.0; // Lightly Active
        } else if (activityMultiplier === 1.55) {
            proteinPerKg = 1.2; // Moderately Active
        } else if (activityMultiplier === 1.725) {
            proteinPerKg = 1.5; // Very Active
        } else {
            proteinPerKg = 1.8; // Super Active
        }
        
        let proteinNeeded = weight * proteinPerKg;
        proteinGramsElement.textContent = `${proteinNeeded.toFixed(1)} grams`;
    };

    // Event listeners for real-time updates
    weightInput.addEventListener("input", calculateProtein);
    activitySelect.addEventListener("change", calculateProtein);
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/fittelly.com/public_html/resources/views/tools/protein-requirement.blade.php ENDPATH**/ ?>