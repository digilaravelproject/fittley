@extends('layouts.admin')

@section('title', 'Create Badge')

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
                            <i class="fas fa-medal text-primary me-2"></i>
                            Create Badge
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.community.dashboard') }}">Community</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.community.badges.index') }}">Badges</a></li>
                                <li class="breadcrumb-item active">Create</li>
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

            <!-- Create Form -->
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

                            <form action="{{ route('admin.community.badges.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- Badge Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label title-clr">Badge Name <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="name" 
                                           id="name" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name') }}" 
                                           placeholder="Enter badge name"
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
                                              placeholder="Write badge description..."
                                              required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Color -->
                                <div class="mb-3">
                                    <label for="color" class="form-label title-clr">Badge Color</label>
                                    <input type="color" 
                                           name="color" 
                                           id="color" 
                                           class="form-control form-control-color @error('color') is-invalid @enderror" 
                                           value="{{ old('color', '#3B82F6') }}">
                                    @error('color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Type -->
                                <div class="mb-3">
                                    <label for="type" class="form-label title-clr">Type <span class="text-danger">*</span></label>
                                    <select name="type" id="type" 
                                            class="form-select @error('type') is-invalid @enderror" required>
                                        <option value="">Select type</option>
                                        <option value="achievement" {{ old('type') == 'achievement' ? 'selected' : '' }}>Achievement</option>
                                        <option value="milestone" {{ old('type') == 'milestone' ? 'selected' : '' }}>Milestone</option>
                                        <option value="participation" {{ old('type') == 'participation' ? 'selected' : '' }}>Participation</option>
                                        <option value="special" {{ old('type') == 'special' ? 'selected' : '' }}>Special</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Criteria -->
                                <div class="mb-3">
                                    <label for="criteria" class="form-label title-clr">Criteria <span class="text-danger">*</span></label>
                                    <div id="criteria-container">
                                        <div class="criteria-item mb-2">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <select name="criteria_key[]" class="form-select">
                                                        <option value="">Select criterion</option>
                                                        <option value="posts_count">Posts Count</option>
                                                        <option value="likes_received">Likes Received</option>
                                                        <option value="comments_made">Comments Made</option>
                                                        <option value="days_active">Days Active</option>
                                                        <option value="friends_count">Friends Count</option>
                                                        <option value="groups_joined">Groups Joined</option>
                                                        <option value="fitlive_sessions_attended">FitLive Sessions</option>
                                                        <option value="fitguide_completed">FitGuide Completed</option>
                                                        <option value="fitnews_read">FitNews Read</option>
                                                        <option value="fitarena_participated">FitArena Participated</option>
                                                        <option value="streak_days">Streak Days</option>
                                                        <option value="total_points">Total Points</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="number" name="criteria_value[]" class="form-control" placeholder="Value" min="1">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-outline-danger btn-sm remove-criteria" style="display: none;">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm" id="add-criteria">
                                        <i class="fas fa-plus me-1"></i>Add Criterion
                                    </button>
                                    <div class="form-text">Define the conditions users must meet to earn this badge</div>
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
                                           value="{{ old('points') }}" 
                                           min="1" max="1000"
                                           required>
                                    @error('points')
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
                                    @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Buttons -->
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-1"></i> Create Badge
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
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
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
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i><small>Choose a clear badge name</small></li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i><small>Provide meaningful description</small></li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i><small>Set proper criteria and points</small></li>
                                <li><i class="fas fa-check text-success me-2"></i><small>Use a unique icon for recognition</small></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const criteriaContainer = document.getElementById('criteria-container');
    const addCriteriaBtn = document.getElementById('add-criteria');
    
    // Add criteria functionality
    addCriteriaBtn.addEventListener('click', function() {
        const newCriteriaItem = document.createElement('div');
        newCriteriaItem.className = 'criteria-item mb-2';
        newCriteriaItem.innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <select name="criteria_key[]" class="form-select">
                        <option value="">Select criterion</option>
                        <option value="posts_count">Posts Count</option>
                        <option value="likes_received">Likes Received</option>
                        <option value="comments_made">Comments Made</option>
                        <option value="days_active">Days Active</option>
                        <option value="friends_count">Friends Count</option>
                        <option value="groups_joined">Groups Joined</option>
                        <option value="fitlive_sessions_attended">FitLive Sessions</option>
                        <option value="fitguide_completed">FitGuide Completed</option>
                        <option value="fitnews_read">FitNews Read</option>
                        <option value="fitarena_participated">FitArena Participated</option>
                        <option value="streak_days">Streak Days</option>
                        <option value="total_points">Total Points</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="number" name="criteria_value[]" class="form-control" placeholder="Value" min="1">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-criteria">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        
        criteriaContainer.appendChild(newCriteriaItem);
        updateRemoveButtons();
    });
    
    // Remove criteria functionality
    criteriaContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remove-criteria')) {
            e.target.closest('.criteria-item').remove();
            updateRemoveButtons();
        }
    });
    
    // Update remove buttons visibility
    function updateRemoveButtons() {
        const criteriaItems = criteriaContainer.querySelectorAll('.criteria-item');
        const removeButtons = criteriaContainer.querySelectorAll('.remove-criteria');
        
        removeButtons.forEach((btn, index) => {
            if (criteriaItems.length > 1) {
                btn.style.display = 'inline-block';
            } else {
                btn.style.display = 'none';
            }
        });
    }
    
    // Form submission - convert criteria to JSON
    document.querySelector('form').addEventListener('submit', function(e) {
        const criteriaKeys = document.querySelectorAll('select[name="criteria_key[]"]');
        const criteriaValues = document.querySelectorAll('input[name="criteria_value[]"]');
        const criteria = {};
        
        criteriaKeys.forEach((select, index) => {
            const key = select.value;
            const value = parseInt(criteriaValues[index].value);
            
            if (key && value) {
                criteria[key] = value;
            }
        });
        
        // Create hidden input for criteria JSON
        const criteriaInput = document.createElement('input');
        criteriaInput.type = 'hidden';
        criteriaInput.name = 'criteria';
        criteriaInput.value = JSON.stringify(criteria);
        
        this.appendChild(criteriaInput);
    });
});
</script>
@endpush
