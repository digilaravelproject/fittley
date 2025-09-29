@extends('layouts.admin')

@section('title', 'Edit Influencer')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Edit Influencer</h1>
            <p class="mb-0">Update influencer details</p>
        </div>
        <a href="{{ route('admin.influencers.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left"></i> Back to Influencers
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Edit {{ $influencerProfile->user->name }}</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.influencers.update', $influencerProfile) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label>User</label>
                            <div class="form-control-plaintext">
                                <strong>{{ $influencerProfile->user->name }}</strong><br>
                                <small class="text-muted">{{ $influencerProfile->user->email }}</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="commission_rate">Commission Rate (%)</label>
                            <input type="number" class="form-control @error('commission_rate') is-invalid @enderror" 
                                   id="commission_rate" name="commission_rate" 
                                   value="{{ old('commission_rate', $influencerProfile->commission_rate) }}" 
                                   min="5" max="30" step="0.1" required>
                            <small class="form-text text-muted">Commission rate between 5% and 30%</small>
                            @error('commission_rate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="bio">Bio</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror" 
                                      id="bio" name="bio" rows="4" 
                                      placeholder="Brief bio about the influencer...">{{ old('bio', $influencerProfile->bio) }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Influencer
                            </button>
                            <a href="{{ route('admin.influencers.index') }}" class="btn btn-secondary ml-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 