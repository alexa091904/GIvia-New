@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="pt-28 pb-12 min-h-screen bg-slate-50">
    <div class="max-w-[1280px] mx-auto px-6">
        
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-br from-slate-900 via-primary-900 to-indigo-900 rounded-3xl shadow-2xl mb-8 overflow-hidden relative border border-slate-800">
            <div class="absolute top-0 right-0 w-96 h-96 bg-primary-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 translate-y-1/2 -translate-x-1/2 pointer-events-none"></div>
            <div class="relative px-8 py-10 md:py-16 md:px-12">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-black text-white mb-3 tracking-tight">
                            Welcome back, {{ Auth::user()->name }}!
                        </h1>
                        <p class="text-indigo-200 text-base md:text-lg max-w-xl">
                            Here's what's happening with your store today. Track your orders, review your history, and discover new products.
                        </p>
                    </div>
                    <div class="mt-2 md:mt-0 flex-shrink-0">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-6 py-3.5 bg-white text-slate-900 rounded-xl font-bold hover:bg-slate-50 shadow-xl shadow-white/10 transition-all transform hover:scale-105 active:scale-95">
                            <span class="material-symbols-outlined text-[20px]">shopping_bag</span>
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <a href="{{ route('products.index') }}" class="bg-white rounded-2xl shadow-[0px_4px_20px_rgba(0,0,0,0.03)] border border-slate-100 p-6 text-center hover:-translate-y-1 hover:shadow-xl transition-all duration-300 group">
                <div class="w-12 h-12 mx-auto bg-primary-50 rounded-xl flex items-center justify-center text-primary-600 mb-4 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-[24px]">search</span>
                </div>
                <p class="text-sm font-bold text-slate-900">Browse Products</p>
            </a>
            <a href="{{ route('cart.index') }}" class="bg-white rounded-2xl shadow-[0px_4px_20px_rgba(0,0,0,0.03)] border border-slate-100 p-6 text-center hover:-translate-y-1 hover:shadow-xl transition-all duration-300 group">
                <div class="w-12 h-12 mx-auto bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 mb-4 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-[24px]">shopping_cart</span>
                </div>
                <p class="text-sm font-bold text-slate-900">View Cart</p>
            </a>
            <a href="{{ route('orders.index') }}" class="bg-white rounded-2xl shadow-[0px_4px_20px_rgba(0,0,0,0.03)] border border-slate-100 p-6 text-center hover:-translate-y-1 hover:shadow-xl transition-all duration-300 group">
                <div class="w-12 h-12 mx-auto bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 mb-4 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-[24px]">local_shipping</span>
                </div>
                <p class="text-sm font-bold text-slate-900">Track Orders</p>
            </a>
            <a href="{{ route('profile') }}" class="bg-white rounded-2xl shadow-[0px_4px_20px_rgba(0,0,0,0.03)] border border-slate-100 p-6 text-center hover:-translate-y-1 hover:shadow-xl transition-all duration-300 group">
                <div class="w-12 h-12 mx-auto bg-rose-50 rounded-xl flex items-center justify-center text-rose-600 mb-4 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-[24px]">settings</span>
                </div>
                <p class="text-sm font-bold text-slate-900">Account Settings</p>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Column (Recent Orders) -->
            <div class="lg:col-span-8 space-y-8">
                <div class="bg-white rounded-3xl border border-slate-100 shadow-[0px_4px_20px_rgba(0,0,0,0.03)] overflow-hidden">
                    <div class="p-8 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                        <h2 class="text-xl font-bold text-slate-900 flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600">
                                <span class="material-symbols-outlined text-[20px]">receipt_long</span>
                            </span>
                            Recent Orders
                        </h2>
                        <a href="{{ route('orders.index') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-700 flex items-center gap-1 group">
                            View All <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </a>
                    </div>
                    
                    <div class="p-0">
                        @if(isset($recentOrders) && count($recentOrders) > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-slate-50/50 border-b border-slate-100">
                                            <th class="px-8 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Order ID</th>
                                            <th class="px-8 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Date</th>
                                            <th class="px-8 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Total</th>
                                            <th class="px-8 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @foreach($recentOrders as $order)
                                        <tr class="hover:bg-slate-50/50 transition cursor-pointer group" onclick="window.location='{{ route('orders.show', $order->id) }}'">
                                            <td class="px-8 py-5 text-sm font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">
                                                #{{ $order->order_number ?? $order->id }}
                                            </td>
                                            <td class="px-8 py-5 text-sm font-medium text-slate-500">
                                                {{ $order->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-8 py-5 text-sm font-black text-slate-900">
                                                ₱{{ number_format($order->total, 2) }}
                                            </td>
                                            <td class="px-8 py-5">
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                                                        'processing' => 'bg-blue-100 text-blue-700 border-blue-200',
                                                        'shipped' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                                                        'delivered' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                                        'cancelled' => 'bg-rose-100 text-rose-700 border-rose-200',
                                                    ];
                                                    $color = $statusColors[$order->status] ?? 'bg-slate-100 text-slate-700 border-slate-200';
                                                @endphp
                                                <span class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full border {{ $color }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-16 px-6">
                                <div class="w-20 h-20 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-6 text-slate-300">
                                    <span class="material-symbols-outlined text-[40px]">inventory_2</span>
                                </div>
                                <h3 class="text-xl font-bold text-slate-900 mb-2">No orders yet</h3>
                                <p class="text-slate-500 mb-8 max-w-sm mx-auto">Looks like you haven't made any purchases yet. Discover our amazing products!</p>
                                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white px-8 py-4 rounded-xl font-bold transition-all shadow-xl shadow-slate-900/20 transform hover:-translate-y-1">
                                    Start Shopping <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column (Recently Viewed & Account) -->
            <div class="lg:col-span-4 space-y-8">
                <!-- Recently Viewed -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-[0px_4px_20px_rgba(0,0,0,0.03)]">
                    <div class="p-6 border-b border-slate-100">
                        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-3">
                            <span class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600">
                                <span class="material-symbols-outlined text-[16px]">history</span>
                            </span>
                            Recently Viewed
                        </h2>
                    </div>
                    <div class="p-6">
                        @if(isset($recentlyViewed) && count($recentlyViewed) > 0)
                            <div class="space-y-4">
                                @foreach($recentlyViewed as $product)
                                <a href="{{ route('products.show', $product->id) }}" class="flex items-center gap-4 hover:bg-slate-50 p-3 -mx-3 rounded-2xl transition group">
                                    <div class="w-14 h-14 bg-slate-50 rounded-xl overflow-hidden border border-slate-100 flex-shrink-0">
                                        @if($product->image_url)
                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                        @elseif($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                <span class="material-symbols-outlined text-[20px]">image</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-slate-900 group-hover:text-emerald-600 transition-colors line-clamp-1 text-sm">
                                            {{ $product->name }}
                                        </h4>
                                        <p class="text-xs font-semibold text-slate-500 mt-0.5">₱{{ number_format($product->price, 2) }}</p>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-sm font-medium text-slate-500 mb-4">No recently viewed products</p>
                                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-4 py-2 rounded-lg transition-colors">
                                    Browse Products <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Account Info -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-[0px_4px_20px_rgba(0,0,0,0.03)]">
                    <div class="p-6 border-b border-slate-100">
                        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-3">
                            <span class="w-8 h-8 rounded-lg bg-rose-100 flex items-center justify-center text-rose-600">
                                <span class="material-symbols-outlined text-[16px]">person</span>
                            </span>
                            Account Information
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-500 font-medium">Full Name</span>
                                <span class="text-slate-900 font-bold">{{ Auth::user()->name }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-500 font-medium">Email Address</span>
                                <span class="text-slate-900 font-bold truncate max-w-[150px]" title="{{ Auth::user()->email }}">{{ Auth::user()->email }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-500 font-medium">Member Since</span>
                                <span class="text-slate-900 font-bold">{{ Auth::user()->created_at->format('M Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm pt-4 border-t border-slate-100">
                                <span class="text-slate-500 font-medium">Status</span>
                                <span class="px-2.5 py-1 text-[10px] uppercase tracking-wider font-black rounded-full {{ Auth::user()->role === 'admin' ? 'bg-indigo-100 text-indigo-700' : 'bg-emerald-100 text-emerald-700' }}">
                                    {{ Auth::user()->role }}
                                </span>
                            </div>
                        </div>
                        <a href="{{ route('profile') }}" class="w-full flex items-center justify-center gap-2 bg-slate-50 hover:bg-slate-100 text-slate-900 px-4 py-3 rounded-xl font-bold transition-colors border border-slate-200">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection