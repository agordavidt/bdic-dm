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
                        <div class="form-group">
                          <label>Status *</label>
                          <select class="form-select" name="status" required>
                            <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="out_of_stock" {{ old('status', $product->status) == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                          </select>
                          @error('status')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-check form-check-flat form-check-primary mt-3">
                          <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="featured" value="1" {{ old('featured', $product->featured) ? 'checked' : '' }}>
                            Mark as featured
                          </label>
                        </div>
                      </div>
                    </div>

                    <h4 class="card-title mt-4">Product Images</h4>
                    <div class="form-group">
                      @if($product->images && count($product->images) > 0)
                        <label>Current Images</label>
                        <div class="d-flex flex-wrap gap-2 mb-3" id="current-images-container">
                          @foreach($product->images as $image)
                            <div class="position-relative" style="width: 100px; height: 100px;">
                              <img src="{{ $image }}" class="rounded border" style="width: 100%; height: 100%; object-fit: cover;">
                              <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-image" data-url="{{ $image }}">
                                <i class="mdi mdi-delete"></i>
                              </button>
                              <input type="hidden" name="existing_images[]" value="{{ $image }}">
                            </div>
                          @endforeach
                        </div>
                      @endif
                      
                      <label>Upload New Images (max 6)</label>
                      <input type="file" class="form-control file-upload-info" name="images[]" id="images" multiple accept="image/*">
                      <small class="form-text text-muted">First image will be used as the main product image</small>
                      @error('images.*')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                      @enderror
                      
                      <div class="mt-3">
                        <div id="image-preview" class="d-flex flex-wrap gap-2"></div>
                      </div>
                    </div>

                    <h4 class="card-title mt-4">Specifications</h4>
                    <p class="card-description">Add product specifications (optional)</p>
                    <div id="specifications-container">
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
                                <i class="mdi mdi-delete"></i>
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
  // Enhanced image preview with progress and removal
  const imagesInput = document.getElementById('images');
  const previewContainer = document.getElementById('image-preview');
  const currentImagesContainer = document.getElementById('current-images-container');
  
  imagesInput.addEventListener('change', function() {
    previewContainer.innerHTML = '';
    const files = Array.from(this.files);
    
    if (files.length > 6) {
      alert('You can only upload up to 6 images.');
      this.value = '';
      return;
    }
    
    files.forEach((file, index) => {
      if (!file.type.startsWith('image/')) return;
      
      const reader = new FileReader();
      const previewItem = document.createElement('div');
      previewItem.className = 'position-relative';
      previewItem.style.width = '100px';
      previewItem.style.height = '100px';
      
      // Add loading indicator
      const loadingDiv = document.createElement('div');
      loadingDiv.className = 'd-flex justify-content-center align-items-center bg-light rounded border';
      loadingDiv.style.width = '100%';
      loadingDiv.style.height = '100%';
      loadingDiv.innerHTML = '<div class="spinner-border text-primary" role="status"></div>';
      previewItem.appendChild(loadingDiv);
      previewContainer.appendChild(previewItem);
      
      reader.onload = function(e) {
        loadingDiv.remove();
        
        const img = document.createElement('img');
        img.src = e.target.result;
        img.className = 'rounded border';
        img.style.width = '100%';
        img.style.height = '100%';
        img.style.objectFit = 'cover';
        
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'btn btn-danger btn-sm position-absolute top-0 end-0';
        removeBtn.innerHTML = '<i class="mdi mdi-delete"></i>';
        removeBtn.onclick = function() {
          previewItem.remove();
          // Remove the file from the FileList
          const dt = new DataTransfer();
          const inputFiles = imagesInput.files;
          
          for (let i = 0; i < inputFiles.length; i++) {
            if (index !== i) dt.items.add(inputFiles[i]);
          }
          
          imagesInput.files = dt.files;
        };
        
        previewItem.appendChild(img);
        previewItem.appendChild(removeBtn);
      };
      
      reader.readAsDataURL(file);
    });
  });

  // Remove existing image
  document.querySelectorAll('.remove-image').forEach(button => {
    button.addEventListener('click', function() {
      const imageUrl = this.getAttribute('data-url');
      this.parentElement.remove();
      
      // Add hidden input to track removed images
      const input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'removed_images[]';
      input.value = imageUrl;
      document.querySelector('form').appendChild(input);
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