@extends('layouts.dashboard')

@section('title', 'Sales Report')

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="home-tab">
      <div class="d-sm-flex align-items-center justify-content-between border-bottom">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active ps-0" id="sales-tab" data-bs-toggle="tab" href="#sales" role="tab" aria-controls="sales" aria-selected="true">Sales Report</a>
          </li>
        </ul>
        <div>
          <button class="btn btn-primary text-white me-0" onclick="window.print()">
            <i class="mdi mdi-printer"></i> Print Report
          </button>
        </div>
      </div>

      <div class="tab-content tab-content-basic">
        <div class="tab-pane fade show active" id="sales" role="tabpanel" aria-labelledby="sales">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card card-rounded">
                <div class="card-body">
                  <form method="GET" class="row g-3 mb-4">
                    <div class="col-md-3">
                      <div class="input-group">
                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="input-group">
                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <button type="submit" class="btn btn-primary">
                        <i class="mdi mdi-filter"></i> Filter
                      </button>
                    </div>
                    @if(request()->has('start_date') || request()->has('end_date'))
                      <div class="col-md-3">
                        <a href="{{ route('vendor.reports.sales') }}" class="btn btn-secondary">
                          <i class="mdi mdi-close"></i> Clear Filters
                        </a>
                      </div>
                    @endif
                  </form>

                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>Product</th>
                          <th>Quantity</th>
                          <th>Total</th>
                          <th>Buyer</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($sales as $sale)
                          <tr>
                            <td>{{ $sale->created_at->format('M d, Y') }}</td>
                            <td>{{ $sale->product->name ?? '-' }}</td>
                            <td>{{ $sale->quantity }}</td>
                            <td>₦{{ number_format($sale->total, 2) }}</td>
                            <td>{{ $sale->buyer->name ?? '-' }}</td>
                          </tr>
                        @empty
                          <tr>
                            <td colspan="5" class="text-center py-4">
                              <i class="mdi mdi-database-remove" style="font-size: 2rem;"></i>
                              <p class="mt-2">No sales found for the selected period</p>
                            </td>
                          </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>

                  <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                      Showing {{ $sales->firstItem() }} to {{ $sales->lastItem() }} of {{ $sales->total() }} entries
                    </div>
                    <div>
                      {{ $sales->links() }}
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