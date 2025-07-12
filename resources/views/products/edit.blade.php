@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h2 text-dark">Edit Product</h1>
                <a href="{{ route('vendor.products.index') }}" class="btn btn-link text-primary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Products
                </a>
            </div>
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('vendor.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h3 class="h5 mb-3">Basic Information</h3>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Product Name *</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $product->name) }}" required>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="sku" class="form-label">SKU *</label>
                                <input type="text" class="form-control" name="sku" id="sku" value="{{ old('sku', $product->sku) }}" required>
                                @error('sku')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">Description *</label>
                                <textarea class="form-control" name="description" id="description" rows="4" required>{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h3 class="h5 mb-3">Pricing & Inventory</h3>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Price *</label>
                                <div class="input-group">
                                    <span class="input-group-text">₦</span>
                                    <input type="number" class="form-control" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required>
                                </div>
                                @error('price')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="stock_quantity" class="form-label">Stock Quantity *</label>
                                <input type="number" class="form-control" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0" required>
                                @error('stock_quantity')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h3 class="h5 mb-3">Category & Status</h3>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="category_id" class="form-label">Category *</label>
                                <select class="form-select" name="category_id" id="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id) == $category->id ? 'selected' : '') }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status *</label>
                                <select class="form-select" name="status" id="status" required>
                                    <option value="active" {{ (old('status', $product->status) == 'active' ? 'selected' : '') }}>Active</option>
                                    <option value="inactive" {{ (old('status', $product->status) == 'inactive' ? 'selected' : '') }}>Inactive</option>
                                    <option value="out_of_stock" {{ (old('status', $product->status) == 'out_of_stock' ? 'selected' : '') }}>Out of Stock</option>
                                </select>
                                @error('status')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="featured" id="featured" value="1" {{ old('featured', $product->featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="featured">
                                        Mark as featured
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h3 class="h5 mb-3">Product Images</h3>
                            </div>
                            @if($product->images && count($product->images) > 0)
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Current Images</label>
                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        @foreach($product->images as $image)
                                            <div class="position-relative" style="width: 100px; height: 100px;">
                                                <img src="{{ $image }}" class="rounded border" style="width: 100%; height: 100%; object-fit: cover;">
                                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-image" data-url="{{ $image }}">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-12 mb-3">
                                <label for="images" class="form-label">Add New Images (max 6)</label>
                                <input type="file" class="form-control" name="images[]" id="images" multiple accept="image/*" max="6">
                                <div class="form-text">You can select up to 6 images. The first image will be the main image.</div>
                                @error('images.*')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <div id="image-preview" class="mt-3 d-flex flex-wrap gap-2"></div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h3 class="h5 mb-3">Specifications</h3>
                                <p class="text-muted">Add product specifications (optional)</p>
                            </div>
                            <div class="col-md-12" id="specifications-container">
                                @if(old('specifications') || $product->specifications)
                                    @php
                                        $specs = old('specifications', $product->specifications);
                                        $keys = $specs['key'] ?? array_keys($specs);
                                        $values = $specs['value'] ?? array_values($specs);
                                    @endphp
                                    @foreach($keys as $index => $key)
                                        <div class="row mb-2 specification-row">
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" name="specifications[key][]" placeholder="Specification name" value="{{ $key }}">
                                            </div>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" name="specifications[value][]" placeholder="Specification value" value="{{ $values[$index] ?? '' }}">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-danger remove-specification">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="row mb-2 specification-row">
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="specifications[key][]" placeholder="Specification name">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="specifications[value][]" placeholder="Specification value">
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <button type="button" id="add-specification" class="btn btn-link text-primary">
                                    <i class="fas fa-plus me-2"></i>Add Another Specification
                                </button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end pt-4 border-top mt-4">
                            <a href="{{ route('vendor.products.index') }}" class="btn btn-secondary me-2">
                                <i class="fas fa-ban me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image preview functionality
    const imagesInput = document.getElementById('images');
    const previewContainer = document.getElementById('image-preview');
    imagesInput.addEventListener('change', function() {
        previewContainer.innerHTML = '';
        const files = Array.from(this.files);
        if (files.length > 6) {
            alert('You can only upload up to 6 images.');
            imagesInput.value = '';
            return;
        }
        files.forEach(file => {
            if (!file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'rounded border';
                img.style.width = '100px';
                img.style.height = '100px';
                img.style.objectFit = 'cover';
                img.style.marginRight = '8px';
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });

    // Specification functionality
    document.getElementById('add-specification').addEventListener('click', function() {
        const container = document.getElementById('specifications-container');
        const newRow = document.createElement('div');
        newRow.className = 'row mb-2 specification-row';
        newRow.innerHTML = `
            <div class="col-md-5">
                <input type="text" class="form-control" name="specifications[key][]" placeholder="Specification name">
            </div>
            <div class="col-md-5">
                <input type="text" class="form-control" name="specifications[value][]" placeholder="Specification value">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-specification">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(newRow);

        newRow.querySelector('.remove-specification').addEventListener('click', function() {
            newRow.remove();
        });
    });

    // Remove existing image
    document.querySelectorAll('.remove-image').forEach(button => {
        button.addEventListener('click', function() {
            const imageUrl = this.getAttribute('data-url');
            // You would need to implement AJAX to remove the image from server
            // For now, just remove the preview
            this.parentElement.remove();
            // Add a hidden input to track removed images
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'removed_images[]';
            input.value = imageUrl;
            document.querySelector('form').appendChild(input);
        });
    });

    // Remove specification rows
    document.querySelectorAll('.remove-specification').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.specification-row').remove();
        });
    });
});
</script>
@endpush
@endsection