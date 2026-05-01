@extends('admin.layouts.admin')

@section('page-title', 'Edit Product')

@section('content')
<!-- Page Header -->
<div class="mb-8 flex items-end justify-between">
    <div>
        <h2 class="text-3xl font-black text-slate-900 tracking-tight">Edit Product</h2>
        <p class="text-slate-500 text-sm mt-1">Update details, stock, or pricing for {{ $product->name }}.</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.products.index') }}" class="flex items-center gap-2 px-4 py-2 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            <span class="font-semibold text-sm">Back to Products</span>
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] overflow-hidden border border-slate-100">
    <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="p-6 md:p-8 space-y-8">
            <!-- Product Info -->
            <div>
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-widest mb-4">Basic Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-xs font-bold text-slate-700 uppercase">Product Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                               class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-slate-50 focus:bg-white text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                        @error('name') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700 uppercase">Category <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <select name="category_id" required class="w-full appearance-none px-4 py-3 rounded-lg border border-slate-200 bg-slate-50 focus:bg-white text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all cursor-pointer">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (old('category_id') ?? $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span>
                        </div>
                        @error('category_id') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700 uppercase">SKU (Optional)</label>
                        <input type="text" name="sku" value="{{ old('sku', $product->sku) }}"
                               class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-slate-50 focus:bg-white text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all font-mono">
                        @error('sku') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label class="text-xs font-bold text-slate-700 uppercase">Description <span class="text-rose-500">*</span></label>
                        <textarea name="description" rows="4" required
                                  class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-slate-50 focus:bg-white text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">{{ old('description', $product->description) }}</textarea>
                        @error('description') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Pricing & Inventory -->
            <div class="pt-8 border-t border-slate-100">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-widest mb-4">Pricing & Inventory</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700 uppercase">Price <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-slate-400">$</span>
                            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required
                                   class="w-full pl-8 pr-4 py-3 rounded-lg border border-slate-200 bg-slate-50 focus:bg-white text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                        </div>
                        @error('price') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700 uppercase">Stock <span class="text-rose-500">*</span></label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required
                               class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-slate-50 focus:bg-white text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                        @error('stock') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Media & Visibility -->
            <div class="pt-8 border-t border-slate-100">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-widest mb-4">Media & Visibility</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <label class="text-xs font-bold text-slate-700 uppercase">Product Image</label>
                        
                        @if($product->image_url)
                        <div class="flex items-center gap-4 p-4 border border-slate-200 rounded-xl bg-slate-50">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-16 h-16 rounded-lg object-cover border border-slate-200 shadow-sm">
                            <div class="text-sm text-slate-500 font-medium">Current Image</div>
                        </div>
                        @endif
                        
                        <input type="file" name="image" accept="image/*"
                               class="w-full px-4 py-2.5 rounded-lg border border-slate-200 bg-slate-50 text-sm focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-all cursor-pointer">
                        <p class="text-[11px] text-slate-500 mt-1">Upload a new image to replace the current one (Max 2MB).</p>
                        @error('image') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="space-y-2 flex flex-col justify-center">
                        <label class="text-xs font-bold text-slate-700 uppercase mb-2">Visibility Status</label>
                        <div class="flex items-center gap-3">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                            </label>
                            <span class="text-sm font-medium text-slate-700">Active (Visible on Storefront)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
            <a href="{{ route('admin.products.index') }}" class="px-6 py-2.5 bg-white border border-slate-200 text-slate-700 font-semibold text-sm rounded-lg hover:bg-slate-50 transition-all shadow-sm">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-semibold text-sm rounded-lg shadow-lg shadow-indigo-200 hover:bg-indigo-700 active:scale-95 transition-all">
                Update Product
            </button>
        </div>
    </form>
</div>
@endsection