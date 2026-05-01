@extends('admin.layouts.admin')

@section('page-title', 'System Overview')

@section('content')
<!-- Header Section -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="font-display-lg text-display-lg text-on-surface">System Overview</h2>
        <p class="text-on-surface-variant font-body-sm mt-1">Monitor your platform's health and key performance indicators in real-time.</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-2 px-6 py-2 custom-gradient-purple text-white rounded-lg font-label-bold shadow-lg shadow-indigo-500/20 hover:opacity-90 transition-all">
            <span class="material-symbols-outlined text-lg">bar_chart</span>
            VIEW REPORTS
        </a>
    </div>
</div>

<!-- Bento Stat Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
    <!-- Total Products -->
    <div class="bg-white rounded-2xl p-6 shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-slate-50 relative overflow-hidden group">
        <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:scale-110 transition-transform duration-500">
            <span class="material-symbols-outlined text-9xl">inventory_2</span>
        </div>
        <div class="flex items-start justify-between mb-4">
            <div class="w-12 h-12 custom-gradient-blue rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-500/20">
                <span class="material-symbols-outlined">inventory_2</span>
            </div>
        </div>
        <p class="font-label-bold text-on-surface-variant mb-1">TOTAL PRODUCTS</p>
        <h3 class="font-display-lg text-display-lg text-on-surface">{{ number_format($totalProducts) }}</h3>
    </div>

    <!-- Total Orders -->
    <div class="bg-white rounded-2xl p-6 shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-slate-50 relative overflow-hidden group">
        <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:scale-110 transition-transform duration-500">
            <span class="material-symbols-outlined text-9xl">shopping_cart</span>
        </div>
        <div class="flex items-start justify-between mb-4">
            <div class="w-12 h-12 custom-gradient-purple rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-500/20">
                <span class="material-symbols-outlined">shopping_cart</span>
            </div>
        </div>
        <p class="font-label-bold text-on-surface-variant mb-1">TOTAL ORDERS</p>
        <h3 class="font-display-lg text-display-lg text-on-surface">{{ number_format($totalOrders) }}</h3>
    </div>

    <!-- Total Users -->
    <div class="bg-white rounded-2xl p-6 shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-slate-50 relative overflow-hidden group">
        <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:scale-110 transition-transform duration-500">
            <span class="material-symbols-outlined text-9xl">group</span>
        </div>
        <div class="flex items-start justify-between mb-4">
            <div class="w-12 h-12 custom-gradient-orange rounded-xl flex items-center justify-center text-white shadow-lg shadow-rose-500/20">
                <span class="material-symbols-outlined">group</span>
            </div>
        </div>
        <p class="font-label-bold text-on-surface-variant mb-1">TOTAL USERS</p>
        <h3 class="font-display-lg text-display-lg text-on-surface">{{ number_format($totalUsers) }}</h3>
    </div>

    <!-- Total Revenue -->
    <div class="custom-gradient-purple rounded-2xl p-6 shadow-[0px_10px_30px_rgba(118,75,162,0.3)] relative overflow-hidden group">
        <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform duration-500">
            <span class="material-symbols-outlined text-9xl text-white">payments</span>
        </div>
        <div class="flex items-start justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center text-white border border-white/30">
                <span class="material-symbols-outlined">payments</span>
            </div>
        </div>
        <p class="font-label-bold text-white/80 mb-1">TOTAL REVENUE</p>
        <h3 class="font-display-lg text-display-lg text-white">₱{{ number_format($totalRevenue, 2) }}</h3>
    </div>
</div>

<!-- Secondary Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Recent Orders Section -->
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-slate-50 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div>
                <h4 class="font-title-sm text-on-surface">Recent Orders</h4>
                <p class="text-xs text-on-surface-variant font-medium mt-0.5">Summary of the latest customer transactions</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="text-indigo-600 text-sm font-bold hover:underline">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 font-label-bold uppercase tracking-wider text-[11px] border-b border-slate-100">
                        <th class="px-6 py-4">Order ID</th>
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($recentOrders as $order)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-label-bold text-indigo-600">#{{ $order->order_number }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-400 text-xs">
                                    {{ substr($order->user->name ?? 'G', 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-on-surface">{{ $order->user->name ?? 'Guest' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 font-medium">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            @if($order->status == 'pending')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-700">Pending</span>
                            @elseif($order->status == 'processing')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-700">Processing</span>
                            @elseif($order->status == 'shipped')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-purple-100 text-purple-700">Shipped</span>
                            @elseif($order->status == 'delivered')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">Delivered</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-700">Cancelled</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-bold text-on-surface">₱{{ number_format($order->total, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500">No recent orders.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Inventory Alert Card -->
    <div class="lg:col-span-1 bg-white rounded-2xl p-6 shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-slate-50 flex flex-col">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-rose-500">warning</span>
                <h5 class="font-title-sm text-on-surface">Low Stock</h5>
            </div>
            <span class="text-xs font-bold text-rose-600 bg-rose-50 px-2 py-1 rounded-full">{{ $lowStockProducts->count() }} items</span>
        </div>
        <div class="space-y-3 flex-1 overflow-y-auto max-h-[300px] pr-2">
            @forelse($lowStockProducts as $product)
            <div class="flex items-center justify-between p-3 rounded-xl bg-rose-50 border border-rose-100">
                <div class="flex items-center gap-3">
                    @if($product->image)
                        <img src="{{ Storage::url($product->image) }}" class="w-10 h-10 rounded-lg object-cover">
                    @else
                        <div class="w-10 h-10 rounded-lg bg-white flex items-center justify-center">
                            <span class="material-symbols-outlined text-slate-300">image</span>
                        </div>
                    @endif
                    <div>
                        <p class="text-xs font-bold text-on-surface truncate w-32">{{ $product->name }}</p>
                        <p class="text-[10px] text-rose-600 font-bold">{{ $product->stock }} units left</p>
                    </div>
                </div>
                <a href="{{ route('admin.inventory.index') }}" class="text-xs font-bold text-rose-700 underline">Restock</a>
            </div>
            @empty
            <div class="p-4 text-center">
                <span class="material-symbols-outlined text-4xl text-emerald-200 mb-2">check_circle</span>
                <p class="text-sm text-slate-500 font-medium">All products are adequately stocked.</p>
            </div>
            @endforelse
        </div>
        <a href="{{ route('admin.inventory.index') }}" class="mt-4 w-full text-center py-2 border border-slate-200 rounded-lg text-xs font-bold text-slate-500 hover:bg-slate-50 transition-colors uppercase tracking-widest block">View Inventory</a>
    </div>
</div>
@endsection