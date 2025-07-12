@extends('layouts.app')

@section('title', 'Inventory Management')
@section('page-title', 'Inventory Management')

@section('content')
<div class="row mb-3">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h6>Total Items</h6>
                <h3>{{ $stats['total_items'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h6>Low Stock</h6>
                <h3>{{ $stats['low_stock_items'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h6>Out of Stock</h6>
                <h3>{{ $stats['out_of_stock_items'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h6>Total Value</h6>
                <h3>₦{{ number_format($stats['total_value'], 2) }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-3 mb-3">
            <div class="col-md-3">
                <select name="stock_filter" class="form-control">
                    <option value="">All Stock Levels</option>
                    <option value="low_stock" {{ request('stock_filter') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                    <option value="out_of_stock" {{ request('stock_filter') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                    <option value="overstocked" {{ request('stock_filter') == 'overstocked' ? 'selected' : '' }}>Overstocked</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-outline-secondary">Filter</button>
            </div>
        </form>
        <form method="POST" action="{{ route('vendor.inventory.bulk-update') }}">
            @csrf
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>SKU</th>
                            <th>Stock</th>
                            <th>Update Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->sku }}</td>
                                <td>{{ $product->stock_quantity }}</td>
                                <td>
                                    <input type="number" name="products[{{ $product->id }}][stock_quantity]" value="{{ $product->stock_quantity }}" min="0" class="form-control" style="width: 100px; display: inline-block;">
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Bulk Update Stock</button>
            </div>
        </form>
        <div class="mt-3">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection 