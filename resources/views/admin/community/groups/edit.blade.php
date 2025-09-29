@extends('layouts.admin')

@section('title', 'Edit Community Group')

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
                            <i class="fas fa-users text-primary me-2"></i>
                            Edit Community Group
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.community.dashboard') }}">Community</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.community.groups.index') }}">Groups</a></li>
                                <li class="breadcrumb-item active">Edit</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-actions">
                        <a href="{{ route('admin.community.groups.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to Groups
                        </a>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Group Details</h5>
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

                            <form action="{{ route('admin.community.groups.update', $group->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Group Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label title-clr">Group Name <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="name" 
                                           id="name" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name', $group->name) }}" 
                                           placeholder="Enter group name"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Category -->
                                <div class="mb-3">
                                    <label for="community_category_id" class="form-label title-clr">Category <span class="text-danger">*</span></label>
                                    <select name="community_category_id" 
                                            id="community_category_id"
                                            class="form-select @error('community_category_id') is-invalid @enderror" 
                                            required>
                                        <option value="">Select category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                {{ old('community_category_id', $group->community_category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('community_category_id')
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
                                              placeholder="Write group description..."
                                              required>{{ old('description', $group->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Rules -->
                                <div class="mb-3">
                                    <label for="rules" class="form-label title-clr">Rules <span class="text-danger">*</span></label>
                                    <textarea name="rules" 
                                              id="rules" 
                                              rows="4"
                                              class="form-control @error('rules') is-invalid @enderror"
                                              placeholder="Write group rules..."
                                              required>{{ old('rules', $group->rules) }}</textarea>
                                    @error('rules')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Group Tags -->
                                <div class="mb-3">
                                    <label for="tags" class="form-label title-clr">Group Tags <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="tags" 
                                           id="tags" 
                                           class="form-control @error('tags') is-invalid @enderror" 
                                           value="{{ old('tags', $group->tags) }}" 
                                           placeholder="Enter group tags"
                                           required>
                                    @error('tags')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Assign Admin User -->
                                <div class="mb-3">
                                    <label for="admin_user_id" class="form-label title-clr">Assign Admin User <span class="text-danger">*</span></label>
                                    <select name="admin_user_id" id="admin_user_id"
                                            class="form-select">
                                        <option value="">Select a user</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('admin_user_id', $group->admin_user_id) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Cover Image -->
                                <div class="mb-3">
                                    <label for="cover_image" class="form-label title-clr">Cover Image</label>
                                    <input type="file" 
                                           name="cover_image" 
                                           id="cover_image" 
                                           class="form-control @error('cover_image') is-invalid @enderror" 
                                           accept="image/*">
                                    <div class="form-text">Upload a group cover image (Max 2MB)</div>
                                    @if($group->cover_image)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/app/public/'.$group->cover_image) }}" 
                                                 alt="Cover Image" 
                                                 class="img-thumbnail" 
                                                 style="max-height: 150px;">
                                        </div>
                                    @endif
                                    @error('cover_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Buttons -->
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-1"></i> Update Group
                                    </button>
                                    <a href="{{ route('admin.community.groups.index') }}" class="btn btn-outline-secondary title-clr">
                                        <i class="fas fa-times me-1"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Group Settings -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Group Settings</h5>
                        </div>
                        <div class="card-body">
                            <!-- Status -->
                            <div class="mb-3">
                                <label class="form-label title-clr">Status</label>
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="is_active" 
                                           name="is_active" 
                                           value="1" 
                                           {{ old('is_active', $group->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        <i class="fas fa-check-circle text-success me-1"></i> Active
                                    </label>
                                </div>
                            </div>

                            <!-- Privacy -->
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="is_private" 
                                           name="is_private" 
                                           value="1" 
                                           {{ old('is_private', $group->is_private) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_private">
                                        <i class="fas fa-lock text-warning me-1"></i> Private Group
                                    </label>
                                </div>
                                <div class="form-text">Private groups require admin approval for members</div>
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
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i><small>Choose a clear group name</small></li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i><small>Provide a meaningful description</small></li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i><small>Set group rules for better engagement</small></li>
                                <li><i class="fas fa-check text-success me-2"></i><small>Use cover image for better appearance</small></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
