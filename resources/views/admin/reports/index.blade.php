@extends('admin.layouts.admin')

@section('page-title', 'Reports & Analytics')

@section('content')
<!-- Header Section -->
<div class="flex flex-col md:flex-row items-start md:items-end justify-between mb-8 gap-4">
    <div>
        <h2 class="font-black text-3xl text-slate-900 tracking-tight">Reports &amp; Analytics</h2>
        <p class="text-sm text-slate-500 mt-1">Real-time performance metrics and business intelligence overview.</p>
    </div>
    
    <div class="flex items-center gap-2">
        <form method="GET" class="flex items-center gap-2 bg-white px-3 py-2 rounded-xl shadow-sm border border-slate-200">
            <input type="date" name="start_date" value="{{ $startDateStr }}" class="text-sm font-medium text-slate-700 bg-transparent border-none focus:ring-0 w-32 cursor-pointer">
            <span class="text-slate-400">to</span>
            <input type="date" name="end_date" value="{{ $endDateStr }}" class="text-sm font-medium text-slate-700 bg-transparent border-none focus:ring-0 w-32 cursor-pointer">
            <button type="submit" class="bg-indigo-50 text-indigo-700 hover:bg-indigo-100 p-1.5 rounded-lg transition-colors">
                <span class="material-symbols-outlined text-[18px]">filter_alt</span>
            </button>
        </form>
        <a href="{{ route('admin.reports.export', ['start_date' => $startDateStr, 'end_date' => $endDateStr]) }}" class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-xl shadow-lg shadow-indigo-200 transition-all font-semibold text-sm">
            <span class="material-symbols-outlined text-[18px]">download</span>
            Export
        </a>
    </div>
</div>

<!-- Bento Grid Layout -->
<div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-8">
    <!-- Card 1: Sales Overview (Large 2/3 width) -->
    <div class="md:col-span-8 bg-white/70 backdrop-blur-md rounded-2xl p-6 shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-slate-100 flex flex-col min-h-[400px]">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="font-semibold text-lg text-slate-900">Sales Overview</h3>
                <p class="text-sm text-slate-500">Gross revenue vs Projected targets</p>
            </div>
            <div class="flex gap-2">
                <span class="inline-flex items-center gap-1 px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full">
                    <span class="material-symbols-outlined text-[14px]">trending_up</span>
                    Active
                </span>
            </div>
        </div>
        
        <!-- Chart Placeholder UI -->
        <div class="flex-1 relative bg-gradient-to-b from-indigo-50/50 to-transparent rounded-xl border border-indigo-50 overflow-hidden min-h-[200px]">
            <div class="absolute inset-0 flex items-end p-6 space-x-4 md:space-x-8">
                <!-- Faux Bar Chart Representation -->
                <div class="flex-1 bg-indigo-200/50 rounded-t-md h-[40%]"></div>
                <div class="flex-1 bg-indigo-300/50 rounded-t-md h-[55%]"></div>
                <div class="flex-1 bg-indigo-400/50 rounded-t-md h-[45%]"></div>
                <div class="flex-1 bg-indigo-500/50 rounded-t-md h-[70%]"></div>
                <div class="flex-1 bg-indigo-600 rounded-t-md h-[85%] relative">
                    <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-[10px] py-1 px-2 rounded whitespace-nowrap font-bold">
                        Current: ${{ number_format($summary['total_revenue'] ?? 0) }}
                    </div>
                </div>
                <div class="flex-1 bg-indigo-400/50 rounded-t-md h-[60%]"></div>
                <div class="flex-1 bg-indigo-200/50 rounded-t-md h-[30%]"></div>
            </div>
            <!-- Grid Lines -->
            <div class="absolute inset-0 flex flex-col justify-between py-6 pointer-events-none opacity-20">
                <div class="border-t border-slate-400 w-full"></div>
                <div class="border-t border-slate-400 w-full"></div>
                <div class="border-t border-slate-400 w-full"></div>
                <div class="border-t border-slate-400 w-full"></div>
            </div>
        </div>
        
        <div class="mt-6 flex items-center gap-8 border-t border-slate-100 pt-6">
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase">Total Revenue</p>
                <p class="text-3xl font-black text-slate-900">${{ number_format($summary['total_revenue'] ?? 0, 2) }}</p>
            </div>
            <div class="h-10 w-[1px] bg-slate-200"></div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase">Average Order</p>
                <p class="text-3xl font-black text-slate-900">${{ number_format($summary['average_order_value'] ?? 0, 2) }}</p>
            </div>
        </div>
    </div>
    
    <!-- Right Column Stack -->
    <div class="md:col-span-4 flex flex-col gap-6">
        <!-- Card 3: Recent Orders Summary -->
        <div class="bg-white rounded-2xl p-6 shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-slate-100">
            <h3 class="font-semibold text-lg text-slate-900 mb-6">Orders Summary</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-indigo-600 flex items-center justify-center text-white">
                            <span class="material-symbols-outlined">shopping_bag</span>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Orders</p>
                            <p class="text-xl font-bold text-slate-900">{{ $summary['total_orders'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 bg-emerald-50/50 rounded-xl border border-emerald-100">
                        <p class="text-xs font-semibold text-slate-500 uppercase">Completed</p>
                        <p class="text-lg font-bold text-emerald-600">{{ ($summary['total_orders'] ?? 0) - ($summary['pending_orders'] ?? 0) }}</p>
                    </div>
                    <div class="p-4 bg-amber-50/50 rounded-xl border border-amber-100">
                        <p class="text-xs font-semibold text-slate-500 uppercase">Pending</p>
                        <p class="text-lg font-bold text-amber-600">{{ $summary['pending_orders'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Card 2: Top Products -->
        <div class="bg-white rounded-2xl p-6 shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-slate-100 flex-1">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-semibold text-lg text-slate-900">Top Products</h3>
                <button class="text-indigo-600 text-xs font-bold hover:underline">View All</button>
            </div>
            <ul class="space-y-4">
                @forelse($topProducts as $product)
                <li class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-slate-100 flex-shrink-0 overflow-hidden flex items-center justify-center text-slate-400">
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" class="w-full h-full object-cover">
                        @elseif($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                        @else
                            <span class="material-symbols-outlined text-[20px]">image</span>
                        @endif
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-slate-900 line-clamp-1">{{ $product->name }}</p>
                        <p class="text-xs text-slate-500">{{ $product->category->name ?? 'Product' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-slate-900">{{ $product->total_sold }}</p>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wide">Sales</p>
                    </div>
                </li>
                @empty
                <li class="text-sm text-slate-500">No product data available for this period.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

<!-- Daily Sales Table -->
<div class="bg-white rounded-2xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-slate-100 p-6">
    <h3 class="font-semibold text-lg text-slate-900 mb-6">Daily Sales Breakdown</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Date</th>
                    <th class="px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Revenue</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($dailySales as $sale)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-4 py-3 text-sm font-medium text-slate-700">{{ \Carbon\Carbon::parse($sale->date)->format('M d, Y') }}</td>
                    <td class="px-4 py-3 text-sm font-bold text-slate-900 text-right">${{ number_format($sale->total, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="px-4 py-4 text-center text-sm text-slate-500">No daily sales data found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection