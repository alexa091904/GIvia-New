@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="pt-28 pb-12 bg-slate-50 min-h-screen">
    <div class="max-w-[1280px] mx-auto sm:px-6 lg:px-8">
        <!-- Profile Header -->
        <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl shadow-lg mb-8 overflow-hidden">
            <div class="px-6 py-8">
                <div class="flex items-center">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center text-3xl font-bold text-purple-600">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="ml-6">
                        <h1 class="text-2xl md:text-3xl font-bold text-white">{{ Auth::user()->name }}</h1>
                        <p class="text-purple-100 mt-1">{{ Auth::user()->email }}</p>
                        <p class="text-purple-200 text-sm mt-2">
                            <i class="fas fa-calendar-alt mr-1"></i> Member since {{ Auth::user()->created_at->format('F d, Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <nav class="space-y-2">
                        <a href="#profile-info" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-600 transition sidebar-link active" id="tab-profile">
                            <i class="fas fa-user w-5"></i>
                            <span class="ml-3">Profile Information</span>
                        </a>
                        <a href="#change-password" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-600 transition sidebar-link" id="tab-password">
                            <i class="fas fa-lock w-5"></i>
                            <span class="ml-3">Change Password</span>
                        </a>
                        <a href="#account-stats" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-600 transition sidebar-link" id="tab-stats">
                            <i class="fas fa-chart-line w-5"></i>
                            <span class="ml-3">Account Statistics</span>
                        </a>
                        <a href="#order-history" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-600 transition sidebar-link" id="tab-orders">
                            <i class="fas fa-shopping-bag w-5"></i>
                            <span class="ml-3">Order History</span>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Profile Information -->
                <div id="profile-info" class="bg-white rounded-2xl shadow-lg p-6 mb-8 content-section">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-user-circle text-purple-600 mr-2"></i>
                        Profile Information
                    </h3>
                    
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
                        </div>
                        
                        <button type="submit" class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-2 rounded-lg hover:shadow-lg transition">
                            Update Profile
                        </button>
                    </form>
                </div>

                <!-- Change Password -->
                <div id="change-password" class="bg-white rounded-2xl shadow-lg p-6 mb-8 content-section hidden">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-key text-purple-600 mr-2"></i>
                        Change Password
                    </h3>
                    
                    <form method="POST" action="{{ route('profile.password') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">Current Password</label>
                            <input type="password" name="current_password" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">New Password</label>
                            <input type="password" name="password" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
                            <p class="text-xs text-gray-500 mt-1">Minimum 8 characters</p>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">Confirm New Password</label>
                            <input type="password" name="password_confirmation" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
                        </div>
                        
                        <button type="submit" class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-2 rounded-lg hover:shadow-lg transition">
                            Change Password
                        </button>
                    </form>
                </div>

                <!-- Account Statistics -->
                <div id="account-stats" class="bg-white rounded-2xl shadow-lg p-6 mb-8 content-section hidden">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-chart-pie text-purple-600 mr-2"></i>
                        Account Statistics
                    </h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-4 text-white text-center">
                            <i class="fas fa-shopping-cart text-2xl mb-2"></i>
                            <div class="text-2xl font-bold">{{ $totalOrders ?? 0 }}</div>
                            <div class="text-sm opacity-90">Total Orders</div>
                        </div>
                        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-4 text-white text-center">
                            <i class="fas fa-dollar-sign text-2xl mb-2"></i>
                            <div class="text-2xl font-bold">₱{{ number_format($totalSpent ?? 0, 2) }}</div>
                            <div class="text-sm opacity-90">Total Spent</div>
                        </div>
                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-4 text-white text-center">
                            <i class="fas fa-heart text-2xl mb-2"></i>
                            <div class="text-2xl font-bold">{{ $wishlistCount ?? 0 }}</div>
                            <div class="text-sm opacity-90">Wishlist Items</div>
                        </div>
                        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-4 text-white text-center">
                            <i class="fas fa-star text-2xl mb-2"></i>
                            <div class="text-2xl font-bold">{{ $reviewsCount ?? 0 }}</div>
                            <div class="text-sm opacity-90">Reviews</div>
                        </div>
                    </div>
                </div>

                <!-- Order History -->
                <div id="order-history" class="bg-white rounded-2xl shadow-lg p-6 content-section hidden">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-history text-purple-600 mr-2"></i>
                        Recent Orders
                    </h3>
                    
                    @if(isset($recentOrders) && count($recentOrders) > 0)
                        <div class="space-y-4">
                            @foreach($recentOrders as $order)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-semibold text-gray-800">Order #{{ $order->id }}</p>
                                            <p class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-purple-600">₱{{ number_format($order->total, 2) }}</p>
                                            <span class="inline-block px-2 py-1 text-xs rounded-full bg-green-100 text-green-600">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 text-center">
                            <a href="{{ route('orders.index') }}" class="text-purple-600 hover:text-purple-700">
                                View All Orders →
                            </a>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-box-open text-5xl text-gray-300 mb-3"></i>
                            <p class="text-gray-500">No orders yet</p>
                            <a href="{{ route('products.index') }}" class="inline-block mt-3 text-purple-600 hover:text-purple-700">
                                Start Shopping →
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .sidebar-link.active {
        background: linear-gradient(135deg, #667eea15, #764ba215);
        color: #667eea;
        font-weight: 600;
    }
    
    .content-section {
        transition: all 0.3s ease;
    }
    
    .content-section.hidden {
        display: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab switching functionality
        const tabs = document.querySelectorAll('.sidebar-link');
        const sections = document.querySelectorAll('.content-section');
        
        function switchTab(tabId) {
            // Hide all sections
            sections.forEach(section => {
                section.classList.add('hidden');
            });
            
            // Show selected section
            const targetId = tabId.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            if (targetSection) {
                targetSection.classList.remove('hidden');
            }
            
            // Update active state on tabs
            tabs.forEach(tab => {
                tab.classList.remove('active');
            });
            tabId.classList.add('active');
        }
        
        // Add click handlers
        tabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                switchTab(this);
            });
        });
        
        // Show profile section by default
        const defaultTab = document.querySelector('#tab-profile');
        if (defaultTab) {
            switchTab(defaultTab);
        }
    });
</script>
@endsection