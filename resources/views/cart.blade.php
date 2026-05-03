@extends('layouts.app')

@section('title', 'Shopping Cart | GIVIA')

@section('content')
<div class="bg-slate-50 min-h-screen pt-24 pb-24">
    <div class="max-w-[1280px] mx-auto px-6">
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight mb-8">Shopping Cart</h1>

        @if($cart && $cart->items->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12" id="cart-container">
            <!-- Left side: Cart Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl border border-slate-100 shadow-[0px_4px_20px_rgba(0,0,0,0.03)] overflow-hidden">
                    <div class="hidden sm:grid grid-cols-12 gap-4 p-6 border-b border-slate-100 bg-slate-50/50">
                        <div class="col-span-6 text-xs font-bold text-slate-500 uppercase tracking-wider">Product</div>
                        <div class="col-span-3 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Quantity</div>
                        <div class="col-span-3 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Total</div>
                    </div>

                    <div class="divide-y divide-slate-100" id="cart-items-list">
                        @foreach($cart->items as $item)
                            <div class="p-6 grid grid-cols-1 sm:grid-cols-12 gap-6 items-center cart-item" data-id="{{ $item->id }}">
                                <!-- Product Info -->
                                <div class="col-span-1 sm:col-span-6 flex items-center gap-4">
                                    <a href="{{ route('products.show', $item->product_id) }}" class="w-20 h-20 bg-slate-50 rounded-xl overflow-hidden flex-shrink-0 border border-slate-100">
                                        @if($item->product->image_url || $item->product->image)
                                            <img src="{{ $item->product->image_url ?? asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                <span class="material-symbols-outlined text-2xl">image</span>
                                            </div>
                                        @endif
                                    </a>
                                    <div>
                                        <a href="{{ route('products.show', $item->product_id) }}" class="font-bold text-slate-900 hover:text-slate-600 transition-colors line-clamp-1">{{ $item->product->name }}</a>
                                        <div class="text-sm font-semibold text-slate-500 mt-1">₱{{ number_format($item->product->price, 2) }}</div>
                                        
                                        <!-- Mobile Remove -->
                                        <button onclick="removeFromCart({{ $item->id }})" class="sm:hidden text-xs text-rose-500 font-bold hover:text-rose-600 mt-2 flex items-center gap-1 transition-colors">
                                            <span class="material-symbols-outlined text-[14px]">delete</span> Remove
                                        </button>
                                    </div>
                                </div>

                                <!-- Quantity -->
                                <div class="col-span-1 sm:col-span-3 flex items-center sm:justify-center">
                                    <div class="w-28 bg-slate-50 border border-slate-200 rounded-xl p-1 flex items-center justify-between">
                                        <button onclick="updateCart({{ $item->id }}, -1)" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-500 hover:bg-white hover:text-slate-900 hover:shadow-sm transition-all font-bold">
                                            <span class="material-symbols-outlined text-[16px]">remove</span>
                                        </button>
                                        <span class="w-8 text-center text-slate-900 font-bold text-sm item-qty">{{ $item->quantity }}</span>
                                        <button onclick="updateCart({{ $item->id }}, 1)" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-500 hover:bg-white hover:text-slate-900 hover:shadow-sm transition-all font-bold">
                                            <span class="material-symbols-outlined text-[16px]">add</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- Total & Remove -->
                                <div class="col-span-1 sm:col-span-3 flex items-center justify-between sm:justify-end gap-4">
                                    <div class="font-black text-slate-900 item-total">₱{{ number_format($item->product->price * $item->quantity, 2) }}</div>
                                    <button onclick="removeFromCart({{ $item->id }})" class="hidden sm:flex w-10 h-10 items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-rose-50 hover:text-rose-600 transition-all" title="Remove item">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right side: Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl border border-slate-100 shadow-[0px_4px_20px_rgba(0,0,0,0.03)] p-8 sticky top-28">
                    <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[24px]">receipt_long</span>
                        Order Summary
                    </h2>
                    
                    <div class="space-y-4 text-sm text-slate-600 border-b border-slate-100 pb-6 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-slate-500">Subtotal</span>
                            <span class="font-bold text-slate-900" id="summary-subtotal">₱{{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-slate-500">Shipping</span>
                            <span class="font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-md text-xs">Calculated at checkout</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-slate-500">Taxes</span>
                            <span class="font-bold text-slate-900">Calculated at checkout</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-end mb-8 border-b border-slate-100 pb-6">
                        <div>
                            <span class="block text-sm font-bold text-slate-900 uppercase tracking-wider mb-1">Estimated Total</span>
                        </div>
                        <span class="text-3xl font-black text-slate-900 tracking-tight" id="summary-total">₱{{ number_format($total, 2) }}</span>
                    </div>

                    <a href="{{ route('checkout') }}" class="w-full bg-slate-900 hover:bg-slate-800 text-white rounded-2xl py-4 font-bold text-lg transition-all shadow-xl shadow-slate-900/20 transform hover:-translate-y-1 flex items-center justify-center gap-2 mb-6">
                        Checkout Now <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                    </a>
                    
                    <div class="flex items-center justify-center gap-2 text-xs font-semibold text-slate-500">
                        <span class="material-symbols-outlined text-[16px] text-emerald-500">lock</span> Secure Encrypted Checkout
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="max-w-2xl mx-auto mt-8" id="cart-container">
            <div class="bg-white rounded-3xl border border-slate-100 shadow-[0px_4px_20px_rgba(0,0,0,0.03)] p-12 md:p-16 flex flex-col items-center justify-center text-center">
                <div class="w-32 h-32 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-8 shadow-inner border border-slate-100">
                    <span class="material-symbols-outlined text-[64px]">shopping_cart</span>
                </div>
                <h3 class="text-3xl font-black text-slate-900 mb-4 tracking-tight">Your cart is empty</h3>
                <p class="text-lg text-slate-500 mb-10 max-w-md mx-auto leading-relaxed">Looks like you haven't added any products to your cart yet. Discover our amazing collection!</p>
                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-3 bg-slate-900 hover:bg-slate-800 text-white px-8 py-4 rounded-2xl font-bold text-lg transition-all shadow-xl shadow-slate-900/20 transform hover:-translate-y-1">
                    Start Shopping <span class="material-symbols-outlined text-[24px]">arrow_forward</span>
                </a>
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function updateCart(itemId, change) {
        const itemRow = document.querySelector(`.cart-item[data-id="${itemId}"]`);
        if (!itemRow) return;
        
        const currentQty = parseInt(itemRow.querySelector('.item-qty').textContent);
        const newQty = currentQty + change;
        
        if (newQty < 1) return; // Prevent zero or negative quantity via update
        
        fetch(`/api/cart/update/${itemId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                quantity: newQty
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update item quantity
                itemRow.querySelector('.item-qty').textContent = newQty;
                itemRow.querySelector('.item-total').textContent = '$' + parseFloat(data.item_subtotal).toFixed(2);
                
                // Update totals
                document.getElementById('summary-subtotal').textContent = '$' + data.cart_total.toFixed(2);
                document.getElementById('summary-total').textContent = '$' + data.cart_total.toFixed(2);
                
                updateCartCounter();
            } else {
                showToast(data.error || 'Error updating cart', 'error');
            }
        });
    }

    function removeFromCart(itemId) {
        fetch(`/api/cart/remove/${itemId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.cart_count === 0) {
                    window.location.reload();
                    return;
                }
                
                const itemRow = document.querySelector(`.cart-item[data-id="${itemId}"]`);
                if (itemRow) itemRow.remove();
                
                document.getElementById('summary-subtotal').textContent = '$' + data.cart_total.toFixed(2);
                document.getElementById('summary-total').textContent = '$' + data.cart_total.toFixed(2);
                
                showToast('Item removed from cart', 'success');
                updateCartCounter();
            }
        });
    }
</script>
@endpush
@endsection