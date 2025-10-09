

<?php $__env->startSection('title', 'Body Fat Estimator'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <!-- Page header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-title mb-1">
                    <i class="fas fa-user me-2 text-warning"></i>
                    Body Fat Estimator
                </h1>
                <p class="page-subtitle text-white">
                    Estimate your body fat percentage using the US Navy method
                </p>
            </div>
            <div class="col-auto">
                <a href="<?php echo e(route('tools.index')); ?>" class="btn btn-sm btn-outline-light">
                    ← Back to Tools
                </a>
            </div>
        </div>
    </div>

    <!-- Estimator Card -->
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card bg-dark text-white border-0 shadow">
                <div class="card-body">

                    <!-- Gender -->
                    <div class="mb-3 text-center">
                        <label class="d-block mb-2">Gender</label>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-warning gender-btn active" data-value="male">Male</button>
                            <button type="button" class="btn btn-outline-light gender-btn" data-value="female">Female</button>
                        </div>
                    </div>

                    <!-- Inputs -->
                    <div class="mb-3">
                        <label class="form-label">Height (cm)</label>
                        <input type="number" step="0.1" id="height" class="form-control bg-secondary text-white border-0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Weight (kg)</label>
                        <input type="number" step="0.1" id="weight" class="form-control bg-secondary text-white border-0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Waist (cm)</label>
                        <input type="number" step="0.1" id="waist" class="form-control bg-secondary text-white border-0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Neck (cm)</label>
                        <input type="number" step="0.1" id="neck" class="form-control bg-secondary text-white border-0">
                    </div>
                    <div class="mb-3 female-input d-none">
                        <label class="form-label">Hip (cm)</label>
                        <input type="number" step="0.1" id="hip" class="form-control bg-secondary text-white border-0">
                    </div>

                    <!-- Estimate Button -->
                    <div class="text-center">
                        <button type="button" id="estimateBtn" class="btn btn-warning w-100 fw-bold">
                            Estimate
                        </button>
                    </div>

                    <!-- Result Modal -->
                    <div class="mt-4 text-center d-none" id="resultBox">
                        <h5>Estimated Body Fat</h5>
                        <p class="h3 fw-bold text-warning mb-1" id="bodyFatResult">-- %</p>
                        <p class="small" id="categoryText"></p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    let gender = "male";

    // Switch gender
    document.querySelectorAll(".gender-btn").forEach(btn => {
        btn.addEventListener("click", function () {
            document.querySelectorAll(".gender-btn").forEach(b => {
                b.classList.remove("btn-warning", "active");
                b.classList.add("btn-outline-light");
            });
            this.classList.add("btn-warning", "active");
            gender = this.dataset.value;

            // Show hip field for females
            document.querySelector(".female-input").classList.toggle("d-none", gender === "male");
        });
    });

    // Categories based on body fat %
    function getCategory(gender, bf) {
        if (gender === "male") {
            if (bf < 6) return "Essential Fat";
            if (bf <= 13) return "Athlete";
            if (bf <= 17) return "Fitness";
            if (bf <= 24) return "Average";
            return "High";
        } else {
            if (bf < 14) return "Essential Fat";
            if (bf <= 20) return "Athlete";
            if (bf <= 24) return "Fitness";
            if (bf <= 31) return "Average";
            return "High";
        }
    }

    // Estimate calculation
    document.getElementById("estimateBtn").addEventListener("click", function () {
        let height = parseFloat(document.getElementById("height").value);
        let waist = parseFloat(document.getElementById("waist").value);
        let neck = parseFloat(document.getElementById("neck").value);
        let hip = gender === "female" ? parseFloat(document.getElementById("hip").value) : 0;

        if (!height || !waist || !neck || (gender === "female" && !hip)) {
            alert("Please fill all required fields.");
            return;
        }

        let bodyFat = 0;
        if (gender === "male") {
            bodyFat = 86.010 * Math.log10(waist - neck) 
                    - 70.041 * Math.log10(height) 
                    + 36.76;
        } else {
            bodyFat = 163.205 * Math.log10(waist + hip - neck) 
                    - 97.684 * Math.log10(height) 
                    - 78.387;
        }

        bodyFat = bodyFat.toFixed(2);

        document.getElementById("bodyFatResult").textContent = bodyFat + "%";
        document.getElementById("categoryText").textContent = getCategory(gender, bodyFat);
        document.getElementById("resultBox").classList.remove("d-none");
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/fittelly.com/public_html/resources/views/tools/body-fat.blade.php ENDPATH**/ ?>