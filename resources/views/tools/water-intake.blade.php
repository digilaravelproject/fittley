@extends('layouts.public')

@section('title', 'Water Intake Calculator')

@section('content')
<div class="container py-4">
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-title mb-1">
                    <i class="fas fa-tint me-2 text-warning"></i>
                    Water Intake Calculator
                </h1>
                <p class="page-subtitle text-white">
                    Calculate your recommended daily water intake
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
                    <form id="waterIntakeForm">
                        <div class="mb-3">
                            <label class="form-label">Weight (kg)</label>
                            <input type="number" id="weight" class="form-control" placeholder="Enter weight">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Climate</label>
                            <div class="btn-group d-flex" role="group">
                                <input type="radio" class="btn-check" name="climate" id="cool" value="cool" checked>
                                <label class="btn btn-outline-warning w-100" for="cool">Cool</label>
                                <input type="radio" class="btn-check" name="climate" id="moderate" value="moderate">
                                <label class="btn btn-outline-warning w-100" for="moderate">Moderate</label>
                                <input type="radio" class="btn-check" name="climate" id="hot" value="hot">
                                <label class="btn btn-outline-warning w-100" for="hot">Hot</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Activity Level</label>
                            <div class="btn-group d-flex flex-wrap" role="group">
                                <input type="radio" class="btn-check" name="activity" id="sedentary" value="sedentary" checked>
                                <label class="btn btn-outline-warning" for="sedentary">Sedentary</label>
                                <input type="radio" class="btn-check" name="activity" id="lightly-active" value="lightly-active">
                                <label class="btn btn-outline-warning" for="lightly-active">Lightly Active</label>
                                <input type="radio" class="btn-check" name="activity" id="moderately-active" value="moderately-active">
                                <label class="btn btn-outline-warning" for="moderately-active">Moderately Active</label>
                                <input type="radio" class="btn-check" name="activity" id="very-active" value="very-active">
                                <label class="btn btn-outline-warning" for="very-active">Very Active</label>
                                <input type="radio" class="btn-check" name="activity" id="super-active" value="super-active">
                                <label class="btn btn-outline-warning" for="super-active">Super Active</label>
                            </div>
                        </div>
                        
                        <button type="button" id="calculate" class="btn btn-warning w-100 fw-bold">
                            Calculate
                        </button>
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
    document.getElementById("calculate").addEventListener("click", function () {
        const weight = parseFloat(document.getElementById("weight").value);
        const climate = document.querySelector('input[name="climate"]:checked').value;
        const activity = document.querySelector('input[name="activity"]:checked').value;

        const resultDiv = document.getElementById("result");

        if (isNaN(weight) || weight <= 0) {
            resultDiv.innerHTML = "<p class='text-danger'>⚠️ Please enter a valid weight.</p>";
            return;
        }

        // Base water intake (ml) per kg of body weight
        const baseIntake = 35; // ml per kg

        let waterIntake = weight * baseIntake;

        // Adjust for climate
        if (climate === "hot") {
            waterIntake += 500; // Add 500ml for hot climate
        } else if (climate === "cool") {
            // No significant adjustment, or a small reduction which we'll keep simple for now
        }

        // Adjust for activity level
        switch (activity) {
            case 'sedentary':
                // No additional water needed
                break;
            case 'lightly-active':
                waterIntake += 250; // Add 250ml
                break;
            case 'moderately-active':
                waterIntake += 500; // Add 500ml
                break;
            case 'very-active':
                waterIntake += 750; // Add 750ml
                break;
            case 'super-active':
                waterIntake += 1000; // Add 1000ml
                break;
        }

        const waterLiters = (waterIntake / 1000).toFixed(1);
        
        resultDiv.innerHTML = `
            <div class="alert alert-info mt-3 shadow">
                <h5 class="alert-heading fw-bold">Daily Water Need:</h5>
                <p class="mb-0 h3">${waterLiters} Liters</p>
                <p class="text-white-50 mt-1">(${Math.round(waterIntake)} ml)</p>
            </div>
        `;
    });
});
</script>
@endpush