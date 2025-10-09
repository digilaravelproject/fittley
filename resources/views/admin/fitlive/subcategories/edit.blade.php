@extends('layouts.admin')

@section('title', 'Edit Sub Category')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card bg-dark border-secondary">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title text-white mb-0">
                            <i class="fas fa-edit me-2"></i>Edit Sub Category: {{ $subCategory->name }}
                        </h3>
                        <a href="{{ route('admin.fitlive.subcategories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Back to Sub Categories
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.fitlive.subcategories.update', $subCategory) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label text-white">Category *</label>
                                        <select
                                            class="form-select bg-dark border-secondary text-white @error('category_id') is-invalid @enderror"
                                            id="category_id" name="category_id" required>
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id', $subCategory->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="name" class="form-label text-white">Sub Category Name *</label>
                                        <input type="text"
                                            class="form-control bg-dark border-secondary text-white @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name', $subCategory->name) }}"
                                            required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="slug" class="form-label text-white">Slug</label>
                                        <input type="text"
                                            class="form-control bg-dark border-secondary text-white @error('slug') is-invalid @enderror"
                                            id="slug" name="slug" value="{{ old('slug', $subCategory->slug) }}">

                                        @error('slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text text-white">
                                            Leave empty to auto-generate from name. If the generated slug already exists, a
                                            unique version will be created.
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="sort_order" class="form-label text-white">Sort Order</label>
                                        <input type="number"
                                            class="form-control bg-dark border-secondary text-white @error('sort_order') is-invalid @enderror"
                                            id="sort_order" name="sort_order"
                                            value="{{ old('sort_order', $subCategory->sort_order) }}" min="0">
                                        @error('sort_order')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.fitlive.subcategories.index') }}"
                                            class="btn btn-secondary">
                                            Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i>Update Sub Category
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');

            nameInput.addEventListener('input', function() {
                if (!slugInput.value || slugInput.dataset.autoGenerated) {
                    const slug = this.value
                        .toLowerCase()
                        .replace(/[^a-z0-9\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-')
                        .trim('-');
                    slugInput.value = slug;
                    slugInput.dataset.autoGenerated = 'true';
                }
            });

            slugInput.addEventListener('input', function() {
                if (this.value) {
                    delete this.dataset.autoGenerated;
                }
            });
        });
    </script>
@endsection