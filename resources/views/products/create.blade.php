@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Add New Product</h1>
            <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800">← Back to Products</a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="space-y-6">
                    <!-- Basic Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product Name *</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="sku" class="block text-sm font-medium text-gray-700 mb-1">SKU *</label>
                                <input type="text" name="sku" id="sku" value="{{ old('sku') }}" required
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('sku')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                            <textarea name="description" id="description" rows="4" required
                                      class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Pricing and Inventory -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Pricing & Inventory</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price *</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-500">$</span>
                                    <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0" required
                                           class="w-full border border-gray-300 rounded-md pl-8 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                @error('price')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity *</label>
                                <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity', 0) }}" min="0" required
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('stock_quantity')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Category and Status -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Category & Status</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                                <select name="category_id" id="category_id" required
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Featured Product</label>
                                <div class="flex items-center">
                                    <input type="checkbox" name="featured" id="featured" value="1" {{ old('featured') ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="featured" class="ml-2 text-sm text-gray-700">Mark as featured</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Images -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Product Images</h3>
                        
                        <div>
                            <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Upload Images</label>
                            <input type="file" name="images[]" id="images" multiple accept="image/*"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-sm text-gray-500 mt-1">You can select multiple images. First image will be the main image.</p>
                            @error('images.*')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Specifications -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Specifications</h3>
                        <p class="text-sm text-gray-600 mb-4">Add product specifications (optional)</p>
                        
                        <div id="specifications-container">
                            <div class="specification-row grid grid-cols-1 md:grid-cols-2 gap-4 mb-2">
                                <input type="text" name="specifications[key][]" placeholder="Specification name"
                                       class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <input type="text" name="specifications[value][]" placeholder="Specification value"
                                       class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        
                        <button type="button" id="add-specification" 
                                class="mt-2 text-blue-600 hover:text-blue-800 text-sm font-medium">
                            + Add Another Specification
                        </button>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t">
                    <a href="{{ route('products.index') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                        Create Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('add-specification').addEventListener('click', function() {
    const container = document.getElementById('specifications-container');
    const newRow = document.createElement('div');
    newRow.className = 'specification-row grid grid-cols-1 md:grid-cols-2 gap-4 mb-2';
    newRow.innerHTML = `
        <input type="text" name="specifications[key][]" placeholder="Specification name"
               class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <input type="text" name="specifications[value][]" placeholder="Specification value"
               class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
    `;
    container.appendChild(newRow);
});
</script>
@endsection 