@extends('layouts.admin')

@section('title', 'Group Details')

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
                            {{ $group->name }}
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.community.dashboard') }}">Community</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.community.groups.index') }}">Groups</a></li>
                                <li class="breadcrumb-item active">Details</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-actions">
                        <a href="{{ route('admin.community.groups.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to Groups
                        </a>
                        <a href="{{ route('admin.community.groups.edit', $group->id) }}" class="btn btn-primary ms-2">
                            <i class="fas fa-edit me-1"></i> Edit Group
                        </a>
                    </div>
                </div>
            </div>

            <!-- Group Info -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Group Information</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Category:</strong> 
                                <span class="badge" style="background-color: {{ $group->category->color ?? '#6c757d' }}">
                                    {{ $group->category->name ?? 'N/A' }}
                                </span>
                            </p>
                            <p><strong>Description:</strong></p>
                            <p>{{ $group->description }}</p>

                            @if($group->rules)
                                <p><strong>Rules:</strong></p>
                                <p>{{ $group->rules }}</p>
                            @endif

                            @if($group->tags)
                                <p><strong>Tags:</strong></p>
                                <p>{{ $group->tags }}</p>
                            @endif

                            @if($group->cover_image)
                                <p><strong>Cover Image:</strong></p>
                                <img src="{{ asset('storage/app/public/'.$group->cover_image) }}" 
                                     alt="Cover Image" 
                                     class="img-fluid rounded shadow-sm" 
                                     style="max-height: 250px;">
                            @endif
                        </div>
                    </div>

                    <!-- Recent Posts -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Recent Posts</h5>
                        </div>
                        <div class="card-body">
                            @forelse($group->posts as $post)
                                <div class="mb-3 border-bottom pb-2">
                                    <div class="d-flex align-items-center mb-1">
                                        <img src="{{ $post->user->avatar ?? 'https://via.placeholder.com/40' }}" 
                                             alt="User Avatar" 
                                             class="rounded-circle me-2" 
                                             style="width: 40px; height: 40px;">
                                        <strong>{{ $post->user->name }}</strong>
                                        <span class="text-muted ms-2">{{ $post->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p>{{ Str::limit($post->content, 150) }}</p>
                                </div>
                            @empty
                                <p class="text-muted">No posts yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-4">
                    <!-- Stats -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Statistics</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li><strong>Total Members:</strong> {{ $stats['total_members'] }}</li>
                                <li><strong>Total Posts:</strong> {{ $stats['total_posts'] }}</li>
                                <li><strong>Posts This Month:</strong> {{ $stats['posts_this_month'] }}</li>
                                <li><strong>New Members This Month:</strong> {{ $stats['new_members_this_month'] }}</li>
                                <li><strong>Admins:</strong> {{ $stats['admins_count'] }}</li>
                                <li><strong>Moderators:</strong> {{ $stats['moderators_count'] }}</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Members -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Members</h5>
                        </div>
                        <div class="card-body">
                            @forelse($group->members as $member)
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{ $member->user->avatar ?? 'https://via.placeholder.com/40' }}" 
                                         alt="User Avatar" 
                                         class="rounded-circle me-2" 
                                         style="width: 40px; height: 40px;">
                                    <div>
                                        <strong>{{ $member->user->name }}</strong>
                                        <small class="text-muted d-block">{{ ucfirst($member->role) }}</small>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">No members found.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
