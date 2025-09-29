@extends('layouts.public')

@section('title', 'Calorie & Macro Planner')

@section('content')
<div class="container py-4">
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-title mb-1">
                    <i class="fas fa-chart-line me-2 text-warning"></i>
                    Calorie & Macro Planner
                </h1>
                <p class="page-subtitle text-white">
                    Calculate your daily calorie and macronutrient needs
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
                    <form id="calorieMacroForm">
                        <div class="mb-3">
                            <label class="form-label">Goal</label>
                            <div class="btn-group d-flex" role="group">
                                <input type="radio" class="btn-check" name="goal" id="weight-loss" value="weight-loss" checked>
                                <label class="btn btn-outline-warning w-100" for="weight-loss">Weight Loss</label>
                                <input type="radio" class="btn-check" name="goal" id="maintenance" value="maintenance">
                                <label class="btn btn-outline-warning w-100" for="maintenance">Maintenance</label>
                                <input type="radio" class="btn-check" name="goal" id="muscle-gain" value="muscle-gain">
                                <label class="btn btn-outline-warning w-100" for="muscle-gain">Muscle Gain</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gender</label>
                            <div class="btn-group d-flex" role="group">
                                <input type="radio" class="btn-check" name="gender" id="male" value="male" checked>
                                <label class="btn btn-outline-warning w-100" for="male">Male</label>
                                <input type="radio" class="btn-check" name="gender" id="female" value="female">
                                <label class="btn btn-outline-warning w-100" for="female">Female</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Age</label>
                            <input type="number" id="age" class="form-control" placeholder="Enter age in years">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Height (cm)</label>
                            <input type="number" id="height" class="form-control" placeholder="Enter height">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Weight (kg)</label>
                            <input type="number" id="weight" class="form-control" placeholder="Enter weight">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Activity Level</label>
                            <div class="btn-group d-flex flex-wrap" role="group">
                                <input type="radio" class="btn-check" name="activity" id="sedentary" value="1.2" checked>
                                <label class="btn btn-outline-warning" for="sedentary">Sedentary</label>
                                <input type="radio" class="btn-check" name="activity" id="lightly-active" value="1.375">
                                <label class="btn btn-outline-warning" for="lightly-active">Lightly Active</label>
                                <input type="radio" class="btn-check" name="activity" id="moderately-active" value="1.55">
                                <label class="btn btn-outline-warning" for="moderately-active">Moderately Active</label>
                                <input type="radio" class="btn-check" name="activity" id="very-active" value="1.725">
                                <label class="btn btn-outline-warning" for="very-active">Very Active</label>
                                <input type="radio" class="btn-check" name="activity" id="super-active" value="1.9">
                                <label class="btn btn-outline-warning" for="super-active">Super Active</label>
                            </div>
                        </div>
                        
                        <button type="button" id="calculatePlan" class="btn btn-warning w-100 fw-bold">
                            Calculate Plan
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
    document.getElementById("calculatePlan").addEventListener("click", function () {
        // Get input values
        const age = parseFloat(document.getElementById("age").value);
        const weight = parseFloat(document.getElementById("weight").value);
        const height = parseFloat(document.getElementById("height").value);
        const gender = document.querySelector('input[name="gender"]:checked').value;
        const activityLevel = parseFloat(document.querySelector('input[name="activity"]:checked').value);
        const goal = document.querySelector('input[name="goal"]:checked').value;

        const resultDiv = document.getElementById("result");

        // Input validation
        if (!age || !weight || !height) {
            resultDiv.innerHTML = "<p class='text-danger'>⚠️ Please fill all fields.</p>";
            return;
        }

        // 1. Calculate Basal Metabolic Rate (BMR) using Mifflin-St Jeor equation
        let bmr;
        if (gender === "male") {
            bmr = (10 * weight) + (6.25 * height) - (5 * age) + 5;
        } else {
            bmr = (10 * weight) + (6.25 * height) - (5 * age) - 161;
        }

        // 2. Calculate Total Daily Energy Expenditure (TDEE)
        const tdee = bmr * activityLevel;

        // 3. Adjust TDEE based on the goal
        let targetCalories;
        let proteinRatio, carbRatio, fatRatio;

        switch (goal) {
            case 'weight-loss':
                targetCalories = tdee - 500; // Calorie deficit for weight loss
                proteinRatio = 0.4;
                carbRatio = 0.4;
                fatRatio = 0.2;
                break;
            case 'maintenance':
                targetCalories = tdee; // No change for maintenance
                proteinRatio = 0.3;
                carbRatio = 0.45;
                fatRatio = 0.25;
                break;
            case 'muscle-gain':
                targetCalories = tdee + 500; // Calorie surplus for muscle gain
                proteinRatio = 0.35;
                carbRatio = 0.45;
                fatRatio = 0.2;
                break;
            default:
                targetCalories = tdee;
        }

        // 4. Calculate Macronutrients
        const proteinGrams = Math.round((targetCalories * proteinRatio) / 4);
        const carbGrams = Math.round((targetCalories * carbRatio) / 4);
        const fatGrams = Math.round((targetCalories * fatRatio) / 9);

        // 5. Display results
        resultDiv.innerHTML = `
            <div class="alert alert-success mt-3 shadow">
                <h5 class="alert-heading fw-bold">Your Plan</h5>
                <p><strong>🔥 Daily Calories:</strong> ${Math.round(targetCalories)} kcal</p>
                <hr>
                <p class="mb-1"><strong>💪 Protein:</strong> ${proteinGrams}g</p>
                <p class="mb-1"><strong>🥔 Carbs:</strong> ${carbGrams}g</p>
                <p class="mb-0"><strong>🥑 Fat:</strong> ${fatGrams}g</p>
            </div>
        `;
    });
});
</script>
@endpush