@extends('layouts.admin')

@section('title', 'Category Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card bg-dark border-secondary">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title text-white mb-0">
                        <i class="fas fa-tag me-2"></i>{{ $category->name }}
                    </h3>
                    <div class="btn-group">
                        <a href="{{ route('admin.fitinsight.categories.edit', $category) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <a href="{{ route('admin.fitinsight.categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-dark table-borderless">
                                <tr>
                                    <th width="30%">ID:</th>
                                    <td>{{ $category->id }}</td>
                                </tr>
                                <tr>
                                    <th>Name:</th>
                                    <td>{{ $category->name }}</td>
                                </tr>
                                <tr>
                                    <th>Slug:</th>
                                    <td><code class="text-info">{{ $category->slug }}</code></td>
                                </tr>
                                <tr>
                                    <th>Chat Mode:</th>
                                    <td>
                                        @switch($category->chat_mode)
                                            @case('during')
                                                <span class="badge bg-success">During Live</span>
                                                @break
                                            @case('after')
                                                <span class="badge bg-warning">After Live</span>
                                                @break
                                            @case('off')
                                                <span class="badge bg-danger">Disabled</span>
                                                @break
                                        @endswitch
                                    </td>
                                </tr>
                                <tr>
                                    <th>Sort Order:</th>
                                    <td>{{ $category->sort_order }}</td>
                                </tr>
                                <tr>
                                    <th>Created:</th>
                                    <td>{{ $category->created_at->format('F d, Y \a\t g:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Updated:</th>
                                    <td>{{ $category->updated_at->format('F d, Y \a\t g:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="row text-center">
                                <?php /*<div class="col-6">
                                    <div class="card bg-secondary border-info">
                                        <div class="card-body">
                                            <h2 class="text-info">{{ $category->subCategories->count() }}</h2>
                                            <p class="mb-0">Sub Categories</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card bg-secondary border-primary">
                                        <div class="card-body">
                                            <h2 class="text-primary">{{ $category->fitLiveSessions->count() }}</h2>
                                            <p class="mb-0">Sessions</p>
                                        </div>
                                    </div>
                                </div>*/ ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 