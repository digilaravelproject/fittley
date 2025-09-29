@extends('layouts.admin')

@section('title', 'View Single Video - ' . $fgSingle->title)

@section('content')
<div class="admin-dashboard">
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="dashboard-title">{{ $fgSingle->title }}</h1>
            </div>
            <div class="col-auto">
                <div class="btn-group">
                    <a href="{{ route('admin.fitguide.single.edit', $fgSingle) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit
                    </a>
                    <a href="{{ route('admin.fitguide.single.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-content">
        <div class="content-card">
            <div class="content-card-header">
                <h5>Video Details</h5>
            </div>
            <div class="content-card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <strong>Title:</strong>
                            <p>{{ $fgSingle->title }}</p>
                        </div>
                        <div class="mb-3">
                            <strong>Category:</strong>
                            <p>{{ $fgSingle->category->name ?? 'N/A' }}</p>
                        </div>
                        <div class="mb-3">
                            <strong>Subcategory:</strong>
                            <p>{{ $fgSingle->subCategory->name ?? 'N/A' }}</p>
                        </div>
                        <div class="mb-3">
                            <strong>Language:</strong>
                            <p>{{ $fgSingle->language }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <strong>Release Date:</strong>
                            <p>{{ $fgSingle->release_date->format('M d, Y') }}</p>
                        </div>
                        <div class="mb-3">
                            <strong>Duration:</strong>
                            <p>{{ $fgSingle->duration_minutes ? $fgSingle->duration_minutes . ' minutes' : 'Not specified' }}</p>
                        </div>
                        <div class="mb-3">
                            <strong>Cost:</strong>
                            <p>{{ $fgSingle->cost ? '$' . number_format($fgSingle->cost, 2) : 'Free' }}</p>
                        </div>
                        <div class="mb-3">
                            <strong>Status:</strong>
                            <span class="badge {{ $fgSingle->is_published ? 'bg-success' : 'bg-secondary' }}">
                                {{ $fgSingle->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </div>
                    </div>
                </div>
                
                @if($fgSingle->description)
                    <div class="mb-3">
                        <strong>Description:</strong>
                        <p>{{ $fgSingle->description }}</p>
                    </div>
                @endif

                @if($fgSingle->video_type && ($fgSingle->video_url || $fgSingle->video_file_path))
                    <div class="mb-3">
                        <strong>Video:</strong>
                        <p>
                            Type: {{ ucfirst($fgSingle->video_type) }}
                            @if($fgSingle->video_url)
                                <br>URL: <a href="{{ $fgSingle->video_url }}" target="_blank">{{ $fgSingle->video_url }}</a>
                            @endif
                            @if($fgSingle->video_file_path)
                                <br>File: {{ basename($fgSingle->video_file_path) }}
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 