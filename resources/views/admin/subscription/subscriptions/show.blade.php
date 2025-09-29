@extends('layouts.admin')

@section('title', 'Subscription Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Subscription Details</h4>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5 class="text-secondary">User Information</h5>
                        <p><strong>Name:</strong> {{ $subscription->user?->name ?? 'N/A' }}</p>
                        <p><strong>Email:</strong> {{ $subscription->user?->email ?? 'N/A' }}</p>
                    </div>

                    <div class="mb-4">
                        <h5 class="text-secondary">Plan Information</h5>
                        <p><strong>Plan:</strong> {{ $subscription->subscriptionPlan?->name ?? 'N/A' }}</p>
                        <p><strong>Price:</strong> 
                            {{ $subscription->subscriptionPlan?->price 
                                ? number_format($subscription->subscriptionPlan->price, 2) 
                                : 'N/A' }}
                        </p>
                        <p><strong>Billing Cycle:</strong> {{ $subscription->subscriptionPlan?->interval ?? 'N/A' }}</p>
                    </div>


                    <div class="mb-4">
                        <h5 class="text-secondary">Subscription Status</h5>
                        <p><strong>Status:</strong>
                            @if($subscription->started_at && $subscription->ends_at)
                                @if(now()->lt($subscription->started_at))
                                    <span class="badge bg-warning">Pending</span>
                                @elseif(now()->between($subscription->started_at, $subscription->ends_at))
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Expired</span>
                                @endif
                            @else
                                <span class="badge bg-secondary">No Dates</span>
                            @endif
                        </p>
                        <p><strong>Started At:</strong> {{ $subscription->started_at ? $subscription->started_at->format('M d, Y') : 'N/A' }}</p>
                        <p><strong>Ends At:</strong> {{ $subscription->ends_at ? $subscription->ends_at->format('M d, Y') : 'N/A' }}</p>
                        @if($subscription->ends_at && $subscription->ends_at->isFuture())
                            <p class="text-warning">Expires soon</p>
                        @endif
                    </div>

                    <div class="mb-4">
                        <h5 class="text-secondary">Payment Information</h5>
                        <p><strong>Amount Paid:</strong> {{ number_format($subscription->amount_paid, 2) }}</p>
                        <p><strong>Payment Method:</strong> {{ $subscription->payment_method ?? 'N/A' }}</p>
                    </div>

                    @if($subscription->referralUsage)
                        <div class="mb-4">
                            <h5 class="text-secondary">Referral</h5>
                            <p><strong>Referral Code:</strong> {{ $subscription->referralUsage->code ?? 'N/A' }}</p>
                        </div>
                    @endif

                    @if($subscription->influencerSale)
                        <div class="mb-4">
                            <h5 class="text-secondary">Influencer Sale</h5>
                            <p><strong>Influencer:</strong> {{ $subscription->influencerSale->influencer->name ?? 'N/A' }}</p>
                        </div>
                    @endif

                    <div class="text-end">
                        <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-link">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
