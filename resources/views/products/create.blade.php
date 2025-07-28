@extends('layouts.dashboard')

@section('title', 'Create Product')

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="home-tab">
      <div class="d-sm-flex align-items-center justify-content-between border-bottom">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active ps-0" id="create-tab" data-bs-toggle="tab" href="#create" role="tab" aria-controls="create" aria-selected="true">Create Product</a>
          </li>
        </ul>
        <div>
          <a href="{{ route('vendor.products.index') }}" class="btn btn-primary text-white me-0">
            <i class="mdi mdi-arrow-left"></i> Back to Products
          </a>
        </div>
      </div>

      <div class="tab-content tab-content-basic">
        <div class="tab-pane fade show active" id="create" role="tabpanel" aria-labelledby="create">
          <div class="row">
            <div class="col-12 grid-margin stretch-card">
              <div class="card card-rounded">
                <div class="card-body">
                  <form action="{{ route('vendor.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <h4 class="card-title">Basic Information</h4>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Product Name *</label>
                          <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                          @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>SKU *</label>
                          <input type="text" class="form-control" name="sku" value="{{ old('sku') }}" required>
                          @error('sku')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label>Description *</label>
                      <textarea class="form-control" name="description" rows="4" required>{{ old('description') }}</textarea>
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
                            <input type="number" class="form-control" name="price" value="{{ old('price') }}" step="0.01" min="0" required>
                          </div>
                          @error('price')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Stock Quantity *</label>
                          <input type="number" class="form-control" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" min="0" required>
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
                              <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                            <input type="checkbox" class="form-check-input" name="featured" value="1" {{ old('featured') ? 'checked' : '' }}>
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
                    </div>

                    <h4 class="card-title mt-4">Specifications</h4>
                    <p class="card-description">Add product specifications (optional)</p>
                    <div id="specifications-container">
                      <div class="row mb-2 specification-row">
                        <div class="col-md-5">
                          <input type="text" class="form-control" name="specifications[key][]" placeholder="Specification name">
                        </div>
                        <div class="col-md-5">
                          <input type="text" class="form-control" name="specifications[value][]" placeholder="Specification value">
                        </div>
                      </div>
                    </div>
                    <button type="button" id="add-specification" class="btn btn-link text-primary mt-2">
                      <i class="mdi mdi-plus"></i> Add Another Specification
                    </button>

                    <div class="d-flex justify-content-end mt-4 pt-4 border-top">
                      <a href="{{ route('vendor.products.index') }}" class="btn btn-light me-2">Cancel</a>
                      <button type="submit" class="btn btn-primary">Create Product</button>
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
  // Image upload validation
  const imagesInput = document.querySelector('input[name="images[]"]');
  imagesInput.addEventListener('change', function() {
    if (this.files.length > 6) {
      alert('You can only upload up to 6 images.');
      this.value = '';
    }
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