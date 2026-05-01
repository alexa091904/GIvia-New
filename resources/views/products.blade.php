@extends('layouts.app')

@section('title', 'Shop | GIVIA')

@section('content')
<!-- Header Banner -->
<div class="bg-slate-900 py-16 relative overflow-hidden mt-20">
    <div class="absolute inset-0 bg-gradient-to-r from-primary-900/50 to-purple-900/50"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-primary-500/20 rounded-full blur-3xl"></div>
    <div class="max-w-[1280px] mx-auto px-6 relative z-10 text-center">
        <h1 class="text-4xl font-bold text-white mb-4">Our Collection</h1>
        <p class="text-white/80 max-w-xl mx-auto">Browse our curated selection of premium goods, designed to elevate your everyday living experience.</p>
    </div>
</div>

<div class="max-w-[1280px] mx-auto px-6 py-12">
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Sidebar Filters -->
        <aside class="w-full lg:w-64 flex-shrink-0">
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm sticky top-24">
                <form action="{{ route('products.index') }}" method="GET" id="filter-form">
                    <!-- Search inside filter (mobile fallback) -->
                    <div class="mb-6 lg:hidden">
                        <label class="block text-xs font-semibold text-slate-900 uppercase tracking-wider mb-3">Search</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="w-full bg-slate-50 border border-slate-200 rounded-lg pl-10 pr-4 py-2 text-sm focus:outline-none focus:border-primary-500">
                            <span class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-[20px]">search</span>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="mb-8 border-b border-slate-100 pb-8">
                        <label class="flex text-xs font-semibold text-slate-900 uppercase tracking-wider mb-4 items-center justify-between">
                            Categories
                            @if(request('category'))
                                <a href="{{ route('products.index', request()->except('category')) }}" class="text-[10px] text-rose-500 hover:text-rose-600 font-bold">Clear</a>
                            @endif
                        </label>
                        <div class="space-y-3">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" name="category" value="" onchange="this.form.submit()" class="hidden" {{ !request('category') ? 'checked' : '' }}>
                                <div class="w-4 h-4 rounded-full border {{ !request('category') ? 'border-4 border-primary-600 bg-white' : 'border-slate-300 group-hover:border-primary-400' }} transition-all flex-shrink-0"></div>
                                <span class="text-sm {{ !request('category') ? 'text-slate-900 font-medium' : 'text-slate-600' }}">All Categories</span>
                            </label>
                            @foreach($categories as $category)
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" name="category" value="{{ $category->id }}" onchange="this.form.submit()" class="hidden" {{ request('category') == $category->id ? 'checked' : '' }}>
                                    <div class="w-4 h-4 rounded-full border {{ request('category') == $category->id ? 'border-4 border-primary-600 bg-white' : 'border-slate-300 group-hover:border-primary-400' }} transition-all flex-shrink-0"></div>
                                    <span class="text-sm {{ request('category') == $category->id ? 'text-slate-900 font-medium' : 'text-slate-600' }} flex-1">{{ $category->name }}</span>
                                    <span class="text-xs text-slate-400 bg-slate-50 px-2 py-0.5 rounded-full">{{ $category->products_count }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Availability -->
                    <div class="mb-8">
                        <label class="flex text-xs font-semibold text-slate-900 uppercase tracking-wider mb-4 items-center justify-between">
                            Availability
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" name="in_stock" value="1" onchange="this.form.submit()" {{ request('in_stock') ? 'checked' : '' }} class="hidden peer">
                            <div class="w-5 h-5 rounded border border-slate-300 peer-checked:border-primary-600 peer-checked:bg-primary-600 flex items-center justify-center transition-colors">
                                <span class="material-symbols-outlined text-[14px] text-white opacity-0 peer-checked:opacity-100 font-bold transition-opacity">check</span>
                            </div>
                            <span class="text-sm text-slate-600 peer-checked:text-slate-900 font-medium">In Stock Only</span>
                        </label>
                    </div>

                    <!-- Preserve sorting params -->
                    <input type="hidden" name="sort" value="{{ request('sort', 'created_at') }}">
                    <input type="hidden" name="order" value="{{ request('order', 'desc') }}">
                </form>
            </div>
        </aside>

        <!-- Product Grid -->
        <div class="flex-1">
            <!-- Toolbar -->
            <div class="bg-white rounded-2xl border border-slate-100 p-4 mb-6 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-2 text-sm text-slate-500">
                    Showing <span class="font-bold text-slate-900">{{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }}</span> of <span class="font-bold text-slate-900">{{ $products->total() }}</span> products
                </div>

                <div class="flex items-center gap-4">
                    <!-- Search -->
                    <form action="{{ route('products.index') }}" method="GET" class="hidden md:block relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="w-64 bg-slate-50 border border-slate-200 rounded-lg pl-10 pr-4 py-2 text-sm focus:outline-none focus:border-primary-500 transition-all focus:w-72">
                        <span class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-[20px]">search</span>
                        @if(request('search'))
                            <a href="{{ route('products.index', request()->except('search')) }}" class="absolute right-3 top-2.5 text-rose-400 hover:text-rose-600">
                                <span class="material-symbols-outlined text-[20px]">close</span>
                            </a>
                        @endif
                        @foreach(request()->except(['search', 'page']) as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                    </form>

                    <!-- Sort -->
                    <div class="relative group">
                        <button class="flex items-center gap-2 text-sm font-medium text-slate-700 bg-slate-50 px-4 py-2 rounded-lg border border-slate-200 hover:border-slate-300 transition-colors">
                            Sort by: 
                            @if(request('sort') == 'price' && request('order') == 'asc') Price: Low to High
                            @elseif(request('sort') == 'price' && request('order') == 'desc') Price: High to Low
                            @elseif(request('sort') == 'name') Name
                            @else Newest
                            @endif
                            <span class="material-symbols-outlined text-[18px]">expand_more</span>
                        </button>
                        <div class="absolute right-0 top-full mt-1 w-48 bg-white border border-slate-100 rounded-xl shadow-glass opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-20">
                            <div class="p-1">
                                <a href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'created_at', 'order' => 'desc'])) }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-primary-50 hover:text-primary-600 rounded-lg {{ request('sort', 'created_at') == 'created_at' ? 'bg-primary-50 text-primary-600 font-medium' : '' }}">Newest</a>
                                <a href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'price', 'order' => 'asc'])) }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-primary-50 hover:text-primary-600 rounded-lg {{ request('sort') == 'price' && request('order') == 'asc' ? 'bg-primary-50 text-primary-600 font-medium' : '' }}">Price: Low to High</a>
                                <a href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'price', 'order' => 'desc'])) }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-primary-50 hover:text-primary-600 rounded-lg {{ request('sort') == 'price' && request('order') == 'desc' ? 'bg-primary-50 text-primary-600 font-medium' : '' }}">Price: High to Low</a>
                                <a href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'name', 'order' => 'asc'])) }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-primary-50 hover:text-primary-600 rounded-lg {{ request('sort') == 'name' ? 'bg-primary-50 text-primary-600 font-medium' : '' }}">Name (A-Z)</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grid -->
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($products as $product)
                        <div class="group bg-white rounded-2xl p-4 transition-all hover:shadow-glass border border-slate-100 flex flex-col relative">
                            <!-- Image -->
                            <a href="{{ route('products.show', $product->id) }}" class="relative aspect-square rounded-xl overflow-hidden mb-4 bg-slate-50 block">
                                @if($product->image_url || $product->image)
                                    <img src="{{ $product->image_url ?? asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                                        <span class="material-symbols-outlined text-6xl">image</span>
                                    </div>
                                @endif
                                
                                @if($product->stock <= 5 && $product->stock > 0)
                                    <div class="absolute top-3 left-3 bg-rose-500 text-white text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded-full">
                                        Low Stock
                                    </div>
                                @elseif($product->stock <= 0)
                                    <div class="absolute inset-0 bg-white/60 backdrop-blur-[2px] flex items-center justify-center">
                                        <span class="bg-slate-900 text-white text-xs font-bold uppercase tracking-wider px-3 py-1.5 rounded-full">Out of Stock</span>
                                    </div>
                                @endif
                            </a>
                            
                            <!-- Info -->
                            <div class="flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="text-[10px] font-semibold text-primary-600 uppercase tracking-wider mb-1">{{ $product->category->name ?? 'Uncategorized' }}</div>
                                    <a href="{{ route('products.show', $product->id) }}">
                                        <h3 class="font-semibold text-slate-900 mb-1 group-hover:text-primary-600 transition-colors">{{ $product->name }}</h3>
                                    </a>
                                </div>
                                <div class="flex items-center justify-between mt-4">
                                    <span class="text-lg font-bold text-slate-900">${{ number_format($product->price, 2) }}</span>
                                    
                                    @if($product->stock > 0)
                                    <button type="button" onclick="addToCart({{ $product->id }})" class="w-10 h-10 rounded-full bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-700 hover:bg-primary-600 hover:border-primary-600 hover:text-white transition-all shadow-sm group-hover:shadow hover:-translate-y-0.5">
                                        <span class="material-symbols-outlined text-[20px]">add_shopping_cart</span>
                                    </button>
                                    @else
                                    <button disabled class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 cursor-not-allowed">
                                        <span class="material-symbols-outlined text-[20px]">remove_shopping_cart</span>
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-2xl border border-slate-100 p-16 flex flex-col items-center justify-center text-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-6">
                        <span class="material-symbols-outlined text-4xl">search_off</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">No products found</h3>
                    <p class="text-slate-500 max-w-sm mb-6">We couldn't find any products matching your current filters. Try adjusting your search criteria.</p>
                    <a href="{{ route('products.index') }}" class="px-6 py-2.5 bg-slate-900 text-white rounded-xl font-medium hover:bg-primary-600 transition-colors">Clear All Filters</a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    function addToCart(productId) {
        fetch('/api/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: 1
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                updateCartCounter();
            } else {
                showToast(data.message || 'Error adding to cart', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Failed to add item to cart', 'error');
        });
    }
</script>
@endpush
@endsection