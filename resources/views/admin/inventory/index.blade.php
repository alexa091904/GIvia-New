@extends('admin.layouts.admin')

@section('page-title', 'Inventory')

@section('content')
<!-- Header Section -->
<div class="mb-8 flex items-end justify-between">
    <div>
        <h2 class="text-3xl font-black text-slate-900 tracking-tight">Inventory</h2>
        <p class="text-slate-500 text-sm mt-1">Monitor and manage stock levels across your entire product catalog.</p>
    </div>
    <div class="flex gap-2">
        <button class="flex items-center gap-2 px-4 py-2 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors">
            <span class="material-symbols-outlined text-sm">file_download</span>
            <span class="font-semibold text-sm">Export CSV</span>
        </button>
    </div>
</div>

<!-- Filter Bar -->
<div class="bg-white p-4 rounded-2xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-slate-100 mb-8 flex flex-wrap gap-4 items-center">
    <div class="relative flex-1 min-w-[300px]">
        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
        <input class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all outline-none" placeholder="Search inventory..." type="text"/>
    </div>
    <div class="flex items-center gap-2">
        <span class="text-xs font-semibold text-slate-500">Stock Status:</span>
        <select class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none">
            <option>All</option>
            <option>In Stock</option>
            <option>Low Stock</option>
            <option>Out of Stock</option>
        </select>
    </div>
    <button class="flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-50 text-slate-700 hover:bg-slate-100 transition-colors">
        <span class="material-symbols-outlined text-sm">tune</span>
        <span class="text-xs font-semibold">Advanced Filters</span>
    </button>
</div>

<!-- Data Table Card -->
<div class="bg-white rounded-2xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] overflow-hidden border border-slate-100 mb-8">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">SKU</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Current Stock</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($products as $product)
                <tr class="hover:bg-slate-50/80 transition-colors">
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
                                <p class="text-sm font-semibold text-slate-900">{{ $product->name }}</p>
                                <p class="text-xs text-slate-500">{{ $product->category->name ?? 'Uncategorized' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600 font-mono">{{ $product->sku ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-sm font-bold {{ $product->stock <= 5 ? 'text-rose-600' : 'text-slate-900' }}">{{ $product->stock }}</td>
                    <td class="px-6 py-4">
                        @if($product->stock <= 0)
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-rose-50 text-rose-700 text-xs font-bold border border-rose-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-2"></span> Out of Stock
                            </span>
                        @elseif($product->stock <= 5)
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-bold border border-amber-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-2"></span> Low Stock
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-2"></span> In Stock
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.inventory.adjust', $product->id) }}" method="POST" class="flex items-center gap-2 m-0">
                            @csrf
                            <input type="number" name="quantity" class="w-24 bg-slate-50 border border-slate-200 rounded-lg px-3 py-1.5 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none" placeholder="+/- qty" required>
                            <button type="submit" class="bg-indigo-50 text-indigo-700 hover:bg-indigo-100 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">
                                Adjust
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-slate-500">No products found.</td>
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