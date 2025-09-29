@extends('layouts.public')

@section('title', 'RPE Calculator')

@section('content')
<div class="container py-4">
    <!-- Page header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-title mb-1">
                    <i class="fas fa-dumbbell me-2 text-warning"></i>
                    RPE Calculator
                </h1>
                <p class="page-subtitle text-white">
                    Estimate training intensity based on RPE and reps performed
                </p>
            </div>
            <div class="col-auto">
                <a href="{{ route('tools.index') }}" class="btn btn-sm btn-outline-light">
                    ← Back to Tools
                </a>
            </div>
        </div>
    </div>

    <!-- Calculator Card -->
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card bg-dark text-white border-0 shadow">
                <div class="card-body text-center">

                    <!-- RPE Selection -->
                    <h5 class="mb-3">Select RPE</h5>
                    <div class="d-flex flex-wrap justify-content-center mb-4" id="rpeButtons">
                        @for ($i = 6; $i <= 10; $i++) <!-- usually RPE 6–10 are used -->
                            <button type="button" class="btn btn-outline-light m-1 rpe-btn" data-value="{{ $i }}">
                                {{ $i }}
                            </button>
                        @endfor
                    </div>

                    <!-- Reps Selection -->
                    <h5 class="mb-3">Select Reps</h5>
                    <div class="d-flex flex-wrap justify-content-center mb-4" id="repButtons">
                        @for ($i = 1; $i <= 12; $i++)
                            <button type="button" class="btn btn-outline-light m-1 rep-btn" data-value="{{ $i }}">
                                {{ $i }}
                            </button>
                        @endfor
                    </div>

                    <!-- Result -->
                    <div class="bg-secondary bg-opacity-25 p-4 rounded">
                        <p class="h4 fw-bold mb-1" id="intensity">-- % 1RM</p>
                        <p class="small text-white">Estimated Intensity</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    let selectedRPE = null;
    let selectedReps = null;

    // RPE Chart values (Mike Tuchscherer style)
    const rpeTable = {
        1: {10: 100, 9.5: 97.8, 9: 95.5, 8.5: 92.2, 8: 89.2, 7.5: 86.3, 7: 83.7, 6.5: 81.1, 6: 78.6},
        2: {10: 95.5, 9.5: 92.2, 9: 89.2, 8.5: 86.3, 8: 83.7, 7.5: 81.1, 7: 78.6, 6.5: 76.2, 6: 73.8},
        3: {10: 92.2, 9.5: 89.2, 9: 86.3, 8.5: 83.7, 8: 81.1, 7.5: 78.6, 7: 76.2, 6.5: 73.8, 6: 71.6},
        4: {10: 89.2, 9.5: 86.3, 9: 83.7, 8.5: 81.1, 8: 78.6, 7.5: 76.2, 7: 73.8, 6.5: 71.6, 6: 69.4},
        5: {10: 86.3, 9.5: 83.7, 9: 81.1, 8.5: 78.6, 8: 76.2, 7.5: 73.8, 7: 71.6, 6.5: 69.4, 6: 67.3},
        6: {10: 83.7, 9.5: 81.1, 9: 78.6, 8.5: 76.2, 8: 73.8, 7.5: 71.6, 7: 69.4, 6.5: 67.3, 6: 65.3},
        7: {10: 81.1, 9.5: 78.6, 9: 76.2, 8.5: 73.8, 8: 71.6, 7.5: 69.4, 7: 67.3, 6.5: 65.3, 6: 63.3},
        8: {10: 78.6, 9.5: 76.2, 9: 73.8, 8.5: 71.6, 8: 69.4, 7.5: 67.3, 7: 65.3, 6.5: 63.3, 6: 61.4},
        9: {10: 76.2, 9.5: 73.8, 9: 71.6, 8.5: 69.4, 8: 67.3, 7.5: 65.3, 7: 63.3, 6.5: 61.4, 6: 59.5},
        10: {10: 73.8, 9.5: 71.6, 9: 69.4, 8.5: 67.3, 8: 65.3, 7.5: 63.3, 7: 61.4, 6.5: 59.5, 6: 57.8},
        11: {10: 71.6, 9.5: 69.4, 9: 67.3, 8.5: 65.3, 8: 63.3, 7.5: 61.4, 7: 59.5, 6.5: 57.8, 6: 56.0},
        12: {10: 69.4, 9.5: 67.3, 9: 65.3, 8.5: 63.3, 8: 61.4, 7.5: 59.5, 7: 57.8, 6.5: 56.0, 6: 54.3},
    };

    function calculateIntensity(rpe, reps) {
        if (rpeTable[reps] && rpeTable[reps][rpe]) {
            return rpeTable[reps][rpe];
        }
        return null;
    }

    function updateResult() {
        if (selectedRPE && selectedReps) {
            let intensity = calculateIntensity(selectedRPE, selectedReps);
            document.getElementById("intensity").textContent = intensity 
                ? intensity + "% 1RM"
                : "-- % 1RM";
        }
    }

    // Handle RPE buttons
    document.querySelectorAll(".rpe-btn").forEach(btn => {
        btn.addEventListener("click", function () {
            document.querySelectorAll(".rpe-btn").forEach(b => b.classList.remove("btn-warning"));
            this.classList.add("btn-warning");
            selectedRPE = parseFloat(this.dataset.value);
            updateResult();
        });
    });

    // Handle Rep buttons
    document.querySelectorAll(".rep-btn").forEach(btn => {
        btn.addEventListener("click", function () {
            document.querySelectorAll(".rep-btn").forEach(b => b.classList.remove("btn-warning"));
            this.classList.add("btn-warning");
            selectedReps = parseInt(this.dataset.value);
            updateResult();
        });
    });
});
</script>
@endpush
