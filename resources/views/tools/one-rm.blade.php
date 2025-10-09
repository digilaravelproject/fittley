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
                            <label class="form-label">Weight Lifted</label>
                            <div class="input-group">
                                <input type="number" id="weight-lifted" class="form-control bg-dark text-white border-secondary" placeholder="Enter weight" min="1" step="0.5">
                                <select id="unit" class="form-select bg-dark text-white border-secondary" style="max-width:110px;">
                                    <option value="kg" selected>kg</option>
                                    <option value="lb">lb</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Reps Performed</label>
                            <input type="number" id="reps-performed" class="form-control bg-dark text-white border-secondary" placeholder="Enter reps" min="1" max="30" step="1">
                        </div>
                        
                        <button type="button" id="calculate" class="btn btn-warning w-100 fw-bold">
                            <i class="fas fa-calculator me-2"></i>
                            Calculate 1RM
                        </button>
                    </form>

                    <div id="result" class="mt-4 text-center fw-bold"></div>

                    <!-- Table 1: Percentage of 1RM → Weight → Repetitions (like screenshot) -->
                    <div id="table-wrap" class="mt-4" style="display:none;">
                        <div class="bg-dark rounded p-2">
                            <h6 class="mb-3">Your one rep max is 
                                <span id="one-rm-kg" class="text-warning">0</span> 
                                <span id="one-rm-unit" class="text-warning">kg</span>
                            </h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-dark table-striped align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Percentage of 1RM</th>
                                            <th>Lift Weight</th>
                                            <th>Repetitions of 1RM</th>
                                        </tr>
                                    </thead>
                                    <tbody id="percent-table-body"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /table 1 -->

                    <!-- Table 2: Repetition Percentages of 1RM -->
                    <div id="rep-table-wrap" class="mt-4" style="display:none;">
                        <div class="bg-dark rounded p-2">
                            <h6 class="mb-3">Repetition Percentages of 1RM</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-dark table-striped align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Repetitions</th>
                                            <th>Percentage of 1RM</th>
                                            <th>Lift Weight</th>
                                        </tr>
                                    </thead>
                                    <tbody id="rep-table-body"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /table 2 -->
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Make the unit dropdown visually match the text input */
    .input-group .form-control,
    .input-group .form-select {
        background-color: #1e1e1e !important;
        color: #fff !important;
        border: 1px solid #6c757d !important;
        box-shadow: none !important;
    }
    .input-group .form-control:focus,
    .input-group .form-select:focus {
        border-color: #ffc107 !important;
        outline: none !important;
        box-shadow: 0 0 0 0.15rem rgba(255,193,7,0.25) !important;
    }
    .form-select option {
        background-color: #1e1e1e;
        color: #fff;
    }
</style>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const calculateButton = document.getElementById("calculate");
    const weightInput = document.getElementById("weight-lifted");
    const repsInput = document.getElementById("reps-performed");
    const unitSelect = document.getElementById("unit");

    const resultDiv = document.getElementById("result");
    const tableWrap = document.getElementById("table-wrap");
    const repTableWrap = document.getElementById("rep-table-wrap");

    const oneRmValue = document.getElementById("one-rm-kg");
    const oneRmUnit = document.getElementById("one-rm-unit");
    const tbody = document.getElementById("percent-table-body");
    const repTbody = document.getElementById("rep-table-body");

    // Table 1 rows (fixed percentages like screenshot)
    const percentRows = [
        { p: 1.00, label: '100%' },
        { p: 0.95, label: '95%' },
        { p: 0.90, label: '90%' },
        { p: 0.85, label: '85%' },
        { p: 0.80, label: '80%' },
        { p: 0.75, label: '75%' },
        { p: 0.70, label: '70%' },
        { p: 0.65, label: '65%' },
        { p: 0.60, label: '60%' },
        { p: 0.55, label: '55%' },
        { p: 0.50, label: '50%' },
    ];

    // Screenshot-style “Repetitions of 1RM” column for Table 1
    const repsForPercent = {
        '100%': 1,
        '95%':  2,
        '90%':  4,
        '85%':  6,
        '80%':  8,
        '75%': 10,
        '70%': 12,
        '65%': 15,
        '60%': 20,
        '55%': 24,
        '50%': 30
    };

    // Anchor points for Table 2 (reps → percentage), chosen to align with Table 1 mapping
    // We’ll linearly interpolate between these anchors to fill reps 1–30.
    const repPercentAnchors = [
        { r: 1,  p: 1.00 },
        { r: 2,  p: 0.95 },
        { r: 4,  p: 0.90 },
        { r: 6,  p: 0.85 },
        { r: 8,  p: 0.80 },
        { r: 10, p: 0.75 },
        { r: 12, p: 0.70 },
        { r: 15, p: 0.65 },
        { r: 20, p: 0.60 },
        { r: 24, p: 0.55 },
        { r: 30, p: 0.50 },
    ];

    // Unit helpers
    const KG_PER_LB = 0.45359237;
    function toKg(value, unit) {
        return unit === 'lb' ? value * KG_PER_LB : value;
    }
    function fromKg(valueKg, unit) {
        return unit === 'lb' ? (valueKg / KG_PER_LB) : valueKg;
    }
    function roundByUnit(n, unit) {
        // kg: nearest 1; lb: nearest 5
        if (unit === 'lb') return Math.round(n / 5) * 5;
        return Math.round(n);
    }

    // Hybrid 1RM model (exact for 1; Epley for 2–10; Brzycki for >10)
    function estimateOneRMkg(inputWeight, reps, unit) {
        const wKg = toKg(inputWeight, unit);
        if (reps <= 1) return wKg;
        if (reps <= 10) return wKg * (1 + reps / 30);         // Epley
        if (reps >= 36) return wKg * 36 / (37 - 35.999);      // safety clamp
        return wKg * 36 / (37 - reps);                        // Brzycki
    }

    // Linear interpolation helper for Table 2
    function percentageForReps(reps) {
        // Find the two anchors surrounding 'reps'
        let prev = repPercentAnchors[0];
        for (let i = 1; i < repPercentAnchors.length; i++) {
            const curr = repPercentAnchors[i];
            if (reps === curr.r) return curr.p;
            if (reps < curr.r) {
                // interpolate between prev and curr
                const t = (reps - prev.r) / (curr.r - prev.r);
                return prev.p + t * (curr.p - prev.p);
            }
            prev = curr;
        }
        // beyond last anchor: extrapolate gently
        const last = repPercentAnchors[repPercentAnchors.length - 1];
        const beforeLast = repPercentAnchors[repPercentAnchors.length - 2];
        const slope = (last.p - beforeLast.p) / (last.r - beforeLast.r);
        return last.p + (reps - last.r) * slope;
    }

    function renderPercentTable(oneRmKg, unit) {
        tbody.innerHTML = "";
        percentRows.forEach(row => {
            const raw = fromKg(oneRmKg * row.p, unit);
            const rounded = roundByUnit(raw, unit);
            const reps = repsForPercent[row.label] ?? '';
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${row.label}</td>
                <td>${rounded} ${unit}</td>
                <td>${reps}</td>
            `;
            tbody.appendChild(tr);
        });
    }

    function renderRepsPercentTable(oneRmKg, unit) {
        repTbody.innerHTML = "";
        for (let r = 1; r <= 30; r++) {
            const pct = percentageForReps(r);     // 0–1
            const pctLabel = Math.round(pct * 100) + '%';
            const raw = fromKg(oneRmKg * pct, unit);
            const rounded = roundByUnit(raw, unit);
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${r}</td>
                <td>${pctLabel}</td>
                <td>${rounded} ${unit}</td>
            `;
            repTbody.appendChild(tr);
        }
    }

    function updateUI() {
        const unit = unitSelect.value;
        const weight = parseFloat(weightInput.value);
        const reps = parseInt(repsInput.value, 10);

        if (isNaN(weight) || isNaN(reps) || weight <= 0 || reps <= 0 || reps > 30) {
            resultDiv.innerHTML = "<p class='text-danger'>⚠️ Please enter valid numbers (reps 1–30).</p>";
            tableWrap.style.display = "none";
            repTableWrap.style.display = "none";
            return;
        }

        const oneRmKgVal = estimateOneRMkg(weight, reps, unit);
        const oneRmInUnit = fromKg(oneRmKgVal, unit);
        const displayHeadline = (Math.round(oneRmInUnit * 10) / 10).toFixed(1);

        resultDiv.innerHTML = `
            <div class="alert alert-success mt-3 shadow">
                <h5 class="alert-heading fw-bold">Estimated 1RM:</h5>
                <p class="mb-0 h3">${displayHeadline} ${unit}</p>
            </div>
        `;

        oneRmValue.textContent = displayHeadline;
        oneRmUnit.textContent = unit;

        renderPercentTable(oneRmKgVal, unit);        // Table 1
        renderRepsPercentTable(oneRmKgVal, unit);    // Table 2

        tableWrap.style.display = "block";
        repTableWrap.style.display = "block";
    }

    calculateButton.addEventListener("click", updateUI);

    // Recalc when unit toggles, if we already have a result
    unitSelect.addEventListener("change", function () {
        if (resultDiv.innerHTML.trim() !== "") updateUI();
    });
});
</script>
@endpush
