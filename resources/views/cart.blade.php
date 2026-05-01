@extends('layouts.app')

@section('title', 'Shopping Cart | GIVIA')

@section('content')
<div class="bg-slate-50 min-h-screen pt-24 pb-24">
    <div class="max-w-[1280px] mx-auto px-6">
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight mb-8">Shopping Cart</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12" id="cart-container">
            <!-- Left side: Cart Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl border border-slate-100 shadow-glass overflow-hidden">
                    
                    @if($cart && $cart->items->count() > 0)
                        <div class="hidden sm:grid grid-cols-12 gap-4 p-6 border-b border-slate-100 bg-slate-50/50">
                            <div class="col-span-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Product</div>
                            <div class="col-span-3 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">Quantity</div>
                            <div class="col-span-3 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Total</div>
                        </div>

                        <div class="divide-y divide-slate-100" id="cart-items-list">
                            @foreach($cart->items as $item)
                                <div class="p-6 grid grid-cols-1 sm:grid-cols-12 gap-6 items-center cart-item" data-id="{{ $item->id }}">
                                    <!-- Product Info -->
                                    <div class="col-span-1 sm:col-span-6 flex items-center gap-4">
                                        <a href="{{ route('products.show', $item->product_id) }}" class="w-20 h-20 bg-slate-50 rounded-xl overflow-hidden flex-shrink-0 border border-slate-100">
                                            @if($item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                    <span class="material-symbols-outlined text-2xl">image</span>
                                                </div>
                                            @endif
                                        </a>
                                        <div>
                                            <a href="{{ route('products.show', $item->product_id) }}" class="font-semibold text-slate-900 hover:text-primary-600 transition-colors">{{ $item->product->name }}</a>
                                            <div class="text-sm text-slate-500 mt-1">${{ number_format($item->product->price, 2) }}</div>
                                            
                                            <!-- Mobile Remove -->
                                            <button onclick="removeFromCart({{ $item->id }})" class="sm:hidden text-xs text-rose-500 font-medium hover:text-rose-600 mt-2 flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">delete</span> Remove
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Quantity -->
                                    <div class="col-span-1 sm:col-span-3 flex items-center sm:justify-center">
                                        <div class="w-28 bg-slate-50 border border-slate-200 rounded-lg p-1 flex items-center justify-between">
                                            <button onclick="updateCart({{ $item->id }}, -1)" class="w-7 h-7 flex items-center justify-center rounded text-slate-500 hover:bg-white hover:shadow-sm transition-all">
                                                <span class="material-symbols-outlined text-[16px]">remove</span>
                                            </button>
                                            <span class="w-8 text-center text-slate-900 font-medium text-sm item-qty">{{ $item->quantity }}</span>
                                            <button onclick="updateCart({{ $item->id }}, 1)" class="w-7 h-7 flex items-center justify-center rounded text-slate-500 hover:bg-white hover:shadow-sm transition-all">
                                                <span class="material-symbols-outlined text-[16px]">add</span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Total & Remove -->
                                    <div class="col-span-1 sm:col-span-3 flex items-center justify-between sm:justify-end gap-4">
                                        <div class="font-bold text-slate-900 item-total">${{ number_format($item->product->price * $item->quantity, 2) }}</div>
                                        <button onclick="removeFromCart({{ $item->id }})" class="hidden sm:flex w-8 h-8 items-center justify-center rounded-lg text-slate-400 hover:bg-rose-50 hover:text-rose-500 transition-colors" title="Remove item">
                                            <span class="material-symbols-outlined text-[20px]">delete</span>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-16 flex flex-col items-center justify-center text-center">
                            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-6">
                                <span class="material-symbols-outlined text-5xl">shopping_cart</span>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 mb-2">Your cart is empty</h3>
                            <p class="text-slate-500 mb-8 max-w-sm">Looks like you haven't added any products to your cart yet.</p>
                            <a href="{{ route('products.index') }}" class="px-8 py-3 bg-slate-900 hover:bg-primary-600 text-white rounded-xl font-medium transition-all shadow-lg shadow-slate-900/10 hover:shadow-primary-600/20">
                                Start Shopping
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right side: Summary -->
            @if($cart && $cart->items->count() > 0)
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl border border-slate-100 shadow-glass p-8 sticky top-24">
                    <h2 class="text-xl font-bold text-slate-900 mb-6">Order Summary</h2>
                    
                    <div class="space-y-4 text-sm text-slate-600 border-b border-slate-100 pb-6 mb-6">
                        <div class="flex justify-between items-center">
                            <span>Subtotal</span>
                            <span class="font-medium text-slate-900" id="summary-subtotal">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Shipping</span>
                            <span class="font-medium text-emerald-600">Calculated at checkout</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Taxes</span>
                            <span class="font-medium text-slate-900">Calculated at checkout</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-end mb-8">
                        <div>
                            <span class="block text-sm font-semibold text-slate-900 uppercase tracking-wider mb-1">Estimated Total</span>
                        </div>
                        <span class="text-2xl font-bold text-slate-900" id="summary-total">${{ number_format($total, 2) }}</span>
                    </div>

                    <a href="{{ route('checkout') }}" class="w-full bg-primary-600 hover:bg-primary-700 text-white rounded-xl py-4 font-medium transition-all shadow-lg shadow-primary-600/20 flex items-center justify-center gap-2 mb-4">
                        Proceed to Checkout <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                    </a>
                    
                    <div class="flex items-center justify-center gap-2 text-xs text-slate-500">
                        <span class="material-symbols-outlined text-[16px] text-emerald-500">lock</span> Secure Encrypted Checkout
                    </div>
                </div>
            </div>
            @endif
        </div>
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