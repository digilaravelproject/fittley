@extends('layouts.admin')

@section('title', 'Create Influencer')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Create New Influencer</h1>
            <p class="mb-0">Add a new influencer to the dynamic commission program</p>
        </div>
        <a href="{{ route('admin.influencers.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left"></i> Back to Influencers
        </a>
    </div>

    <div class="row">
        <!-- Form Column -->
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user-tie mr-2"></i>Influencer Details
                    </h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.influencers.store') }}">
                        @csrf
                        
                        <div class="form-group">
                            <label for="user_id">Select User</label>
                            <select class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                <option value="">Choose a user...</option>
                                @foreach($availableUsers as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="commission_tier">Starting Commission Tier</label>
                            <select class="form-control @error('commission_tier') is-invalid @enderror" 
                                    id="commission_tier" name="commission_tier" required>
                                <option value="">Select Starting Tier...</option>
                                @foreach($commissionTiers as $tier)
                                    <option value="{{ $tier->id }}" 
                                            data-rate="{{ $tier->commission_rate }}"
                                            data-bonus="{{ $tier->bonus_rate }}"
                                            {{ old('commission_tier') == $tier->id ? 'selected' : '' }}>
                                        {{ $tier->name }} ({{ $tier->commission_rate }}% + {{ $tier->bonus_rate }}% bonus = {{ $tier->total_rate }}%)
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> 
                                Tier automatically upgrades based on performance metrics
                            </small>
                            @error('commission_tier')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="manual_rate">Custom Commission Rate (Optional)</label>
                            <div class="input-group">
                                <input type="number" class="form-control @error('manual_rate') is-invalid @enderror" 
                                       id="manual_rate" name="manual_rate" 
                                       value="{{ old('manual_rate') }}" 
                                       min="5" max="50" step="0.1" 
                                       placeholder="Override tier rate">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                            <small class="form-text text-muted">
                                Leave empty to use dynamic tier rates. Override only for special cases.
                            </small>
                            @error('manual_rate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="bio">Bio (Optional)</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror" 
                                      id="bio" name="bio" rows="4" 
                                      placeholder="Brief bio about the influencer...">{{ old('bio') }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Influencer
                            </button>
                            <a href="{{ route('admin.influencers.index') }}" class="btn btn-secondary ml-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Commission Tiers Info Column -->
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-chart-line mr-2"></i>Dynamic Commission Tiers
                    </h6>
                </div>
                <div class="card-body">
                    @foreach($commissionTiers as $tier)
                        <div class="tier-card mb-3 p-3 rounded" style="background: linear-gradient(135deg, {{ $tier->name === 'Diamond' ? '#6f42c1' : ($tier->name === 'Platinum' ? '#6c757d' : ($tier->name === 'Gold' ? '#ffc107' : ($tier->name === 'Silver' ? '#6c757d' : '#dc3545'))) }}15, rgba(255,255,255,0.05)); border: 1px solid {{ $tier->name === 'Diamond' ? '#6f42c1' : ($tier->name === 'Platinum' ? '#6c757d' : ($tier->name === 'Gold' ? '#ffc107' : ($tier->name === 'Silver' ? '#6c757d' : '#dc3545'))) }}30;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="font-weight-bold mb-0">
                                    <i class="fas fa-crown mr-1" style="color: {{ $tier->name === 'Diamond' ? '#6f42c1' : ($tier->name === 'Platinum' ? '#6c757d' : ($tier->name === 'Gold' ? '#ffc107' : ($tier->name === 'Silver' ? '#6c757d' : '#dc3545'))) }};"></i>
                                    {{ $tier->name }}
                                </h6>
                                <span class="badge badge-success">{{ $tier->total_rate }}%</span>
                            </div>
                            
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted d-block">Base Rate</small>
                                    <span class="font-weight-bold">{{ $tier->commission_rate }}%</span>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Bonus Rate</small>
                                    <span class="font-weight-bold">{{ $tier->bonus_rate }}%</span>
                                </div>
                            </div>
                            
                            <hr class="my-2">
                            
                            <div class="requirements">
                                <small class="text-muted d-block mb-1">Requirements:</small>
                                <ul class="list-unstyled mb-2" style="font-size: 0.8rem;">
                                    <li><i class="fas fa-eye text-primary mr-1"></i> {{ number_format($tier->min_visits) }}+ visits</li>
                                    <li><i class="fas fa-handshake text-success mr-1"></i> {{ number_format($tier->min_conversions) }}+ conversions</li>
                                    @if($tier->min_revenue > 0)
                                        <li><i class="fas fa-dollar-sign text-warning mr-1"></i> ${{ number_format($tier->min_revenue) }}+ revenue</li>
                                    @endif
                                    @if($tier->min_active_days > 0)
                                        <li><i class="fas fa-calendar text-info mr-1"></i> {{ $tier->min_active_days }}+ active days</li>
                                    @endif
                                </ul>
                            </div>
                            
                            @if($tier->features)
                                <div class="features">
                                    <small class="text-muted d-block mb-1">Features:</small>
                                    <div style="font-size: 0.75rem;">
                                        @foreach(json_decode($tier->features, true) as $feature)
                                            <span class="badge badge-outline-primary mr-1 mb-1">{{ $feature }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                    
                    <div class="alert alert-info mt-3" style="font-size: 0.85rem;">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Auto Upgrade:</strong> Influencers automatically move to higher tiers when they meet the requirements. Manual rate override disables auto-upgrade.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tierSelect = document.getElementById('commission_tier');
    const manualRate = document.getElementById('manual_rate');
    
    tierSelect.addEventListener('change', function() {
        if (this.value && !manualRate.value) {
            const option = this.options[this.selectedIndex];
            const totalRate = parseFloat(option.dataset.rate) + parseFloat(option.dataset.bonus);
            
            // Show preview of selected tier rate
            const preview = document.createElement('div');
            preview.className = 'alert alert-success mt-2';
            preview.innerHTML = `<i class="fas fa-check mr-2"></i>Selected tier rate: ${totalRate}%`;
            
            // Remove existing preview
            const existingPreview = tierSelect.parentNode.querySelector('.alert');
            if (existingPreview) {
                existingPreview.remove();
            }
            
            tierSelect.parentNode.appendChild(preview);
        }
    });
    
    manualRate.addEventListener('input', function() {
        const existingPreview = tierSelect.parentNode.querySelector('.alert');
        if (existingPreview) {
            existingPreview.remove();
        }
        
        if (this.value) {
            const preview = document.createElement('div');
            preview.className = 'alert alert-warning mt-2';
            preview.innerHTML = `<i class="fas fa-exclamation-triangle mr-2"></i>Using custom rate: ${this.value}% (Auto-upgrade disabled)`;
            tierSelect.parentNode.appendChild(preview);
        }
    });
});
</script>
@endsection 