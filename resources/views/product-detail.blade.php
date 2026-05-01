@extends('layouts.app')

@section('title', $product->name . ' | GIVIA')

@section('content')
<div class="bg-white pb-24 mt-20">
    <!-- Breadcrumb -->
    <div class="border-b border-slate-100 bg-slate-50">
        <div class="max-w-[1280px] mx-auto px-6 py-4">
            <nav class="flex text-xs text-slate-500 font-medium">
                <a href="/" class="hover:text-primary-600 transition-colors">Home</a>
                <span class="mx-2 material-symbols-outlined text-[14px]">chevron_right</span>
                <a href="{{ route('products.index') }}" class="hover:text-primary-600 transition-colors">Shop</a>
                <span class="mx-2 material-symbols-outlined text-[14px]">chevron_right</span>
                @if($product->category)
                    <a href="{{ route('products.index', ['category' => $product->category_id]) }}" class="hover:text-primary-600 transition-colors">{{ $product->category->name }}</a>
                    <span class="mx-2 material-symbols-outlined text-[14px]">chevron_right</span>
                @endif
                <span class="text-slate-900 truncate max-w-[200px] sm:max-w-none">{{ $product->name }}</span>
            </nav>
        </div>
    </div>

    <div class="max-w-[1280px] mx-auto px-6 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
            
            <!-- Product Images -->
            <div class="space-y-4">
                <div class="aspect-square bg-slate-50 rounded-3xl border border-slate-100 overflow-hidden relative group">
                    @if($product->image_url || $product->image)
                        <img src="{{ $product->image_url ?? asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" id="main-image">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                            <span class="material-symbols-outlined text-8xl">image</span>
                        </div>
                    @endif
                    
                    @if($product->stock <= 5 && $product->stock > 0)
                        <div class="absolute top-6 left-6 bg-rose-500 text-white text-xs font-bold uppercase tracking-wider px-3 py-1.5 rounded-full shadow-lg shadow-rose-500/20">
                            Low Stock
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div class="flex flex-col">
                <div class="mb-8 border-b border-slate-100 pb-8">
                    @if($product->category)
                        <span class="text-xs font-bold text-primary-600 uppercase tracking-widest mb-2 block">{{ $product->category->name }}</span>
                    @endif
                    <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight mb-4">{{ $product->name }}</h1>
                    
                    <div class="flex items-end gap-4 mb-6">
                        <span class="text-3xl font-bold text-slate-900">${{ number_format($product->price, 2) }}</span>
                    </div>

                    <p class="text-slate-500 leading-relaxed">{{ $product->description }}</p>
                </div>

                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-semibold text-slate-900 uppercase tracking-wider">Availability</span>
                        @if($product->stock > 0)
                            <span class="inline-flex items-center gap-1.5 text-sm font-medium text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> In Stock ({{ $product->stock }})
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 text-sm font-medium text-rose-600 bg-rose-50 px-3 py-1 rounded-full">
                                <span class="w-2 h-2 rounded-full bg-rose-500"></span> Out of Stock
                            </span>
                        @endif
                    </div>
                </div>

                @if($product->stock > 0)
                <!-- Add to Cart Form -->
                <div class="mt-auto">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-32 bg-slate-50 border border-slate-200 rounded-xl p-1 flex items-center justify-between">
                            <button type="button" onclick="decrementQty()" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-500 hover:bg-white hover:shadow-sm transition-all focus:outline-none">
                                <span class="material-symbols-outlined text-[18px]">remove</span>
                            </button>
                            <input type="number" id="qty-input" value="1" min="1" max="{{ $product->stock }}" class="w-10 text-center bg-transparent border-none focus:outline-none text-slate-900 font-semibold text-sm appearance-none" readonly>
                            <button type="button" onclick="incrementQty()" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-500 hover:bg-white hover:shadow-sm transition-all focus:outline-none">
                                <span class="material-symbols-outlined text-[18px]">add</span>
                            </button>
                        </div>
                        <p class="text-xs text-slate-400">Limit {{ $product->stock }} per order</p>
                    </div>

                    <div class="flex gap-4">
                        <button onclick="addToCart(false)" class="flex-1 bg-slate-900 hover:bg-primary-600 text-white rounded-xl py-4 font-medium transition-all shadow-lg shadow-slate-900/10 hover:shadow-primary-600/20 flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-[20px]">add_shopping_cart</span> Add to Cart
                        </button>
                        <button onclick="addToCart(true)" class="flex-1 bg-primary-600 hover:bg-primary-700 text-white rounded-xl py-4 font-medium transition-all shadow-lg shadow-primary-600/20 flex items-center justify-center gap-2">
                            Buy Now
                        </button>
                    </div>
                </div>
                @else
                <div class="mt-auto">
                    <button disabled class="w-full bg-slate-100 text-slate-400 rounded-xl py-4 font-medium cursor-not-allowed flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[20px]">block</span> Out of Stock
                    </button>
                </div>
                @endif
                
                <!-- Features -->
                <div class="mt-12 grid grid-cols-2 gap-4 border-t border-slate-100 pt-8">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-primary-500">
                            <span class="material-symbols-outlined text-[20px]">local_shipping</span>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-900">Free Shipping</p>
                            <p class="text-[10px] text-slate-500">Orders over $150</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-primary-500">
                            <span class="material-symbols-outlined text-[20px]">security</span>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-900">Secure Checkout</p>
                            <p class="text-[10px] text-slate-500">100% Protected</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Related Products -->
@if(isset($relatedProducts) && $relatedProducts->count() > 0)
<section class="border-t border-slate-100 bg-slate-50 py-24">
    <div class="max-w-[1280px] mx-auto px-6">
        <h2 class="text-2xl font-bold text-slate-900 mb-8">You may also like</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedProducts as $related)
                <a href="{{ route('products.show', $related->id) }}" class="group bg-white rounded-2xl p-4 transition-all hover:shadow-glass border border-slate-100 flex flex-col h-full">
                    <div class="relative aspect-square rounded-xl overflow-hidden mb-4 bg-slate-50">
                        @if($related->image)
                            <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <span class="material-symbols-outlined text-6xl">image</span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-slate-900 mb-1 group-hover:text-primary-600 transition-colors">{{ $related->name }}</h3>
                            <p class="text-sm text-slate-500 line-clamp-2 mb-4">{{ Str::limit($related->description, 60) }}</p>
                        </div>
                        <div class="flex items-center justify-between mt-auto">
                            <span class="text-lg font-bold text-slate-900">${{ number_format($related->price, 2) }}</span>
                            <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-600 group-hover:bg-primary-600 group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@push('scripts')
<script>
    const maxStock = {{ $product->stock }};
    const input = document.getElementById('qty-input');
    
    function incrementQty() {
        if(parseInt(input.value) < maxStock) {
            input.value = parseInt(input.value) + 1;
        }
    }
    
    function decrementQty() {
        if(parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }

    function addToCart(redirectCheckout = false) {
        const qty = parseInt(input.value);
        
        fetch('/api/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                product_id: {{ $product->id }},
                quantity: qty
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if(redirectCheckout) {
                    window.location.href = '/checkout';
                } else {
                    showToast(data.message, 'success');
                    updateCartCounter();
                }
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