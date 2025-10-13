@extends('layouts.public')

@section('title', 'Delete Account')

@section('content')
    <div class="container py-4">
        <h3>Delete Account</h3>
        <p class="text-danger">This action is irreversible!</p>

        <form action="{{ route('account.destroy') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Enter Password</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="mb-3">
                <label>Type DELETE to confirm</label>
                <input type="text" name="confirmation" class="form-control">
            </div>

            <button class="btn btn-danger">Delete My Account</button>
        </form>
    </div>
@endsection