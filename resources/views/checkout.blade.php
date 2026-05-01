@extends('layouts.app')

@section('title', 'Checkout | GIVIA')

@section('content')
<div class="bg-slate-50 min-h-screen pt-24 pb-24">
    <div class="max-w-[1280px] mx-auto px-6">
        <div class="mb-8 flex items-center gap-2 text-sm text-slate-500">
            <a href="{{ route('cart.index') }}" class="hover:text-primary-600 transition-colors flex items-center gap-1">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span> Return to Cart
            </a>
        </div>

        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                <!-- Left side: Form Details -->
                <div class="lg:col-span-7 space-y-8">
                    
                    @if ($errors->any() || session('error'))
                        <div class="bg-rose-50 border border-rose-100 text-rose-600 px-4 py-3 rounded-xl flex items-start gap-3">
                            <span class="material-symbols-outlined text-[20px]">error</span>
                            <div class="text-sm">
                                @if (session('error'))
                                    <p>{{ session('error') }}</p>
                                @endif
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Contact Info -->
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-glass p-8">
                        <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center text-xs">1</span> 
                            Contact Information
                        </h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Email Address</label>
                                <input type="email" name="email" value="{{ Auth::user()->email ?? old('email') }}" required {{ Auth::check() ? 'readonly' : '' }} class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all {{ Auth::check() ? 'text-slate-500 cursor-not-allowed' : '' }}">
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-glass p-8">
                        <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center text-xs">2</span> 
                            Shipping Address
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Full Name</label>
                                <input type="text" name="name" value="{{ Auth::user()->name ?? old('name') }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Address</label>
                                <input type="text" name="address" value="{{ old('address') }}" required placeholder="Street address or P.O. Box" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">City</label>
                                <input type="text" name="city" value="{{ old('city') }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Postal Code</label>
                                <input type="text" name="postal_code" value="{{ old('postal_code') }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Country</label>
                                <select name="country" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all appearance-none">
                                    <option value="US">United States</option>
                                    <option value="CA">Canada</option>
                                    <option value="UK">United Kingdom</option>
                                    <option value="AU">Australia</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Phone</label>
                                <input type="tel" name="phone" value="{{ old('phone') }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all">
                            </div>
                        </div>
                    </div>

                    <!-- Payment -->
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-glass p-8">
                        <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center text-xs">3</span> 
                            Payment Method
                        </h2>
                        
                        <div class="space-y-4">
                            <label class="relative flex items-start gap-4 p-4 border border-primary-500 bg-primary-50/50 rounded-xl cursor-pointer">
                                <div class="flex items-center h-5">
                                    <input type="radio" name="payment_method" value="online_banking" checked class="w-4 h-4 text-primary-600 border-slate-300 focus:ring-primary-500">
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-semibold text-slate-900">Credit Card / Online Banking (Demo)</span>
                                        <div class="flex gap-1">
                                            <span class="material-symbols-outlined text-slate-400">credit_card</span>
                                        </div>
                                    </div>
                                    <p class="text-xs text-slate-500 mt-1">Pay securely with your credit or debit card.</p>
                                </div>
                            </label>

                            <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl space-y-4">
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Card Number</label>
                                    <input type="text" placeholder="0000 0000 0000 0000" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all" readonly value="4242 4242 4242 4242">
                                    <p class="text-[10px] text-slate-400 mt-1">This is a demo environment. No real payment is processed.</p>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Expiry</label>
                                        <input type="text" placeholder="MM/YY" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all" readonly value="12/28">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">CVC</label>
                                        <input type="text" placeholder="123" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all" readonly value="123">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right side: Order Summary -->
                <div class="lg:col-span-5">
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-glass p-8 sticky top-24">
                        <h2 class="text-xl font-bold text-slate-900 mb-6">Order Summary</h2>
                        
                        <div class="divide-y divide-slate-100 mb-6 max-h-[40vh] overflow-y-auto pr-2">
                            @foreach($cart->items as $item)
                                <div class="py-4 flex gap-4">
                                    <div class="w-16 h-16 bg-slate-50 rounded-lg overflow-hidden border border-slate-100 flex-shrink-0">
                                        @if($item->product && $item->product->image_url)
                                            <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                        @elseif($item->product && $item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                <span class="material-symbols-outlined text-[20px]">image</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-slate-900 text-sm line-clamp-1">{{ $item->product ? $item->product->name : 'Unknown Product' }}</h4>
                                        <p class="text-xs text-slate-500 mt-1">Qty: {{ $item->quantity }}</p>
                                        <p class="text-sm font-bold text-slate-900 mt-1">${{ number_format(($item->product ? $item->product->price : 0) * $item->quantity, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="space-y-4 text-sm text-slate-600 border-t border-slate-100 pt-6 mb-6">
                            <div class="flex justify-between items-center">
                                <span>Subtotal</span>
                                <span class="font-medium text-slate-900">${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span>Shipping</span>
                                <span class="font-medium text-slate-900">$10.00</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span>Taxes (Estimated)</span>
                                <span class="font-medium text-slate-900">${{ number_format($total * 0.05, 2) }}</span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-end mb-8 pt-6 border-t border-slate-100">
                            <div>
                                <span class="block text-sm font-semibold text-slate-900 uppercase tracking-wider mb-1">Total</span>
                            </div>
                            <span class="text-2xl font-bold text-primary-600">${{ number_format($total + 10 + ($total * 0.05), 2) }}</span>
                        </div>

                        <button type="submit" class="w-full bg-slate-900 hover:bg-primary-600 text-white rounded-xl py-4 font-medium transition-all shadow-lg shadow-slate-900/10 hover:shadow-primary-600/20 flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-[20px]">lock</span> Pay Now
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection