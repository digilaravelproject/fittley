@extends('layouts.admin')

@section('title', 'Referral Code Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Referral Code Details</h1>
            <p class="mb-0">Code: <code class="text-primary">{{ $referralCode->code }}</code></p>
        </div>
        <div>
            <a href="{{ route('admin.subscriptions.referrals.edit', $referralCode) }}" class="btn btn-primary btn-sm shadow-sm mr-2">
                <i class="fas fa-edit fa-sm text-white-50 mr-1"></i>Edit Code
            </a>
            <a href="{{ route('admin.subscriptions.referrals.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i>Back to Referrals
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Uses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_uses'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Successful Uses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['successful_uses'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Discount Given</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">₹{{ number_format($stats['total_discount_given'], 2) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percentage fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Revenue Generated</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">₹{{ number_format($stats['revenue_generated'], 2) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-rupee-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Code Details and Usage -->
    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Referral Code Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Code:</strong></td>
                                    <td><code class="text-primary">{{ $referralCode->code }}</code></td>
                                </tr>
                                <tr>
                                    <td><strong>Owner:</strong></td>
                                    <td>{{ $referralCode->user->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $referralCode->user->email ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Discount:</strong></td>
                                    <td>
                                        @if($referralCode->discount_type === 'percentage')
                                            <span class="badge badge-success">{{ $referralCode->discount_value }}% OFF</span>
                                        @else
                                            <span class="badge badge-info">₹{{ number_format($referralCode->discount_value, 2) }} OFF</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Max Uses:</strong></td>
                                    <td>{{ $referralCode->max_uses ?: 'Unlimited' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Expires:</strong></td>
                                    <td>{{ $referralCode->expires_at ? $referralCode->expires_at->format('M d, Y') : 'Never' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        @if($referralCode->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Created:</strong></td>
                                    <td>{{ $referralCode->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usage History -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Usage History</h6>
                </div>
                <div class="card-body">
                    @if($referralCode->usages->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Subscription Plan</th>
                                        <th>Discount Applied</th>
                                        <th>Amount Paid</th>
                                        <th>Used At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($referralCode->usages as $usage)
                                        <tr>
                                            <td>
                                                <div>
                                                    <strong>{{ $usage->user->name }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $usage->user->email }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                @if($usage->subscription)
                                                    <span class="badge badge-info">{{ $usage->subscription->subscriptionPlan->name }}</span>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td class="text-success">₹{{ number_format($usage->discount_amount, 2) }}</td>
                                            <td>
                                                @if($usage->subscription)
                                                    ₹{{ number_format($usage->subscription->amount_paid, 2) }}
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>{{ $usage->used_at ? $usage->used_at->format('M d, Y h:i A') : 'Pending' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-clipboard-list fa-3x text-gray-300 mb-3"></i>
                            <h5 class="text-muted">No usage history</h5>
                            <p class="text-muted">This referral code hasn't been used yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.subscriptions.referrals.edit', $referralCode) }}" class="btn btn-outline-primary btn-sm mb-2">
                            <i class="fas fa-edit mr-1"></i>Edit Code
                        </a>
                        
                        @if($referralCode->usages->whereNotNull('used_at')->count() == 0)
                            <button class="btn btn-outline-danger btn-sm" onclick="deleteCode()">
                                <i class="fas fa-trash mr-1"></i>Delete Code
                            </button>
                        @endif
                        
                        <button class="btn btn-outline-secondary btn-sm" onclick="copyToClipboard()">
                            <i class="fas fa-copy mr-1"></i>Copy Code
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function copyToClipboard() {
    navigator.clipboard.writeText('{{ $referralCode->code }}').then(function() {
        toastr.success('Referral code copied to clipboard!');
    });
}

function deleteCode() {
    if (confirm('Are you sure you want to delete this referral code?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.subscriptions.referrals.destroy", $referralCode) }}';
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush 