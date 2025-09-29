@extends('layouts.admin')

@section('title', 'Create Referral Code')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Create Referral Code</h1>
            <p class="mb-0">Create a new referral code for users</p>
        </div>
        <a href="{{ route('admin.subscriptions.referrals.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left"></i> Back to Referrals
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Referral Code Details</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.subscriptions.referrals.store') }}">
                        @csrf
                        
                        <div class="form-group">
                            <label for="user_id">User</label>
                            <select class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                <option value="">Choose a user...</option>
                                @foreach($users as $user)
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
                            <label for="code">Referral Code (Optional)</label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                   id="code" name="code" value="{{ old('code') }}" 
                                   placeholder="Leave empty to auto-generate">
                            <small class="form-text text-muted">If left empty, a unique code will be generated automatically</small>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="discount_type">Discount Type</label>
                            <select class="form-control @error('discount_type') is-invalid @enderror" id="discount_type" name="discount_type" required>
                                <option value="">Choose discount type...</option>
                                <option value="percentage" {{ old('discount_type') === 'percentage' ? 'selected' : '' }}>Percentage</option>
                                <option value="fixed" {{ old('discount_type') === 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                            </select>
                            @error('discount_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="discount_value">Discount Value</label>
                            <input type="number" class="form-control @error('discount_value') is-invalid @enderror" 
                                   id="discount_value" name="discount_value" 
                                   value="{{ old('discount_value') }}" 
                                   min="0" step="0.01" required>
                            <small class="form-text text-muted">For percentage: enter value without % (e.g., 20 for 20%). For fixed: enter amount in rupees.</small>
                            @error('discount_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="max_uses">Maximum Uses (Optional)</label>
                            <input type="number" class="form-control @error('max_uses') is-invalid @enderror" 
                                   id="max_uses" name="max_uses" 
                                   value="{{ old('max_uses') }}" 
                                   min="1" placeholder="Leave empty for unlimited">
                            @error('max_uses')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="expires_at">Expiry Date (Optional)</label>
                            <input type="date" class="form-control @error('expires_at') is-invalid @enderror" 
                                   id="expires_at" name="expires_at" 
                                   value="{{ old('expires_at') }}" 
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                            @error('expires_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" 
                                       {{ old('is_active', '1') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Referral Code
                            </button>
                            <a href="{{ route('admin.subscriptions.referrals.index') }}" class="btn btn-secondary ml-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection