@extends('layouts.admin')

@section('title', 'Create Homepage Hero')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">Create Homepage Hero</h1>
                <p class="page-subtitle">Add new hero content for homepage video background</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.homepage.hero.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Heroes
                </a>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.homepage.hero.store') }}">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="content-card">
                    <div class="content-card-header">
                        <h5 class="mb-0">Hero Content Details</h5>
                    </div>
                    <div class="content-card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" rows="4" class="form-control" required>{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="youtube_video_url" class="form-label">YouTube Video URL</label>
                            <input type="url" name="youtube_video_url" id="youtube_video_url" 
                                   class="form-control @error('youtube_video_url') is-invalid @enderror" 
                                   value="{{ old('youtube_video_url') }}" 
                                   placeholder="https://www.youtube.com/watch?v=...">
                            @error('youtube_video_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Enter the full YouTube URL. Video will be embedded without controls. Leave empty to use background image instead.</div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <input type="text" name="category" id="category" class="form-control" value="{{ old('category') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="duration" class="form-label">Duration</label>
                                    <input type="text" name="duration" id="duration" class="form-control" value="{{ old('duration') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="year" class="form-label">Year</label>
                                    <input type="number" name="year" id="year" class="form-control" value="{{ old('year', date('Y')) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="play_button_text" class="form-label">Play Button Text</label>
                                    <input type="text" name="play_button_text" id="play_button_text" class="form-control" value="{{ old('play_button_text', 'PLAY NOW') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="play_button_link" class="form-label">Play Button Link</label>
                                    <input type="url" name="play_button_link" id="play_button_link" class="form-control" value="{{ old('play_button_link') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="trailer_button_text" class="form-label">Trailer Button Text</label>
                                    <input type="text" name="trailer_button_text" id="trailer_button_text" class="form-control" value="{{ old('trailer_button_text', 'WATCH TRAILER') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="trailer_button_link" class="form-label">Trailer Button Link</label>
                                    <input type="url" name="trailer_button_link" id="trailer_button_link" class="form-control" value="{{ old('trailer_button_link') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="content-card">
                    <div class="content-card-header">
                        <h5 class="mb-0">Settings</h5>
                    </div>
                    <div class="content-card-body">
                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                        </div>

                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create Hero
                            </button>
                            <a href="{{ route('admin.homepage.hero.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
