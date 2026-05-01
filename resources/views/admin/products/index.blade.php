@extends('admin.layouts.admin')

@section('page-title', 'Products')

@section('content')
<!-- Page Header -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
    <div>
        <h2 class="text-3xl font-black text-slate-900 tracking-tight">Products</h2>
        <p class="text-slate-500 text-sm mt-1">Manage your catalog, stock levels, and product visibility.</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-2.5 rounded-xl shadow-lg shadow-indigo-200 flex items-center gap-2 hover:scale-[1.02] active:scale-[0.98] transition-all">
        <span class="material-symbols-outlined text-lg" data-icon="add_circle">add_circle</span>
        <span class="font-bold text-sm">Add New Product</span>
    </a>
</div>

<!-- Filter Bar -->
<div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 mb-6 flex flex-wrap items-center gap-4">
    <div class="flex-1 min-w-[240px] relative">
        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" data-icon="search">search</span>
        <input class="w-full bg-slate-50 border-slate-200 rounded-xl py-2 pl-10 text-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/5 transition-all" placeholder="Search products..." type="text"/>
    </div>
    <div class="w-full sm:w-auto">
        <select class="w-full bg-slate-50 border-slate-200 rounded-xl py-2 px-4 text-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/5 transition-all text-slate-600 font-medium">
            <option>All Categories</option>
            <option>Electronics</option>
            <option>Apparel</option>
            <option>Home &amp; Living</option>
            <option>Beauty</option>
        </select>
    </div>
    <div class="w-full sm:w-auto">
        <select class="w-full bg-slate-50 border-slate-200 rounded-xl py-2 px-4 text-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/5 transition-all text-slate-600 font-medium">
            <option>Availability</option>
            <option>In Stock</option>
            <option>Low Stock</option>
            <option>Out of Stock</option>
        </select>
    </div>
    <button class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-500 hover:bg-slate-100 transition-colors">
        <span class="material-symbols-outlined" data-icon="filter_list">filter_list</span>
    </button>
</div>

<!-- Data Table Card -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Stock Status</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($products as $product)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-slate-100 flex-shrink-0 overflow-hidden border border-slate-200 flex items-center justify-center text-slate-400">
                                @if($product->image_url)
                                    <img src="{{ $product->image_url }}" class="w-full h-full object-cover">
                                @else
                                    <span class="material-symbols-outlined">image</span>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-900">{{ $product->name }}</p>
                                <p class="text-xs text-slate-400">ID: {{ $product->id }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-full">{{ $product->category->name ?? 'Uncategorized' }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm font-bold text-slate-900">₱{{ number_format($product->price, 2) }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <div class="w-32">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-[10px] font-bold {{ $product->stock > 10 ? 'text-slate-500' : ($product->stock > 0 ? 'text-amber-600' : 'text-rose-600') }}">
                                    {{ $product->stock }} units
                                </span>
                            </div>
                            <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                @php
                                    $percentage = min(100, max(0, ($product->stock / max(1, 100)) * 100));
                                    $colorClass = $product->stock > 10 ? 'bg-emerald-500' : ($product->stock > 0 ? 'bg-amber-500' : 'bg-rose-500');
                                @endphp
                                <div class="h-full {{ $colorClass }} rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($product->is_active)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Inactive
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all">
                                <span class="material-symbols-outlined text-lg" data-icon="edit">edit</span>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all" onclick="return confirm('Delete this product?')">
                                    <span class="material-symbols-outlined text-lg" data-icon="delete">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-slate-500">No products found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(method_exists($products, 'links'))
    <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection