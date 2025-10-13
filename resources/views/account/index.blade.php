@extends('layouts.public')

@section('title', 'Account Settings')

@section('content')
    <div class="container py-4">
        <h2>Account Settings</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- PROFILE FORM --}}
        <form action="{{ route('account.updateProfile') }}" method="POST" enctype="multipart/form-data" class="mb-4">
            @csrf
            <h4>Profile Information</h4>
            <div class="mb-3">
                <label>Name</label>
                <input name="name" class="form-control" value="{{ old('name', $user->name) }}">
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input name="email" class="form-control" value="{{ old('email', $user->email) }}">
            </div>

            <div class="mb-3">
                <label>Profile Picture</label>
                <input type="file" name="profile_picture" class="form-control">
                @if($user->profile_picture)
                    <img src="{{ asset('storage/' . $user->profile_picture) }}" width="80" class="mt-2">
                @endif
            </div>

            <button class="btn btn-primary">Update Profile</button>
        </form>

        {{-- PASSWORD FORM --}}
        <form action="{{ route('account.updatePassword') }}" method="POST" class="mb-4">
            @csrf
            <h4>Change Password</h4>

            <div class="mb-3">
                <label>Current Password</label>
                <input type="password" name="current_password" class="form-control">
            </div>

            <div class="mb-3">
                <label>New Password</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <button class="btn btn-warning">Update Password</button>
        </form>

        {{-- PREFERENCES FORM --}}
        <form action="{{ route('account.updatePreferences') }}" method="POST">
            @csrf
            <h4>Preferences</h4>

            <label>
                <input type="checkbox" name="email_notifications" value="1" {{ $user->preferences['email_notifications'] ?? false ? 'checked' : '' }}>
                Email Notifications
            </label><br>

            <button class="btn btn-success mt-2">Save Preferences</button>
        </form>
    </div>
@endsection