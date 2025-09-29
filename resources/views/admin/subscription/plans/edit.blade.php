@extends('layouts.admin')

@section('title', 'Edit Subscription Plan')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit fa-fw mr-2"></i>Edit Subscription Plan: {{ $plan->name }}
        </h1>
        <div>
            <a href="{{ route('admin.subscriptions.plans.show', $plan) }}" class="btn btn-info btn-sm shadow-sm mr-2">
                <i class="fas fa-eye fa-sm text-white-50 mr-1"></i>View Details
            </a>
            <a href="{{ route('admin.subscriptions.plans.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i>Back to Plans
            </a>
        </div>
    </div>

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

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Plan Details</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.subscriptions.plans.update', $plan) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Plan Name <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $plan->name) }}" 
                                       placeholder="e.g., Premium Monthly"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Price (₹) <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control @error('price') is-invalid @enderror" 
                                       id="price" 
                                       name="price" 
                                       value="{{ old('price', $plan->price) }}" 
                                       step="0.01" 
                                       min="0"
                                       placeholder="299.00"
                                       required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3"
                                      placeholder="Brief description of the plan benefits...">{{ old('description', $plan->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="billing_cycle" class="form-label">Billing Cycle <span class="text-danger">*</span></label>
                                <select class="form-control @error('billing_cycle') is-invalid @enderror" 
                                        id="billing_cycle" 
                                        name="billing_cycle" 
                                        required>
                                    <option value="">Select billing cycle...</option>
                                    <option value="monthly" {{ old('billing_cycle', $plan->billing_cycle) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="quarterly" {{ old('billing_cycle', $plan->billing_cycle) == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                                    <option value="yearly" {{ old('billing_cycle', $plan->billing_cycle) == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                </select>
                                @error('billing_cycle')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="billing_cycle_count" class="form-label">Billing Cycle Count <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control @error('billing_cycle_count') is-invalid @enderror" 
                                       id="billing_cycle_count" 
                                       name="billing_cycle_count" 
                                       value="{{ old('billing_cycle_count', $plan->billing_cycle_count) }}" 
                                       min="1"
                                       required>
                                <small class="form-text text-muted">How many billing cycles (e.g., 3 for 3 months)</small>
                                @error('billing_cycle_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="trial_days" class="form-label">Trial Days <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control @error('trial_days') is-invalid @enderror" 
                                       id="trial_days" 
                                       name="trial_days" 
                                       value="{{ old('trial_days', $plan->trial_days) }}" 
                                       min="0"
                                       required>
                                <small class="form-text text-muted">0 = No trial period</small>
                                @error('trial_days')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="sort_order" class="form-label">Sort Order <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control @error('sort_order') is-invalid @enderror" 
                                       id="sort_order" 
                                       name="sort_order" 
                                       value="{{ old('sort_order', $plan->sort_order) }}" 
                                       min="0"
                                       required>
                                <small class="form-text text-muted">Lower numbers appear first</small>
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="features" class="form-label">Plan Features</label>
                            <div id="features-container">
                                @if(is_array($plan->features) && count($plan->features) > 0)
                                    @foreach($plan->features as $feature)
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="features[]" value="{{ $feature }}" placeholder="Enter a feature">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-danger remove-feature">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="features[]" placeholder="Enter a feature">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-danger remove-feature" style="display: none;">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <button type="button" id="add-feature" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-plus mr-1"></i>Add Feature
                            </button>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" 
                                           class="custom-control-input" 
                                           id="is_popular" 
                                           name="is_popular" 
                                           value="1" 
                                           {{ old('is_popular', $plan->is_popular) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_popular">
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
                                           {{ old('is_active', $plan->is_active) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">
                                        <span class="badge badge-success"><i class="fas fa-check"></i></span>
                                        Plan Active
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.subscriptions.plans.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i>Update Plan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Important Notes
                    </h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted">
                        <strong>Active Subscribers:</strong> {{ $plan->active_subscriptions_count ?? 0 }}<br>
                        <strong>Total Subscribers:</strong> {{ $plan->subscriptions_count ?? 0 }}
                    </p>
                    
                    @if($plan->active_subscriptions_count > 0)
                        <div class="alert alert-warning" role="alert">
                            <small>
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                This plan has active subscribers. Changes to pricing or billing cycles may affect existing subscriptions.
                            </small>
                        </div>
                    @endif
                    
                    <p class="small">
                        <strong>Created:</strong> {{ $plan->created_at->format('M d, Y') }}<br>
                        <strong>Last Updated:</strong> {{ $plan->updated_at->format('M d, Y') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Add Feature functionality
    $('#add-feature').click(function() {
        const container = $('#features-container');
        const newFeature = `
            <div class="input-group mb-2">
                <input type="text" class="form-control" name="features[]" placeholder="Enter a feature">
                <div class="input-group-append">
                    <button type="button" class="btn btn-outline-danger remove-feature">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;
        container.append(newFeature);
        updateRemoveButtons();
    });
    
    // Remove feature
    $(document).on('click', '.remove-feature', function() {
        $(this).closest('.input-group').remove();
        updateRemoveButtons();
    });
    
    function updateRemoveButtons() {
        const buttons = $('#features-container .remove-feature');
        if (buttons.length <= 1) {
            buttons.hide();
        } else {
            buttons.show();
        }
    }
    
    // Initialize remove buttons visibility
    updateRemoveButtons();
});
</script>
@endpush
@endsection
