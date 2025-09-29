@extends('layouts.public')

@section('title', '1RM Calculator')

@section('content')
<div class="container py-4">
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-title mb-1">
                    <i class="fas fa-dumbbell me-2 text-warning"></i>
                    1RM Calculator
                </h1>
                <p class="page-subtitle text-white">
                    Estimate your one-rep max for any lift
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
                    <form id="oneRmForm">
                        <div class="mb-3">
                            <label class="form-label">Weight Lifted (kg)</label>
                            <input type="number" id="weight-lifted" class="form-control" placeholder="Enter weight">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Reps Performed</label>
                            <input type="number" id="reps-performed" class="form-control" placeholder="Enter reps">
                        </div>
                        
                        <button type="button" id="calculate" class="btn btn-warning w-100 fw-bold">
                            <i class="fas fa-calculator me-2"></i>
                            Calculate 1RM
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
    const calculateButton = document.getElementById("calculate");
    const weightInput = document.getElementById("weight-lifted");
    const repsInput = document.getElementById("reps-performed");
    const resultDiv = document.getElementById("result");

    calculateButton.addEventListener("click", function () {
        const weight = parseFloat(weightInput.value);
        const reps = parseInt(repsInput.value);

        if (isNaN(weight) || isNaN(reps) || weight <= 0 || reps <= 0) {
            resultDiv.innerHTML = "<p class='text-danger'>⚠️ Please enter valid numbers.</p>";
            return;
        }

        let estimated1RM;
        // Epley Formula: 1RM = Weight * (1 + Reps / 30)
        // This is a widely used and reliable formula
        estimated1RM = weight * (1 + reps / 30);

        resultDiv.innerHTML = `
            <div class="alert alert-success mt-3 shadow">
                <h5 class="alert-heading fw-bold">Estimated 1RM:</h5>
                <p class="mb-0 h3">${estimated1RM.toFixed(1)} kg</p>
            </div>
        `;
    });
});
</script>
@endpush