@extends('layouts.admin')

@section('title', 'Influencer Details - ' . ($influencer->user->name ?? 'Unknown User'))

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-tie fa-fw mr-2"></i>Influencer Details
        </h1>
        <div>
            <a href="{{ route('admin.influencers.edit', $influencer) }}" class="btn btn-primary btn-sm shadow-sm mr-2">
                <i class="fas fa-edit fa-sm text-white-50 mr-1"></i>Edit Influencer
            </a>
            <a href="{{ route('admin.influencers.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i>Back to Influencers
            </a>
        </div>
    </div>

    <!-- Influencer Overview -->
    <div class="row">
        <!-- Influencer Details Card -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4 bg-dark text-white">
                <div class="card-header py-3 bg-dark border-bottom border-secondary d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $influencer->user->name ?? 'Unknown User' }}</h6>
                    <div>
                        @switch($influencer->status)
                            @case('approved')
                                <span class="badge badge-success">Approved</span>
                                @break
                            @case('pending')
                                <span class="badge badge-warning">Pending</span>
                                @break
                            @case('rejected')
                                <span class="badge badge-danger">Rejected</span>
                                @break
                            @case('suspended')
                                <span class="badge badge-secondary">Suspended</span>
                                @break
                        @endswitch
                    </div>
                </div>
                <div class="card-body bg-dark">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-primary">Basic Information</h5>
                            <table class="table table-borderless text-white">
                                <tr>
                                    <td><strong>Name:</strong></td>
                                    <td>{{ $influencer->user->name ?? 'Unknown User' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $influencer->user->email ?? 'No email' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Commission Rate:</strong></td>
                                    <td class="text-success">{{ $influencer->commission_rate }}%</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>{{ ucfirst($influencer->status) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Joined:</strong></td>
                                    <td>{{ $influencer->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                                @if($influencer->approved_at)
                                <tr>
                                    <td><strong>Approved:</strong></td>
                                    <td>{{ $influencer->approved_at->format('M d, Y h:i A') }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-primary">Bio</h5>
                            <p class="text-muted">{{ $influencer->bio ?: 'No bio provided.' }}</p>
                            
                            @if($influencer->social_media)
                                <h5 class="text-primary mt-4">Social Media</h5>
                                @php 
                                    $social = is_string($influencer->social_media) ? json_decode($influencer->social_media, true) : $influencer->social_media;
                                @endphp
                                <div class="social-links">
                                    @if(isset($social['instagram']))
                                        <a href="{{ $social['instagram'] }}" target="_blank" class="btn btn-outline-danger mr-2 mb-2">
                                            <i class="fab fa-instagram mr-1"></i>Instagram
                                        </a>
                                    @endif
                                    @if(isset($social['youtube']))
                                        <a href="{{ $social['youtube'] }}" target="_blank" class="btn btn-outline-danger mr-2 mb-2">
                                            <i class="fab fa-youtube mr-1"></i>YouTube
                                        </a>
                                    @endif
                                    @if(isset($social['tiktok']))
                                        <a href="{{ $social['tiktok'] }}" target="_blank" class="btn btn-outline-dark mr-2 mb-2">
                                            <i class="fab fa-tiktok mr-1"></i>TikTok
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Card -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4 bg-dark text-white">
                <div class="card-header py-3 bg-dark border-bottom border-secondary">
                    <h6 class="m-0 font-weight-bold text-info">Performance Statistics</h6>
                </div>
                <div class="card-body bg-dark">
                    <div class="text-center mb-3">
                        <div class="h4 text-primary">₹{{ number_format($monthlyStats['sales_this_month'] ?? 0, 2) }}</div>
                        <div class="text-muted">Sales This Month</div>
                    </div>
                    
                    <hr class="border-secondary">
                    
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="h5 text-success">₹{{ number_format($monthlyStats['commission_this_month'] ?? 0, 2) }}</div>
                            <div class="text-muted small">Commission</div>
                        </div>
                        <div class="col-6">
                            <div class="h5 text-warning">{{ $monthlyStats['commission_rate'] ?? 10 }}%</div>
                            <div class="text-muted small">Rate</div>
                        </div>
                    </div>
                    
                    <hr class="border-secondary">
                    
                    <div class="text-center">
                        <div class="h5 text-info">{{ $influencer->total_sales_count ?? 0 }}</div>
                        <div class="text-muted small">Total Sales</div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow mb-4 bg-dark text-white">
                <div class="card-header py-3 bg-dark border-bottom border-secondary">
                    <h6 class="m-0 font-weight-bold text-info">Quick Actions</h6>
                </div>
                <div class="card-body bg-dark">
                    <div class="d-grid gap-2">
                        @if($influencer->status === 'pending')
                            <form method="POST" action="{{ route('admin.influencers.approve', $influencer) }}" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-success btn-sm mb-2 w-100">
                                    <i class="fas fa-check mr-1"></i>Approve Influencer
                                </button>
                            </form>
                            <button class="btn btn-outline-danger btn-sm mb-2 w-100" onclick="rejectInfluencer()">
                                <i class="fas fa-times mr-1"></i>Reject Application
                            </button>
                        @elseif($influencer->status === 'approved')
                            <button class="btn btn-outline-warning btn-sm mb-2 w-100" onclick="suspendInfluencer()">
                                <i class="fas fa-ban mr-1"></i>Suspend Influencer
                            </button>
                        @elseif($influencer->status === 'suspended')
                            <form method="POST" action="{{ route('admin.influencers.reactivate', $influencer) }}" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-success btn-sm mb-2 w-100">
                                    <i class="fas fa-play mr-1"></i>Reactivate
                                </button>
                            </form>
                        @endif
                        
                        <a href="{{ route('admin.influencers.edit', $influencer) }}" class="btn btn-outline-info btn-sm mb-2 w-100">
                            <i class="fas fa-edit mr-1"></i>Edit Details
                        </a>
                        
                        <a href="{{ route('admin.influencers.sales.index', ['influencer_id' => $influencer->id]) }}" class="btn btn-outline-primary btn-sm w-100">
                            <i class="fas fa-chart-line mr-1"></i>View Sales
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Sales -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4 bg-dark text-white">
                <div class="card-header py-3 bg-dark border-bottom border-secondary">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Sales</h6>
                </div>
                <div class="card-body bg-dark">
                    @if($influencer->sales && $influencer->sales->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Plan</th>
                                        <th>Sale Amount</th>
                                        <th>Commission</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($influencer->sales->take(10) as $sale)
                                    <tr>
                                        <td>
                                            <div>
                                                <strong>{{ $sale->customer->name ?? 'N/A' }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $sale->customer->email ?? 'N/A' }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">
                                                {{ $sale->subscription->subscriptionPlan->name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="text-success">₹{{ number_format($sale->sale_amount, 2) }}</td>
                                        <td class="text-warning">₹{{ number_format($sale->commission_amount, 2) }}</td>
                                        <td>
                                            @if($sale->status === 'confirmed')
                                                <span class="badge badge-success">Confirmed</span>
                                            @elseif($sale->status === 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @else
                                                <span class="badge badge-danger">Cancelled</span>
                                            @endif
                                        </td>
                                        <td>{{ $sale->created_at->format('M d, Y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="text-center mt-3">
                            <a href="{{ route('admin.influencers.sales.index', ['influencer_id' => $influencer->id]) }}" 
                               class="btn btn-outline-primary">
                                View All Sales
                            </a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-chart-line fa-3x text-gray-300 mb-3"></i>
                            <h5 class="text-muted">No sales yet</h5>
                            <p class="text-muted">Sales will appear here when this influencer starts referring customers.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header bg-dark border-bottom border-secondary">
                <h5 class="modal-title">Reject Influencer Application</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.influencers.reject', $influencer) }}">
                @csrf
                @method('PATCH')
                <div class="modal-body bg-dark">
                    <div class="form-group">
                        <label for="rejection_reason">Rejection Reason *</label>
                        <textarea class="form-control bg-dark text-white border-secondary" 
                                  id="rejection_reason" name="rejection_reason" rows="4" 
                                  placeholder="Please provide a reason for rejection..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-dark border-top border-secondary">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Application</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function rejectInfluencer() {
    $('#rejectModal').modal('show');
}

function suspendInfluencer() {
    if (confirm('Are you sure you want to suspend this influencer?')) {
        $.ajax({
            url: '{{ route("admin.influencers.suspend", $influencer) }}',
            method: 'PATCH',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    toastr.success('Influencer suspended successfully');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    toastr.error('Error suspending influencer');
                }
            },
            error: function() {
                toastr.error('Error suspending influencer');
            }
        });
    }
}
</script>
@endpush 