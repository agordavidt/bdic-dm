@extends('layouts.dashboard')

@section('title', 'Edit Product')

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="home-tab">
      <div class="d-sm-flex align-items-center justify-content-between border-bottom">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active ps-0" id="edit-tab" data-bs-toggle="tab" href="#edit" role="tab" aria-controls="edit" aria-selected="true">Edit Product</a>
          </li>
        </ul>
        <div>
          <a href="{{ route('vendor.products.index') }}" class="btn btn-primary text-white me-0">
            <i class="mdi mdi-arrow-left"></i> Back to Products
          </a>
        </div>
      </div>

      <div class="tab-content tab-content-basic">
        <div class="tab-pane fade show active" id="edit" role="tabpanel" aria-labelledby="edit">
          <div class="row">
            <div class="col-12 grid-margin stretch-card">
              <div class="card card-rounded">
                <div class="card-body">
                  <form action="{{ route('vendor.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <h4 class="card-title">Basic Information</h4>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Product Name *</label>
                          <input type="text" class="form-control" name="name" value="{{ old('name', $product->name) }}" required>
                          @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>SKU *</label>
                          <input type="text" class="form-control" name="sku" value="{{ old('sku', $product->sku) }}" required>
                          @error('sku')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label>Description *</label>
                      <textarea class="form-control" name="description" rows="4" required>{{ old('description', $product->description) }}</textarea>
                      @error('description')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                      @enderror
                    </div>

                    <h4 class="card-title mt-4">Pricing & Inventory</h4>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Price *</label>
                          <div class="input-group">
                            <span class="input-group-text">₦</span>
                            <input type="number" class="form-control" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required>
                          </div>
                          @error('price')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Stock Quantity *</label>
                          <input type="number" class="form-control" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0" required>
                          @error('stock_quantity')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    </div>

                    <h4 class="card-title mt-4">Category & Status</h4>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Category *</label>
                          <select class="form-select" name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                              <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                              </option>
                            @endforeach
                          </select>
                          @error('category_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-check form-check-flat form-check-primary mt-4">
                          <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="featured" value="1" {{ old('featured', $product->featured) ? 'checked' : '' }}>
                            Mark as featured
                          </label>
                        </div>
                      </div>
                    </div>

                    <h4 class="card-title mt-4">Product Images</h4>
                    <div class="form-group">
                      <label>Upload Images (max 6)</label>
                      <input type="file" class="form-control file-upload-info" name="images[]" multiple accept="image/*" max="6">
                      <small class="form-text text-muted">You can select up to 6 images. The first image will be the main image.</small>
                      @error('images.*')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                      @enderror
                      
                      <div class="mt-3 d-flex flex-wrap gap-2">
                        @if(is_array($product->images))
                          @foreach($product->images as $idx => $img)
                            <div class="position-relative">
                              <img src="{{ $img }}" class="rounded border" style="width:100px;height:100px;object-fit:cover;">
                              <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-existing-image" data-index="{{ $idx }}">
                                <i class="mdi mdi-delete"></i>
                              </button>
                              <input type="hidden" name="existing_images[]" value="{{ $img }}">
                            </div>
                          @endforeach
                        @endif
                      </div>
                    </div>

                    <h4 class="card-title mt-4">Specifications</h4>
                    <p class="card-description">Add product specifications (optional)</p>
                    <div id="specifications-container">
                      @if(is_array($product->specifications))
                        @foreach($product->specifications as $key => $value)
                          <div class="row mb-2 specification-row">
                            <div class="col-md-5">
                              <input type="text" class="form-control" name="specifications[key][]" placeholder="Specification name" value="{{ $key }}">
                            </div>
                            <div class="col-md-5">
                              <input type="text" class="form-control" name="specifications[value][]" placeholder="Specification value" value="{{ $value }}">
                            </div>
                            <div class="col-md-2">
                              <button type="button" class="btn btn-danger remove-specification">
                                <i class="mdi mdi-delete"></i>
                              </button>
                            </div>
                          </div>
                        @endforeach
                      @endif
                    </div>
                    <button type="button" id="add-specification" class="btn btn-link text-primary mt-2">
                      <i class="mdi mdi-plus"></i> Add Another Specification
                    </button>

                    <div class="d-flex justify-content-end mt-4 pt-4 border-top">
                      <a href="{{ route('vendor.products.index') }}" class="btn btn-light me-2">Cancel</a>
                      <button type="submit" class="btn btn-primary">Update Product</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Image preview for new uploads
  const imagesInput = document.querySelector('input[name="images[]"]');
  imagesInput.addEventListener('change', function() {
    if (this.files.length > 6) {
      alert('You can only upload up to 6 images.');
      this.value = '';
    }
  });

  // Remove existing image
  document.querySelectorAll('.remove-existing-image').forEach(function(btn) {
    btn.addEventListener('click', function() {
      this.closest('.position-relative').remove();
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
          <i class="mdi mdi-delete"></i>
        </button>
      </div>
    `;
    container.appendChild(newRow);

    newRow.querySelector('.remove-specification').addEventListener('click', function() {
      newRow.remove();
    });
  });
});
</script>
@endpush
@endsection