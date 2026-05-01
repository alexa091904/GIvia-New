@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Welcome Banner -->
        <div class="gradient-bg rounded-2xl shadow-xl mb-8 overflow-hidden">
            <div class="relative">
                <div class="absolute inset-0 bg-black opacity-20"></div>
                <div class="relative px-6 py-8 md:py-12 md:px-10">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">
                                Welcome back, {{ Auth::user()->name }}!
                            </h1>
                            <p class="text-purple-100 text-sm md:text-base">
                                Here's what's happening with your store today.
                            </p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <a href="{{ route('products.index') }}" class="inline-flex items-center px-5 py-2 bg-white text-purple-600 rounded-lg font-semibold hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-shopping-bag mr-2"></i>
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders Section -->
        <div class="bg-white rounded-xl shadow-lg mb-8">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800">
                        <i class="fas fa-history mr-2 text-purple-600"></i>
                        Recent Orders
                    </h2>
                    <a href="{{ route('orders.index') }}" class="text-purple-600 hover:text-purple-700 font-medium text-sm">
                        View All <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                @if(isset($recentOrders) && count($recentOrders) > 0)
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($recentOrders as $order)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $order->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">
                                    ₱{{ number_format($order->total, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'processing' => 'bg-blue-100 text-blue-800',
                                            'shipped' => 'bg-purple-100 text-purple-800',
                                            'delivered' => 'bg-green-100 text-green-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                        ];
                                        $color = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-2 py-1 text-xs rounded-full {{ $color }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="{{ route('orders.show', $order->id) }}" class="text-purple-600 hover:text-purple-900 font-medium">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-box-open text-5xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">No orders yet</p>
                        <a href="{{ route('products.index') }}" class="inline-block mt-4 btn-gradient text-white px-6 py-2 rounded-lg">
                            Start Shopping
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recently Viewed Products -->
            <div class="bg-white rounded-xl shadow-lg">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-800">
                        <i class="fas fa-eye mr-2 text-purple-600"></i>
                        Recently Viewed
                    </h2>
                </div>
                <div class="p-6">
                    @if(isset($recentlyViewed) && count($recentlyViewed) > 0)
                        <div class="space-y-4">
                            @foreach($recentlyViewed as $product)
                            <div class="flex items-center space-x-4 hover:bg-gray-50 p-3 rounded-lg transition">
                                <img src="{{ $product->image_url ?? 'https://via.placeholder.com/60' }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded-lg">
                                <div class="flex-1">
                                    <a href="{{ route('products.show', $product->id) }}" class="font-semibold text-gray-800 hover:text-purple-600">
                                        {{ $product->name }}
                                    </a>
                                    <p class="text-sm text-gray-500">₱{{ number_format($product->price, 2) }}</p>
                                </div>
                                <a href="{{ route('products.show', $product->id) }}" class="text-purple-600 hover:text-purple-700">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-history text-4xl text-gray-300 mb-3"></i>
                            <p class="text-gray-500">No recently viewed products</p>
                            <a href="{{ route('products.index') }}" class="inline-block mt-3 text-purple-600 hover:text-purple-700">
                                Browse Products →
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Account Information -->
            <div class="bg-white rounded-xl shadow-lg">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-800">
                        <i class="fas fa-user-circle mr-2 text-purple-600"></i>
                        Account Information
                    </h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                            <div class="flex items-center">
                                <i class="fas fa-user w-5 text-gray-400"></i>
                                <span class="ml-3 text-gray-600">Full Name</span>
                            </div>
                            <span class="font-medium text-gray-800">{{ Auth::user()->name }}</span>
                        </div>
                        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                            <div class="flex items-center">
                                <i class="fas fa-envelope w-5 text-gray-400"></i>
                                <span class="ml-3 text-gray-600">Email Address</span>
                            </div>
                            <span class="font-medium text-gray-800">{{ Auth::user()->email }}</span>
                        </div>
                        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                            <div class="flex items-center">
                                <i class="fas fa-calendar w-5 text-gray-400"></i>
                                <span class="ml-3 text-gray-600">Member Since</span>
                            </div>
                            <span class="font-medium text-gray-800">{{ Auth::user()->created_at->format('F d, Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-star w-5 text-gray-400"></i>
                                <span class="ml-3 text-gray-600">Account Type</span>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full {{ Auth::user()->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst(Auth::user()->role) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <a href="{{ route('profile') }}" class="w-full btn-gradient text-white px-4 py-2 rounded-lg text-center inline-block hover:shadow-lg transition-all duration-300">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('products.index') }}" class="bg-white rounded-xl shadow-md p-4 text-center hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-search text-2xl text-purple-600 mb-2"></i>
                <p class="text-sm font-semibold text-gray-700">Browse Products</p>
            </a>
            <a href="{{ route('cart.index') }}" class="bg-white rounded-xl shadow-md p-4 text-center hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-shopping-cart text-2xl text-purple-600 mb-2"></i>
                <p class="text-sm font-semibold text-gray-700">View Cart</p>
            </a>
            <a href="{{ route('orders.index') }}" class="bg-white rounded-xl shadow-md p-4 text-center hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-truck text-2xl text-purple-600 mb-2"></i>
                <p class="text-sm font-semibold text-gray-700">Track Orders</p>
            </a>
            <a href="{{ route('profile') }}" class="bg-white rounded-xl shadow-md p-4 text-center hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-cog text-2xl text-purple-600 mb-2"></i>
                <p class="text-sm font-semibold text-gray-700">Account Settings</p>
            </a>
        </div>
    </div>
</div>

<style>
    .hover-lift {
        transition: all 0.3s ease;
    }
    
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    
    .btn-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        transition: all 0.3s ease;
    }
    
    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
    }
</style>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Optional: Add any dashboard-specific JS here
    });
</script>
@endpush