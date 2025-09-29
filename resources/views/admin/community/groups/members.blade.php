@extends('layouts.admin')

@section('content')
<div class="users-management">
    <!-- Header Section -->
    <div class="page-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-users me-3"></i>
                    Manage Members
                </h1>
                <p class="page-subtitle">Manage community group members and roles</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('admin.community.groups.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Groups
                </a>
            </div>
        </div>
    </div>

    <!-- Members Table -->
    <div class="content-card">
        <div class="content-card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="content-card-title">
                        <i class="fas fa-list me-2"></i>
                        Group Members
                    </h3>
                    <p class="content-card-subtitle">Complete list of members in this group</p>
                </div>
                <div class="table-controls">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search members..." class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="content-card-body p-0">
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $member)
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">
                                        @if($member->user->avatar)
                                            <img src="{{ asset('storage/app/public/' . $member->user->avatar) }}" alt="{{ $member->user->name }}" style="width:100%;height:100%;border-radius:12px;">
                                        @else
                                            <i class="fas fa-user"></i>
                                        @endif
                                    </div>
                                    <div class="user-details">
                                        <div class="user-name">{{ $member->user->name }}</div>
                                        <div class="user-id">#{{ $member->user->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="user-email">{{ $member->user->email }}</div>
                            </td>
                            <td>
                                <span class="role-badge role-{{ $member->role }}">
                                    @if($member->role === 'admin')
                                        <i class="fas fa-crown"></i>
                                    @elseif($member->role === 'moderator')
                                        <i class="fas fa-user-shield"></i>
                                    @else
                                        <i class="fas fa-user"></i>
                                    @endif
                                    {{ ucfirst($member->role) }}
                                </span>
                            </td>
                            <td>
                                <div class="date-info">
                                    <div class="date-primary">{{ $member->joined_at->format('M d, Y') }}</div>
                                    <div class="date-secondary">{{ $member->joined_at->diffForHumans() }}</div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="empty-content">
                                        <h4>No Members Found</h4>
                                        <p>There are no members in this group yet.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($members->hasPages())
            <div class="content-card-footer">
                <div class="pagination-wrapper">
                    <div class="pagination-info">
                        Showing {{ $members->firstItem() }}-{{ $members->lastItem() }} of {{ $members->total() }} members
                    </div>
                    <div class="pagination-controls">
                        {{ $members->links('pagination.custom') }}
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
