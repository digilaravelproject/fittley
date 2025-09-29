@extends('layouts.public')

@section('title', 'BMR Calculator')

@section('content')
<div class="container py-4">
    <!-- Page header (same style as tools index) -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-title mb-1">
                    <i class="fas fa-fire me-2 text-warning"></i>
                    BMR Calculator
                </h1>
                <p class="page-subtitle text-white">
                    Calculate your Basal Metabolic Rate to track calorie needs
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
                <div class="card-body">
                    <form id="bmrForm">
                        <div class="mb-3">
                            <label class="form-label">Age</label>
                            <input type="number" id="age" class="form-control" placeholder="Enter age">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Weight (kg)</label>
                            <input type="number" id="weight" class="form-control" placeholder="Enter weight">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Height (cm)</label>
                            <input type="number" id="height" class="form-control" placeholder="Enter height">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gender</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="gender" id="male" value="male" checked>
                                <label class="btn btn-outline-warning" for="male">Male</label>

                                <input type="radio" class="btn-check" name="gender" id="female" value="female">
                                <label class="btn btn-outline-warning" for="female">Female</label>
                            </div>
                        </div>

                        <button type="button" id="calculate" class="btn btn-warning w-100 fw-bold">
                            Calculate
                        </button>
                    </form>

                    <div id="result" class="mt-4 text-center fw-bold h5"></div>
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
        let age = parseInt(document.getElementById("age").value);
        let weight = parseFloat(document.getElementById("weight").value);
        let height = parseFloat(document.getElementById("height").value);
        let gender = document.querySelector('input[name="gender"]:checked').value;

        if (!age || !weight || !height) {
            document.getElementById("result").textContent = "⚠️ Please fill all fields.";
            return;
        }

        let bmr;
        if (gender === "male") {
            bmr = 10 * weight + 6.25 * height - 5 * age + 5;
        } else {
            bmr = 10 * weight + 6.25 * height - 5 * age - 161;
        }

        document.getElementById("result").textContent =
            `🔥 Your BMR is ${Math.round(bmr)} kcal/day`;
    });
});
</script>
@endpush
