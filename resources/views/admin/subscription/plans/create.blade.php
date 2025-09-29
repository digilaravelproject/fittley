@extends('layouts.admin')

@section('title', 'Create Subscription Plan')

@section('content')
<div class="container-fluid">
    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus fa-fw mr-2"></i>Create New Subscription Plan
        </h1>
        <a href="{{ route('admin.subscriptions.plans.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i>Back to Plans
        </a>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Create Plan Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4 bg-dark text-white">
                <div class="card-header py-3 bg-dark border-bottom border-secondary">
                    <h6 class="m-0 font-weight-bold text-primary">Plan Details</h6>
                </div>
                <div class="card-body bg-dark">
                    <form method="POST" action="{{ route('admin.subscriptions.plans.store') }}">
                        @csrf
                        
                        <!-- Basic Information -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label text-white">Plan Name <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control bg-dark text-white border-secondary @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       placeholder="e.g., Premium Monthly"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label text-white">Price (₹) <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control bg-dark text-white border-secondary @error('price') is-invalid @enderror" 
                                       id="price" 
                                       name="price" 
                                       value="{{ old('price', '0.00') }}" 
                                       step="0.01" 
                                       min="0"
                                       placeholder="299.00"
                                       required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label text-white">Description</label>
                            <textarea class="form-control bg-dark text-white border-secondary @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3"
                                      placeholder="Brief description of the plan benefits...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Billing Configuration -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="billing_cycle" class="form-label text-white">Billing Cycle <span class="text-danger">*</span></label>
                                <select class="form-control bg-dark text-white border-secondary @error('billing_cycle') is-invalid @enderror" 
                                        id="billing_cycle" 
                                        name="billing_cycle" 
                                        required>
                                    <option value="">Select billing cycle...</option>
                                    <option value="monthly" {{ old('billing_cycle') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="quarterly" {{ old('billing_cycle') == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                                    <option value="yearly" {{ old('billing_cycle') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                </select>
                                @error('billing_cycle')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="billing_cycle_count" class="form-label text-white">Billing Cycle Count <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control bg-dark text-white border-secondary @error('billing_cycle_count') is-invalid @enderror" 
                                       id="billing_cycle_count" 
                                       name="billing_cycle_count" 
                                       value="{{ old('billing_cycle_count', '1') }}" 
                                       min="1"
                                       required>
                                <small class="form-text text-muted">How many billing cycles (e.g., 3 for 3 months)</small>
                                @error('billing_cycle_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Trial and Settings -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="trial_days" class="form-label text-white">Trial Days <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control bg-dark text-white border-secondary @error('trial_days') is-invalid @enderror" 
                                       id="trial_days" 
                                       name="trial_days" 
                                       value="{{ old('trial_days', '0') }}" 
                                       min="0"
                                       required>
                                <small class="form-text text-muted">0 = No trial period</small>
                                @error('trial_days')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="sort_order" class="form-label text-white">Sort Order <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control bg-dark text-white border-secondary @error('sort_order') is-invalid @enderror" 
                                       id="sort_order" 
                                       name="sort_order" 
                                       value="{{ old('sort_order', '0') }}" 
                                       min="0"
                                       required>
                                <small class="form-text text-muted">Lower numbers appear first</small>
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Features -->
                        <div class="mb-3">
                            <label for="features" class="form-label text-white">Plan Features</label>
                            <div id="features-container">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control bg-dark text-white border-secondary" name="features[]" placeholder="Enter a feature">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-danger remove-feature" style="display: none;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="add-feature" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-plus mr-1"></i>Add Feature
                            </button>
                        </div>

                        <!-- Status Options -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" 
                                           class="custom-control-input" 
                                           id="is_popular" 
                                           name="is_popular" 
                                           value="1" 
                                           {{ old('is_popular') ? 'checked' : '' }}>
                                    <label class="custom-control-label text-white" for="is_popular">
                                        <span class="badge badge-warning"><i class="fas fa-star"></i></span>
                                        Mark as Popular Plan
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" 
                                           class="custom-control-input" 
                                           id="is_active" 
                                           name="is_active" 
                                           value="1" 
                                           {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="custom-control-label text-white" for="is_active">
                                        <span class="badge badge-success"><i class="fas fa-check"></i></span>
                                        Activate Plan
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="fas fa-save mr-1"></i>Create Plan
                            </button>
                            <a href="{{ route('admin.subscriptions.plans.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times mr-1"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- View Plan Link -->
        <div class="col-lg-4">
            <div class="card shadow mb-4 bg-dark text-white">
                <div class="card-header py-3 bg-dark border-bottom border-secondary">
                    <h6 class="m-0 font-weight-bold text-info">Plan Guidelines</h6>
                </div>
                <div class="card-body bg-dark">
                    <ul class="list-unstyled mb-0 text-muted">
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i>Choose descriptive plan names</li>
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i>Set competitive pricing</li>
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i>Add detailed features list</li>
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i>Consider trial periods</li>
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i>Mark your best plan as popular</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Add Feature functionality
    let featureIndex = 1;
    
    $('#add-feature').click(function() {
        const newFeature = `
            <div class="input-group mb-2" id="feature-${featureIndex}">
                <input type="text" class="form-control bg-dark text-white border-secondary" name="features[]" placeholder="Enter a feature">
                <div class="input-group-append">
                    <button type="button" class="btn btn-outline-danger remove-feature" onclick="removeFeature(${featureIndex})">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;
        $('#features-container').append(newFeature);
        featureIndex++;
        
        // Show remove button for existing features
        $('.remove-feature').show();
    });
    
    // Remove feature functionality
    $(document).on('click', '.remove-feature', function() {
        $(this).closest('.input-group').remove();
        
        // Hide remove button if only one feature left
        if ($('#features-container .input-group').length <= 1) {
            $('.remove-feature').hide();
        }
    });
    
    // Show success toast if session success exists
    @if(session('success'))
        toastr.success('{{ session('success') }}');
    @endif
});

function removeFeature(index) {
    $(`#feature-${index}`).remove();
    
    if ($('#features-container .input-group').length <= 1) {
        $('.remove-feature').hide();
    }
}
</script>
@endpush
@endsection
