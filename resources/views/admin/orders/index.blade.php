@extends('admin.layouts.admin')

@section('page-title', 'Orders')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Orders</h1>
            <p class="text-slate-500 text-sm mt-1">Manage and track customer orders, update statuses, and view transaction details.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-2.5 rounded-xl font-bold flex items-center gap-2 shadow-lg shadow-indigo-200 transition-all active:scale-95">
            <span class="material-symbols-outlined text-sm">dashboard</span>
            Back to Dashboard
        </a>
    </div>
</div>

<!-- Filter Bar -->
<div class="bg-white/80 backdrop-blur-md p-4 rounded-2xl border border-slate-200/60 shadow-[0px_4px_20px_rgba(0,0,0,0.05)] mb-8 flex flex-wrap items-center gap-4">
    <div class="flex-1 min-w-[240px] relative">
        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">search</span>
        <input class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 pl-10 pr-4 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all" placeholder="Search orders..." type="text"/>
    </div>
    <div class="flex items-center gap-2 min-w-[180px]">
        <span class="text-xs font-semibold text-slate-500 px-1">Status:</span>
        <select class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 px-3 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all appearance-none cursor-pointer">
            <option>All Statuses</option>
            <option>Pending</option>
            <option>Processing</option>
            <option>Shipped</option>
            <option>Delivered</option>
            <option>Cancelled</option>
        </select>
    </div>
    <div class="flex items-center gap-2 min-w-[220px]">
        <span class="text-xs font-semibold text-slate-500 px-1">Date:</span>
        <div class="relative w-full">
            <input class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 px-3 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all cursor-pointer" type="date"/>
        </div>
    </div>
    <button class="flex items-center justify-center w-11 h-11 rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-50 transition-colors">
        <span class="material-symbols-outlined">filter_list</span>
    </button>
</div>

<!-- Data Table Card -->
<div class="bg-white rounded-2xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50/50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Order #</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Payment / Delivery</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($orders as $order)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-5 font-semibold text-indigo-600">#{{ $order->order_number }}</td>
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center font-bold text-[10px]">
                                {{ substr($order->user->name ?? 'G', 0, 1) }}
                            </div>
                            <div>
                                <p class="font-semibold text-sm text-slate-900">{{ $order->user->name ?? 'Guest' }}</p>
                                <p class="text-xs text-slate-500">{{ $order->user->email ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5 font-bold text-slate-900">₱{{ number_format($order->total, 2) }}</td>
                    <td class="px-6 py-5">
                        <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="m-0">
                            @csrf
                            @method('PUT')
                            <select name="status" class="bg-transparent border-0 text-xs font-semibold py-1 px-2 rounded-lg cursor-pointer focus:ring-2 focus:ring-indigo-500 
                                {{ $order->status == 'pending' ? 'text-amber-700 bg-amber-100' : '' }}
                                {{ $order->status == 'processing' ? 'text-blue-700 bg-blue-100' : '' }}
                                {{ $order->status == 'shipped' ? 'text-indigo-700 bg-indigo-100' : '' }}
                                {{ $order->status == 'delivered' ? 'text-emerald-700 bg-emerald-100' : '' }}
                                {{ $order->status == 'cancelled' ? 'text-rose-700 bg-rose-100' : '' }}" 
                                onchange="this.form.submit()">
                                <option value="pending" class="text-slate-900 bg-white" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" class="text-slate-900 bg-white" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" class="text-slate-900 bg-white" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" class="text-slate-900 bg-white" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" class="text-slate-900 bg-white" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex flex-col gap-1 text-slate-500">
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[14px]">payments</span>
                                <span class="text-xs font-medium">{{ ucfirst($order->payment->status ?? 'Pending') }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[14px]">local_shipping</span>
                                <span class="text-xs font-medium">{{ ucfirst($order->delivery->status ?? 'Pending') }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-sm font-medium text-slate-600">{{ $order->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-5 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="p-2 hover:bg-indigo-50 rounded-lg text-indigo-600 transition-colors" title="View Details">
                                <span class="material-symbols-outlined">visibility</span>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-slate-500">No orders found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(method_exists($orders, 'links'))
    <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection