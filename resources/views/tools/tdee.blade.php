@extends('layouts.public')

@section('title', 'TDEE Calculator')

@section('content')
<div class="container py-4">
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-title mb-1">
                    <i class="fas fa-running me-2 text-warning"></i>
                    TDEE Calculator
                </h1>
                <p class="page-subtitle text-white">
                    Calculate your total daily calorie needs
                </p>
            </div>
            <div class="col-auto">
                <a href="{{ route('tools.index') }}" class="btn btn-sm btn-outline-light">
                    ← Back to Tools
                </a>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card bg-dark text-white border-0 shadow">
                <div class="card-body">
                    <form id="tdeeForm">
                        <div class="mb-3">
                            <label class="form-label">Enter Your BMR</label>
                            <input type="number" id="bmr" class="form-control" placeholder="e.g. 1650">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Select Activity Level</label>
                            <div class="list-group bg-dark">
                                <label class="list-group-item bg-secondary text-white border-0 mb-2 rounded activity-level" data-multiplier="1.2">
                                    <h5 class="mb-1"><i class="fas fa-couch me-2 text-primary"></i> Sedentary</h5>
                                    <p class="mb-1 text-white-50">Little or no exercise</p>
                                </label>
                                <label class="list-group-item bg-secondary text-white border-0 mb-2 rounded activity-level" data-multiplier="1.375">
                                    <h5 class="mb-1"><i class="fas fa-running me-2 text-success"></i> Lightly Active</h5>
                                    <p class="mb-1 text-white-50">Light exercise 1-3 days/week</p>
                                </label>
                                <label class="list-group-item bg-secondary text-white border-0 mb-2 rounded activity-level" data-multiplier="1.55">
                                    <h5 class="mb-1"><i class="fas fa-dumbbell me-2 text-warning"></i> Moderately Active</h5>
                                    <p class="mb-1 text-white-50">Moderate exercise 3-5 days/week</p>
                                </label>
                                <label class="list-group-item bg-secondary text-white border-0 mb-2 rounded activity-level" data-multiplier="1.725">
                                    <h5 class="mb-1"><i class="fas fa-walking me-2 text-danger"></i> Very Active</h5>
                                    <p class="mb-1 text-white-50">Hard exercise 6-7 days/week</p>
                                </label>
                                <label class="list-group-item bg-secondary text-white border-0 rounded activity-level" data-multiplier="1.9">
                                    <h5 class="mb-1"><i class="fas fa-biking me-2 text-info"></i> Super Active</h5>
                                    <p class="mb-1 text-white-50">Very hard exercise + physical job</p>
                                </label>
                            </div>
                        </div>
                    </form>

                    <div id="result" class="mt-4 text-center fw-bold"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const bmrInput = document.getElementById("bmr");
    const activityLevels = document.querySelectorAll(".activity-level");
    const resultDiv = document.getElementById("result");

    const updateResult = () => {
        const bmr = parseFloat(bmrInput.value);
        const selectedActivity = document.querySelector(".activity-level.active");

        if (isNaN(bmr) || bmr <= 0) {
            resultDiv.innerHTML = "<p class='text-danger'>⚠️ Please enter a valid BMR.</p>";
            return;
        }

        if (!selectedActivity) {
            resultDiv.innerHTML = "<p class='text-danger'>⚠️ Please select an activity level.</p>";
            return;
        }

        const multiplier = parseFloat(selectedActivity.dataset.multiplier);
        const tdee = bmr * multiplier;

        resultDiv.innerHTML = `
            <div class="alert alert-warning mt-3 shadow">
                <h5 class="alert-heading fw-bold">Your Estimated TDEE:</h5>
                <p class="mb-0 h3">${Math.round(tdee)} kcal/day</p>
            </div>
        `;
    };

    // Event listeners
    bmrInput.addEventListener("input", updateResult);

    activityLevels.forEach(item => {
        item.addEventListener("click", () => {
            // Remove active class from all
            activityLevels.forEach(el => el.classList.remove("active"));
            
            // Add active class to the clicked item
            item.classList.add("active");
            
            // Re-calculate and update the result
            updateResult();
        });
    });
});
</script>
<style>
/* Custom styling for active state */
.activity-level {
    cursor: pointer;
    transition: all 0.3s ease;
}
.activity-level.active {
    background-color: #ffc107 !important; /* Warning color */
    color: #212529 !important; /* Dark text */
    border: 2px solid #ffc107 !important;
}
.activity-level:hover {
    background-color: #ffc107 !important;
    color: #212529 !important;
}
</style>
@endpush