@extends('layouts.dashboard')

@section('title', 'My Orders')
@section('page-title', 'Order History')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="card-title card-title-dash">Order History</h4>
                            <p class="card-subtitle card-subtitle-dash">Your past and current orders</p>
                        </div>
                    </div>

                    <div class="table-responsive mt-4">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Vendor</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Payment Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->vendor->company_name ?? '-' }}</td>
                                    <td>₦{{ number_format($order->total, 2) }}</td>
                                    <td>
                                        @if($order->status === 'pending')
                                            <span class="badge badge-opacity-warning">Pending</span>
                                        @elseif($order->status === 'processing')
                                            <span class="badge badge-opacity-primary">Processing</span>
                                        @elseif($order->status === 'completed')
                                            <span class="badge badge-opacity-success">Completed</span>
                                        @elseif($order->status === 'cancelled')
                                            <span class="badge badge-opacity-danger">Cancelled</span>
                                        @else
                                            <span class="badge badge-opacity-secondary">{{ ucfirst($order->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->payment_status === 'pending')
                                            <span class="badge badge-opacity-warning">Pending</span>
                                        @elseif($order->payment_status === 'paid')
                                            <span class="badge badge-opacity-success">Paid</span>
                                        @elseif($order->payment_status === 'failed')
                                            <span class="badge badge-opacity-danger">Failed</span>
                                        @else
                                            <span class="badge badge-opacity-secondary">{{ ucfirst($order->payment_status) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('buyer.orders.show', $order) }}" class="btn btn-sm btn-info">
                                            <i class="mdi mdi-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">No orders found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection