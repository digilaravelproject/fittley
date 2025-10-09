@extends('layouts.admin')

@section('title', 'Sub Category Details')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Sub Category Card -->
                <div class="card bg-dark border-secondary">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title text-white mb-0">
                            <i class="fas fa-list me-2"></i>{{ $subCategory->name }}
                        </h3>
                        <div class="btn-group">
                            <a href="{{ route('admin.fitlive.subcategories.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Sub Category Details -->
                            <div class="col-md-6">
                                <table class="table table-dark table-borderless">
                                    <tr>
                                        <th width="30%">ID:</th>
                                        <td>{{ $subCategory->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Category:</th>
                                        <td>
                                            @if ($subCategory->category)
                                                <a href="{{ route('admin.fitlive.categories.show', $subCategory->category) }}"
                                                    class="text-info text-decoration-none">
                                                    {{ optional($subCategory->category)->name }}
                                                </a>
                                            @else
                                                <span>No Category</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Name:</th>
                                        <td>{{ $subCategory->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Slug:</th>
                                        <td><code class="text-info">{{ $subCategory->slug }}</code></td>
                                    </tr>
                                    <tr>
                                        <th>Sort Order:</th>
                                        <td>{{ $subCategory->sort_order }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created:</th>
                                        <td>{{ $subCategory->created_at?->format('F d, Y \a\t g:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated:</th>
                                        <td>{{ $subCategory->updated_at?->format('F d, Y \a\t g:i A') }}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Sessions Count -->
                            <div class="col-md-6">
                                <div class="card bg-secondary border-primary">
                                    <div class="card-body text-center">
                                        <h2 class="text-primary">{{ $subCategory->fitLiveSessions->count() }}</h2>
                                        <p class="mb-0">Sessions</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Sub Category Card -->
            </div>
        </div>

        <!-- Sessions Table -->
        @if ($subCategory->fitLiveSessions->count())
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card bg-dark border-secondary">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title text-white mb-0">
                                <i class="fas fa-video me-2"></i> Sessions
                            </h4>
                            <a href="{{ route('admin.fitlive.sessions.create', ['sub_category_id' => $subCategory->id]) }}"
                                class="btn btn-sm btn-primary">
                                <i class="fas fa-plus me-1"></i> Add Session
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-dark table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Instructor</th>
                                            <th>Status</th>
                                            <th>Scheduled</th>
                                            <th>Viewers</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subCategory->fitLiveSessions as $session)
                                            <tr>
                                                <td>{{ $session->title }}</td>
                                                <td>{{ optional($session->instructor)->name }}</td>
                                                <td>
                                                    @switch($session->status)
                                                        @case('scheduled')
                                                            <span class="badge bg-warning">Scheduled</span>
                                                        @break

                                                        @case('live')
                                                            <span class="badge bg-success">Live</span>
                                                        @break

                                                        @case('ended')
                                                            <span class="badge bg-secondary">Ended</span>
                                                        @break

                                                        @default
                                                            <span class="badge bg-light text-dark">Unknown</span>
                                                    @endswitch
                                                </td>
                                                <td>
                                                    {{ $session->scheduled_at?->format('M d, Y g:i A') ?? 'Not scheduled' }}
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $session->viewer_peak ?? 0 }}</span>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.fitlive.sessions.show', $session) }}"
                                                            class="btn btn-sm btn-outline-info">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.fitlive.sessions.edit', $session) }}"
                                                            class="btn btn-sm btn-outline-warning">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- /Sessions Table -->
    </div>
@endsection
