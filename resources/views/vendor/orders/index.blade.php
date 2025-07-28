@extends('layouts.dashboard')

@section('title', 'Orders')

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="home-tab">
      <div class="d-sm-flex align-items-center justify-content-between border-bottom">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active ps-0" id="orders-tab" data-bs-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="true">Orders</a>
          </li>
        </ul>
        <div>
          <div class="btn-wrapper">
            <a href="#" class="btn btn-otline-dark"><i class="mdi mdi-printer"></i> Print</a>
            <a href="#" class="btn btn-primary text-white me-0"><i class="mdi mdi-download"></i> Export</a>
          </div>
        </div>
      </div>

      <div class="tab-content tab-content-basic">
        <div class="tab-pane fade show active" id="orders" role="tabpanel" aria-labelledby="orders">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Order #</th>
                          <th>Buyer</th>
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
                          <td>{{ $order->buyer->name ?? '-' }}</td>
                          <td>₦{{ number_format($order->total, 2) }}</td>
                          <td>
                            <div class="badge badge-opacity-{{ 
                              $order->status == 'pending' ? 'warning' : 
                              ($order->status == 'completed' ? 'success' : 'primary')
                            }}">
                              {{ ucfirst($order->status) }}
                            </div>
                          </td>
                          <td>
                            <div class="badge badge-opacity-{{ 
                              $order->payment_status == 'paid' ? 'success' : 'danger'
                            }}">
                              {{ ucfirst($order->payment_status) }}
                            </div>
                          </td>
                          <td>{{ $order->created_at->format('M d, Y') }}</td>
                          <td>
                            <a href="{{ route('vendor.orders.show', $order) }}" class="btn btn-sm btn-info">
                              <i class="mdi mdi-eye"></i> View
                            </a>
                          </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="7" class="text-center py-4">
                            <i class="mdi mdi-database-remove" style="font-size: 2rem;"></i>
                            <p class="mt-2">No orders found</p>
                          </td>
                        </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                  <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                      Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} entries
                    </div>
                    <div>
                      {{ $orders->links() }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection