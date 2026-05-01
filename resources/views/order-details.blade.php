@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Order #{{ $order->order_number }}</h1>
            <span class="px-4 py-2 rounded-full text-sm font-semibold capitalize 
                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                {{ $order->status === 'shipped' ? 'bg-purple-100 text-purple-800' : '' }}
                {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                {{ $order->status }}
            </span>
        </div>
        
        <!-- Order Progress Stepper -->
        @if($order->status !== 'cancelled')
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <div class="relative">
                <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-200">
                    @php
                        $progress = 0;
                        if($order->status == 'pending') $progress = 25;
                        if($order->status == 'processing') $progress = 50;
                        if($order->status == 'shipped') $progress = 75;
                        if($order->status == 'delivered') $progress = 100;
                    @endphp
                    <div style="width: {{ $progress }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-gradient-to-r from-purple-500 to-pink-500 transition-all duration-1000"></div>
                </div>
                <div class="flex justify-between text-xs sm:text-sm text-gray-600 font-medium">
                    <div class="text-center w-1/4 {{ $progress >= 25 ? 'text-purple-600' : '' }}">
                        <i class="fas fa-clipboard-list text-xl mb-1 block {{ $progress >= 25 ? 'text-purple-500' : 'text-gray-400' }}"></i>
                        Pending
                    </div>
                    <div class="text-center w-1/4 {{ $progress >= 50 ? 'text-purple-600' : '' }}">
                        <i class="fas fa-box-open text-xl mb-1 block {{ $progress >= 50 ? 'text-purple-500' : 'text-gray-400' }}"></i>
                        Processing
                    </div>
                    <div class="text-center w-1/4 {{ $progress >= 75 ? 'text-purple-600' : '' }}">
                        <i class="fas fa-truck text-xl mb-1 block {{ $progress >= 75 ? 'text-purple-500' : 'text-gray-400' }}"></i>
                        Shipped
                    </div>
                    <div class="text-center w-1/4 {{ $progress >= 100 ? 'text-purple-600' : '' }}">
                        <i class="fas fa-home text-xl mb-1 block {{ $progress >= 100 ? 'text-purple-500' : 'text-gray-400' }}"></i>
                        Delivered
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="bg-red-50 rounded-2xl shadow-sm p-6 mb-8 border border-red-200 text-center">
            <i class="fas fa-times-circle text-4xl text-red-500 mb-3"></i>
            <h2 class="text-xl font-bold text-red-800">Order Cancelled</h2>
            <p class="text-red-600">This order has been cancelled.</p>
        </div>
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow p-6 md:col-span-2">
                <div class="border-b md:border-b-0 md:border-r border-gray-100 pb-4 md:pb-0 md:pr-4">
                    <h3 class="text-sm text-gray-500 mb-1">Order Date</h3>
                    <p class="text-lg font-semibold text-gray-900">{{ $order->created_at->format('M d, Y') }}</p>
                </div>
                <div class="border-b md:border-b-0 md:border-r border-gray-100 py-4 md:py-0 md:px-4">
                    <h3 class="text-sm text-gray-500 mb-1">Total Amount</h3>
                    <p class="text-lg font-bold text-purple-600">₱{{ number_format($order->total, 2) }}</p>
                </div>
                <div class="pt-4 md:pt-0 md:pl-4">
                    <h3 class="text-sm text-gray-500 mb-1">Payment Method</h3>
                    <p class="text-lg font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 md:col-span-1">
            <h3 class="text-lg font-bold mb-4">Customer Details</h3>
            <p class="text-gray-700 font-medium">{{ $order->user->name ?? 'Guest' }}</p>
            <p class="text-gray-600 text-sm">{{ $order->user->email ?? '' }}</p>
            @if($order->shipping_address)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <h4 class="text-sm text-gray-500 mb-1">Shipping Address</h4>
                    <p class="text-gray-700 text-sm">{{ $order->shipping_address }}</p>
                </div>
            @endif
        </div>
        </div>

        <div class="bg-white rounded-2xl shadow overflow-hidden mb-8">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-bold">Order Items</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 text-gray-600 text-sm">
                        <tr>
                            <th class="text-left py-3 px-6 font-medium">Product</th>
                            <th class="text-center py-3 px-6 font-medium">Quantity</th>
                            <th class="text-right py-3 px-6 font-medium">Price</th>
                            <th class="text-right py-3 px-6 font-medium">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($order->items as $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center">
                                        @if($item->product->image_url)
                                            <img src="{{ $item->product->image_url }}" class="w-10 h-10 object-cover rounded">
                                        @else
                                            <i class="fas fa-image text-purple-300"></i>
                                        @endif
                                    </div>
                                    <span class="font-medium text-gray-800">{{ $item->product->name }}</span>
                                </div>
                            </td>
                            <td class="text-center py-4 px-6">{{ $item->quantity }}</td>
                            <td class="text-right py-4 px-6 text-gray-600">₱{{ number_format($item->price, 2) }}</td>
                            <td class="text-right py-4 px-6 font-semibold text-purple-600">₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            @if($order->payment)
            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="text-lg font-bold mb-4 flex items-center gap-2">
                    <i class="fas fa-credit-card text-purple-500"></i> Payment Details
                </h2>
                <div class="space-y-2">
                    <p class="text-sm text-gray-600 flex justify-between">
                        <span>Status:</span> 
                        <span class="font-semibold {{ $order->payment->status === 'completed' ? 'text-green-600' : 'text-yellow-600' }}">
                            {{ ucfirst($order->payment->status) }}
                        </span>
                    </p>
                    @if($order->payment->transaction_id)
                    <p class="text-sm text-gray-600 flex justify-between">
                        <span>Transaction ID:</span> 
                        <span class="font-mono">{{ $order->payment->transaction_id }}</span>
                    </p>
                    @endif
                </div>
            </div>
            @endif

            @if($order->delivery)
            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="text-lg font-bold mb-4 flex items-center gap-2">
                    <i class="fas fa-truck text-purple-500"></i> Delivery Information
                </h2>
                <div class="space-y-2">
                    <p class="text-sm text-gray-600 flex justify-between">
                        <span>Status:</span> 
                        <span class="font-semibold">{{ ucfirst(str_replace('_', ' ', $order->delivery->status)) }}</span>
                    </p>
                    @if($order->delivery->tracking_number)
                    <p class="text-sm text-gray-600 flex justify-between">
                        <span>Tracking:</span> 
                        <span class="font-mono bg-gray-100 px-2 py-0.5 rounded">{{ $order->delivery->tracking_number }}</span>
                    </p>
                    @endif
                    @if($order->delivery->estimated_delivery_date)
                    <p class="text-sm text-gray-600 flex justify-between">
                        <span>Est. Delivery:</span> 
                        <span class="font-medium">{{ $order->delivery->estimated_delivery_date }}</span>
                    </p>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <div class="flex flex-wrap gap-4 justify-between items-center bg-gray-50 p-6 rounded-2xl">
            <a href="{{ route('orders.index') }}" class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium flex items-center gap-2 shadow-sm">
                <i class="fas fa-arrow-left"></i> Back to Orders
            </a>
            @if($order->status === 'pending')
            <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order? This action cannot be undone.');">
                @csrf
                <button type="submit" class="px-6 py-2.5 bg-red-50 text-red-600 border border-red-200 rounded-lg hover:bg-red-500 hover:text-white transition-colors font-medium flex items-center gap-2 shadow-sm">
                    <i class="fas fa-ban"></i> Cancel Order
                </button>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection
