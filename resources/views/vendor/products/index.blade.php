@extends('layouts.dashboard')

@section('title', 'My Products')

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="home-tab">
      <div class="d-sm-flex align-items-center justify-content-between border-bottom">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">My Products</a>
          </li>
        </ul>
        <div>
          <a href="{{ route('vendor.products.create') }}" class="btn btn-primary text-white me-0"><i class="mdi mdi-plus"></i> Add New Product</a>
        </div>
      </div>

      <div class="tab-content tab-content-basic">
        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <form method="GET" class="row mb-3">
                    <div class="col-md-4">
                      <input type="text" name="search" class="form-control" placeholder="Search by name or SKU" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                      <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <button type="submit" class="btn btn-outline-secondary"><i class="mdi mdi-filter"></i> Filter</button>
                    </div>
                  </form>

                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>SKU</th>
                          <th>Price</th>
                          <th>Stock</th>
                          <th>Status</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($products as $product)
                          <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->sku }}</td>
                            <td>₦{{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->stock_quantity }}</td>
                            <td>
                              <div class="badge badge-opacity-{{ 
                                $product->status == 'active' ? 'success' : 
                                ($product->status == 'inactive' ? 'danger' : 'warning') 
                              }}">
                                {{ ucfirst($product->status) }}
                              </div>
                            </td>
                            <td>
                              <a href="{{ route('vendor.products.edit', $product) }}" class="btn btn-sm btn-warning"><i class="mdi mdi-pencil"></i></a>
                              <form action="{{ route('vendor.products.destroy', $product) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="mdi mdi-delete"></i></button>
                              </form>
                            </td>
                          </tr>
                        @empty
                          <tr>
                            <td colspan="6" class="text-center">No products found.</td>
                          </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                  <div class="mt-3">
                    {{ $products->links() }}
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