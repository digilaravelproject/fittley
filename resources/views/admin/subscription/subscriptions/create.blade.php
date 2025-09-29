@extends('layouts.admin')

@section('title', 'Manual Subscription')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Add Manual Subscription</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.subscriptions.manual.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="user_id" class="form-label">User</label>
                            <select name="user_id" id="user_id" class="form-select" required>
                                <option value="" disabled selected>Select user</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="subscription_plan_id" class="form-label">Subscription Plan</label>
                            <select name="subscription_plan_id" id="subscription_plan_id" class="form-select" required>
                                <option value="" disabled selected>Select plan</option>
                                @foreach($plans as $plan)
                                    <option value="{{ $plan->id }}">{{ $plan->name }} — {{ $plan->price }} {{ strtoupper($plan->currency ?? config('app.currency', 'USD')) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <input type="text" name="payment_method" id="payment_method" class="form-control" value="admin-manual" required>
                            <small class="text-muted">E.g., admin-manual / offline / complimentary</small>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="amount_paid" class="form-label">Amount Paid</label>
                                <input type="number" step="0.01" name="amount_paid" id="amount_paid" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="started_at" class="form-label">Start Date</label>
                                <input type="date" name="started_at" id="started_at" class="form-control" value="{{ now()->toDateString() }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="ends_at" class="form-label">End Date</label>
                            <input type="date" name="ends_at" id="ends_at" class="form-control" required>
                        </div>
                        <div class="text-end">
                            <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-link">Cancel</a>
                            <button type="submit" class="btn btn-success">Create Subscription</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 