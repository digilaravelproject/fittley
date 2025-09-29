@extends('layouts.admin')

@section('title', 'Edit Badge')

@section('content')
<style>
    .title-clr {
        color: #000;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="page-header mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="page-title">
                            <i class="fas fa-medal text-warning me-2"></i>
                            Edit Badge
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.community.dashboard') }}">Community</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.community.badges.index') }}">Badges</a></li>
                                <li class="breadcrumb-item active">Edit</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-actions">
                        <a href="{{ route('admin.community.badges.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to Badges
                        </a>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Edit Form -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Badge Details</h5>
                        </div>
                        <div class="card-body">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('admin.community.badges.update', $badge->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Badge Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label title-clr">Badge Name <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="name" 
                                           id="name" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name', $badge->name) }}" 
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="mb-3">
                                    <label for="description" class="form-label title-clr">Description <span class="text-danger">*</span></label>
                                    <textarea name="description" 
                                              id="description" 
                                              rows="4"
                                              class="form-control @error('description') is-invalid @enderror"
                                              required>{{ old('description', $badge->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Category -->
                                <div class="mb-3">
                                    <label for="category" class="form-label title-clr">Category <span class="text-danger">*</span></label>
                                    <select name="category" id="category" 
                                            class="form-select @error('category') is-invalid @enderror" required>
                                        <option value="">Select category</option>
                                        <option value="community" {{ old('category', $badge->category) == 'community' ? 'selected' : '' }}>Community</option>
                                        <option value="fitness" {{ old('category', $badge->category) == 'fitness' ? 'selected' : '' }}>Fitness</option>
                                        <option value="milestone" {{ old('category', $badge->category) == 'milestone' ? 'selected' : '' }}>Milestone</option>
                                        <option value="special" {{ old('category', $badge->category) == 'special' ? 'selected' : '' }}>Special</option>
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Type -->
                                <div class="mb-3">
                                    <label for="type" class="form-label title-clr">Type <span class="text-danger">*</span></label>
                                    <select name="type" id="type" 
                                            class="form-select @error('type') is-invalid @enderror" required>
                                        <option value="">Select type</option>
                                        <option value="post_count" {{ old('type', $badge->type) == 'post_count' ? 'selected' : '' }}>Post Count</option>
                                        <option value="like_count" {{ old('type', $badge->type) == 'like_count' ? 'selected' : '' }}>Like Count</option>
                                        <option value="friend_count" {{ old('type', $badge->type) == 'friend_count' ? 'selected' : '' }}>Friend Count</option>
                                        <option value="comment_count" {{ old('type', $badge->type) == 'comment_count' ? 'selected' : '' }}>Comment Count</option>
                                        <option value="streak_days" {{ old('type', $badge->type) == 'streak_days' ? 'selected' : '' }}>Streak Days</option>
                                        <option value="group_member" {{ old('type', $badge->type) == 'group_member' ? 'selected' : '' }}>Group Member</option>
                                        <option value="first_action" {{ old('type', $badge->type) == 'first_action' ? 'selected' : '' }}>First Action</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Criteria -->
                                <div class="mb-3">
                                    <label for="criteria" class="form-label title-clr">Criteria <span class="text-danger">*</span></label>
                                    @php
                                        $criteriaValue = '';
                                        
                                        // Check old input first (if coming from validation error)
                                        if (old('criteria')) {
                                            $criteriaValue = old('criteria');
                                        } 
                                        // Fallback to badge criteria as JSON
                                        elseif (!empty($badge->criteria)) {
                                            $criteriaValue = json_encode($badge->criteria);
                                        }
                                    @endphp
                                    <input type="text" 
                                           name="criteria" 
                                           id="criteria" 
                                           class="form-control @error('criteria') is-invalid @enderror" 
                                           value="{{ $criteriaValue }}" 
                                           placeholder="Enter criteria as JSON (e.g. {&quot;likes_received&quot;:10,&quot;days_active&quot;:30})">
                                    <div class="form-text">Enter badge conditions</div>
                                    @error('criteria')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Points -->
                                <div class="mb-3">
                                    <label for="points" class="form-label title-clr">Points <span class="text-danger">*</span></label>
                                    <input type="number" 
                                           name="points" 
                                           id="points" 
                                           class="form-control @error('points') is-invalid @enderror" 
                                           value="{{ old('points', $badge->points) }}" 
                                           min="1" max="1000"
                                           required>
                                    @error('points')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Rarity -->
                                <div class="mb-3">
                                    <label for="rarity" class="form-label title-clr">Rarity <span class="text-danger">*</span></label>
                                    <select name="rarity" id="rarity" 
                                            class="form-select @error('rarity') is-invalid @enderror" required>
                                        <option value="">Select rarity</option>
                                        <option value="common" {{ old('rarity', $badge->rarity) == 'common' ? 'selected' : '' }}>Common</option>
                                        <option value="uncommon" {{ old('rarity', $badge->rarity) == 'uncommon' ? 'selected' : '' }}>Uncommon</option>
                                        <option value="rare" {{ old('rarity', $badge->rarity) == 'rare' ? 'selected' : '' }}>Rare</option>
                                        <option value="epic" {{ old('rarity', $badge->rarity) == 'epic' ? 'selected' : '' }}>Epic</option>
                                        <option value="legendary" {{ old('rarity', $badge->rarity) == 'legendary' ? 'selected' : '' }}>Legendary</option>
                                    </select>
                                    @error('rarity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Icon -->
                                <div class="mb-3">
                                    <label for="icon" class="form-label title-clr">Badge Icon</label>
                                    <input type="file" 
                                           name="icon" 
                                           id="icon" 
                                           class="form-control @error('icon') is-invalid @enderror" 
                                           accept="image/*">
                                    <div class="form-text">Upload an icon (Max 1MB)</div>
                                    @if($badge->icon)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/app/public/' . $badge->icon) }}" 
                                                 alt="{{ $badge->name }}" 
                                                 width="60" class="rounded border">
                                        </div>
                                    @endif
                                    @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Buttons -->
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-1"></i> Update Badge
                                    </button>
                                    <a href="{{ route('admin.community.badges.index') }}" class="btn btn-outline-secondary title-clr">
                                        <i class="fas fa-times me-1"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Badge Settings -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Badge Settings</h5>
                        </div>
                        <div class="card-body">
                            <!-- Status -->
                            <div class="mb-3">
                                <label class="form-label title-clr">Status</label>
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                           {{ old('is_active', $badge->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        <i class="fas fa-check-circle text-success me-1"></i> Active
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Guidelines -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle text-info me-1"></i> Guidelines
                            </h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i><small>Edit details carefully</small></li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i><small>Ensure badge uniqueness</small></li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i><small>Update criteria & points properly</small></li>
                                <li><i class="fas fa-check text-success me-2"></i><small>Replace old icon if required</small></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
