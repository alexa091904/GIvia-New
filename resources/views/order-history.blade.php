@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">My Orders</h1>
            <p class="text-gray-600">Track and manage all your orders in one place</p>
        </div>

        @if($orders && $orders->count() > 0)
            <!-- Order Statistics -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-xl shadow-md p-4 text-center">
                    <div class="text-2xl font-bold text-purple-600">{{ $orders->total() }}</div>
                    <div class="text-sm text-gray-600">Total Orders</div>
                </div>
                <div class="bg-white rounded-xl shadow-md p-4 text-center">
                    <div class="text-2xl font-bold text-green-600">
                        {{ $orders->where('status', 'delivered')->count() }}
                    </div>
                    <div class="text-sm text-gray-600">Delivered</div>
                </div>
                <div class="bg-white rounded-xl shadow-md p-4 text-center">
                    <div class="text-2xl font-bold text-orange-600">
                        {{ $orders->whereIn('status', ['pending', 'processing'])->count() }}
                    </div>
                    <div class="text-sm text-gray-600">In Progress</div>
                </div>
                <div class="bg-white rounded-xl shadow-md p-4 text-center">
                    <div class="text-2xl font-bold text-blue-600">
                        ₱{{ number_format($orders->sum('total'), 2) }}
                    </div>
                    <div class="text-sm text-gray-600">Total Spent</div>
                </div>
            </div>

            <!-- Filter Tabs -->
            <div class="flex flex-wrap gap-2 mb-6">
                <button class="filter-btn px-4 py-2 rounded-lg font-medium transition-all duration-300 bg-purple-600 text-white shadow-md" data-status="all">
                    All Orders
                </button>
                <button class="filter-btn px-4 py-2 rounded-lg font-medium transition-all duration-300 bg-white text-gray-700 hover:bg-purple-50" data-status="pending">
                    Pending
                </button>
                <button class="filter-btn px-4 py-2 rounded-lg font-medium transition-all duration-300 bg-white text-gray-700 hover:bg-purple-50" data-status="processing">
                    Processing
                </button>
                <button class="filter-btn px-4 py-2 rounded-lg font-medium transition-all duration-300 bg-white text-gray-700 hover:bg-purple-50" data-status="shipped">
                    Shipped
                </button>
                <button class="filter-btn px-4 py-2 rounded-lg font-medium transition-all duration-300 bg-white text-gray-700 hover:bg-purple-50" data-status="delivered">
                    Delivered
                </button>
                <button class="filter-btn px-4 py-2 rounded-lg font-medium transition-all duration-300 bg-white text-gray-700 hover:bg-purple-50" data-status="cancelled">
                    Cancelled
                </button>
            </div>

            <!-- Orders List -->
            <div class="space-y-4" id="ordersContainer">
                @foreach($orders as $order)
                    <div class="order-card bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300" data-status="{{ $order->status }}">
                        <div class="p-6">
                            <!-- Order Header -->
                            <div class="flex flex-wrap justify-between items-start mb-4">
                                <div>
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-lg font-bold text-gray-800">Order #{{ $order->order_number }}</h3>
                                        <span class="order-status status-{{ $order->status }} px-2 py-1 text-xs rounded-full font-semibold">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-500">
                                        <i class="fas fa-calendar-alt mr-1"></i> Placed on {{ $order->created_at->format('F d, Y') }}
                                    </p>
                                </div>
                                
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'processing' => 'bg-blue-100 text-blue-800',
                                        'shipped' => 'bg-purple-100 text-purple-800',
                                        'delivered' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                    ];
                                    $statusIcons = [
                                        'pending' => 'fa-clock',
                                        'processing' => 'fa-spinner',
                                        'shipped' => 'fa-truck',
                                        'delivered' => 'fa-check-circle',
                                        'cancelled' => 'fa-times-circle',
                                    ];
                                    $colorClass = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                                    $iconClass = $statusIcons[$order->status] ?? 'fa-box';
                                @endphp
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-purple-600">₱{{ number_format($order->total, 2) }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        <i class="fas {{ $iconClass }} mr-1"></i> {{ ucfirst($order->status) }}
                                    </p>
                                </div>
                            </div>

                            <!-- Order Details Grid -->
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 py-4 border-t border-b border-gray-100">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Payment Status</p>
                                    @if($order->payment)
                                        <span class="inline-flex items-center gap-1 text-sm font-medium {{ $order->payment->status === 'completed' ? 'text-green-600' : 'text-yellow-600' }}">
                                            <i class="fas {{ $order->payment->status === 'completed' ? 'fa-check-circle' : 'fa-hourglass-half' }}"></i>
                                            {{ ucfirst($order->payment->status) }}
                                        </span>
                                    @else
                                        <span class="text-sm text-gray-600">Pending</span>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Payment Method</p>
                                    <p class="text-sm font-medium text-gray-700">
                                        @if($order->payment && $order->payment->method)
                                            {{ ucfirst($order->payment->method) }}
                                        @else
                                            Not specified
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Tracking Number</p>
                                    @if($order->tracking_number)
                                        <p class="text-sm font-medium text-gray-700">{{ $order->tracking_number }}</p>
                                    @else
                                        <p class="text-sm text-gray-500">Not available</p>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Items</p>
                                    <p class="text-sm font-medium text-gray-700">
                                        {{ $order->items_count ?? $order->items->count() ?? 0 }} items
                                    </p>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-wrap gap-3 mt-4">
                                <a href="{{ route('orders.show', $order->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition shadow-md">
                                    <i class="fas fa-eye"></i> View Details
                                </a>
                                
                                @if(in_array($order->status, ['pending', 'processing']))
                                    <button class="cancel-order inline-flex items-center gap-2 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition shadow-md" data-order-id="{{ $order->id }}">
                                        <i class="fas fa-times-circle"></i> Cancel Order
                                    </button>
                                @endif

                                @if($order->status == 'shipped' && $order->tracking_number)
                                    <button class="track-order inline-flex items-center gap-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition shadow-md" data-tracking="{{ $order->tracking_number }}">
                                        <i class="fas fa-map-marker-alt"></i> Track Order
                                    </button>
                                @endif

                                @if($order->status == 'delivered')
                                    <button class="reorder-btn inline-flex items-center gap-2 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition shadow-md" data-order-id="{{ $order->id }}">
                                        <i class="fas fa-sync-alt"></i> Reorder
                                    </button>
                                    <button class="write-review inline-flex items-center gap-2 px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition shadow-md">
                                        <i class="fas fa-star"></i> Write Review
                                    </button>
                                @endif
                            </div>
                        </div>

                        <!-- Progress Bar for Active Orders -->
                        @if(!in_array($order->status, ['delivered', 'cancelled']))
                            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                                <div class="flex justify-between text-xs text-gray-500 mb-2">
                                    <span class="{{ $order->status == 'pending' ? 'text-purple-600 font-semibold' : '' }}">Order Placed</span>
                                    <span class="{{ $order->status == 'processing' ? 'text-purple-600 font-semibold' : '' }}">Processing</span>
                                    <span class="{{ $order->status == 'shipped' ? 'text-purple-600 font-semibold' : '' }}">Shipped</span>
                                    <span>Delivered</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    @php
                                        $progress = 0;
                                        if ($order->status == 'pending') $progress = 25;
                                        elseif ($order->status == 'processing') $progress = 50;
                                        elseif ($order->status == 'shipped') $progress = 75;
                                        elseif ($order->status == 'delivered') $progress = 100;
                                    @endphp
                                    <div class="bg-gradient-to-r from-purple-600 to-pink-600 h-2 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                <div class="w-32 h-32 bg-gradient-to-br from-purple-100 to-pink-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-box-open text-5xl text-purple-400"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">No Orders Yet</h2>
                <p class="text-gray-500 mb-6">You haven't placed any orders yet. Start shopping to see your orders here!</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('products.index') }}" class="btn-gradient text-white px-6 py-3 rounded-xl font-semibold inline-flex items-center justify-center gap-2">
                        <i class="fas fa-store"></i> Start Shopping
                    </a>
                    <a href="{{ route('products.index') }}?sort=created_at&order=desc" class="border-2 border-purple-600 text-purple-600 px-6 py-3 rounded-xl font-semibold inline-flex items-center justify-center gap-2 hover:bg-purple-600 hover:text-white transition">
                        <i class="fas fa-fire"></i> View New Arrivals
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .btn-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        transition: all 0.3s ease;
    }
    
    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
    }
    
    .order-status {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .status-pending {
        background-color: #fef3c7;
        color: #d97706;
    }
    
    .status-processing {
        background-color: #dbeafe;
        color: #2563eb;
    }
    
    .status-shipped {
        background-color: #f3e8ff;
        color: #7c3aed;
    }
    
    .status-delivered {
        background-color: #d1fae5;
        color: #059669;
    }
    
    .status-cancelled {
        background-color: #fee2e2;
        color: #dc2626;
    }
    
    .filter-btn {
        transition: all 0.3s ease;
    }
    
    .filter-btn.active {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }
    
    /* Custom pagination */
    .pagination {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .pagination .page-item .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 12px;
        border-radius: 12px;
        background: white;
        color: #4B5563;
        border: 1px solid #E5E7EB;
        transition: all 0.3s ease;
    }
    
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-color: transparent;
    }
    
    .pagination .page-item .page-link:hover {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        transform: translateY(-2px);
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Filter orders by status
    $('.filter-btn').click(function() {
        let status = $(this).data('status');
        
        // Update active state
        $('.filter-btn').removeClass('active bg-purple-600 text-white shadow-md');
        $(this).addClass('active bg-purple-600 text-white shadow-md');
        
        // Filter orders
        if (status === 'all') {
            $('.order-card').show();
        } else {
            $('.order-card').each(function() {
                if ($(this).data('status') === status) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
    });
    
    // Cancel order with SweetAlert confirmation
    $('.cancel-order').click(function() {
        let orderId = $(this).data('order-id');
        let button = $(this);
        
        Swal.fire({
            title: 'Cancel Order?',
            text: "Are you sure you want to cancel this order? This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, cancel order',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.isConfirmed) {
                button.html('<i class="fas fa-spinner fa-spin"></i> Cancelling...').prop('disabled', true);
                
                $.ajax({
                    url: '/api/orders/' + orderId + '/cancel',
                    method: 'POST',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function() {
                        Swal.fire(
                            'Cancelled!',
                            'Your order has been cancelled successfully.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseJSON?.error || 'Error cancelling order';
                        Swal.fire('Error!', errorMsg, 'error');
                        button.html('<i class="fas fa-times-circle"></i> Cancel Order').prop('disabled', false);
                    }
                });
            }
        });
    });
    
    // Track order
    $('.track-order').click(function() {
        let trackingNumber = $(this).data('tracking');
        
        Swal.fire({
            title: 'Track Your Order',
            html: `
                <div class="text-left">
                    <p class="mb-2"><strong>Tracking Number:</strong> ${trackingNumber}</p>
                    <div class="bg-gray-100 rounded-lg p-3 mt-3">
                        <p class="text-sm text-gray-600">Your package is on the way!</p>
                        <div class="mt-2">
                            <div class="flex items-center gap-2 text-sm">
                                <i class="fas fa-check-circle text-green-500"></i>
                                <span>Order confirmed</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm mt-2">
                                <i class="fas fa-truck text-blue-500"></i>
                                <span>In transit</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm mt-2">
                                <i class="fas fa-clock text-gray-400"></i>
                                <span class="text-gray-400">Out for delivery</span>
                            </div>
                        </div>
                    </div>
                </div>
            `,
            icon: 'info',
            confirmButtonColor: '#667eea',
            confirmButtonText: 'Close'
        });
    });
    
    // Reorder
    $('.reorder-btn').click(function() {
        let orderId = $(this).data('order-id');
        
        Swal.fire({
            title: 'Reorder Items?',
            text: "Would you like to add all items from this order to your cart?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10B981',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, reorder'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/api/orders/' + orderId + '/reorder',
                    method: 'POST',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function() {
                        Swal.fire(
                            'Success!',
                            'Items added to your cart.',
                            'success'
                        ).then(() => {
                            window.location.href = '/cart';
                        });
                    },
                    error: function() {
                        Swal.fire('Error!', 'Unable to reorder items.', 'error');
                    }
                });
            }
        });
    });
    
    // Write review
    $('.write-review').click(function() {
        Swal.fire({
            title: 'Write a Review',
            html: `
                <div class="text-left">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                    <div class="flex justify-center gap-2 mb-4">
                        <i class="fas fa-star text-2xl cursor-pointer hover:text-yellow-400 star-rating" data-rating="1"></i>
                        <i class="fas fa-star text-2xl cursor-pointer hover:text-yellow-400 star-rating" data-rating="2"></i>
                        <i class="fas fa-star text-2xl cursor-pointer hover:text-yellow-400 star-rating" data-rating="3"></i>
                        <i class="fas fa-star text-2xl cursor-pointer hover:text-yellow-400 star-rating" data-rating="4"></i>
                        <i class="fas fa-star text-2xl cursor-pointer hover:text-yellow-400 star-rating" data-rating="5"></i>
                    </div>
                    <input type="hidden" id="ratingValue" value="0">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Review</label>
                    <textarea id="reviewText" class="w-full px-3 py-2 border border-gray-300 rounded-lg" rows="3" placeholder="Share your experience..."></textarea>
                </div>
            `,
            showCancelButton: true,
            confirmButtonColor: '#667eea',
            confirmButtonText: 'Submit Review',
            didOpen: () => {
                let selectedRating = 0;
                $('.star-rating').click(function() {
                    let rating = $(this).data('rating');
                    selectedRating = rating;
                    $('#ratingValue').val(rating);
                    $('.star-rating').css('color', '#d1d5db');
                    for (let i = 1; i <= rating; i++) {
                        $(`.star-rating[data-rating="${i}"]`).css('color', '#fbbf24');
                    }
                });
            },
            preConfirm: () => {
                let rating = $('#ratingValue').val();
                let review = $('#reviewText').val();
                if (rating == 0) {
                    Swal.showValidationMessage('Please select a rating');
                    return false;
                }
                if (!review) {
                    Swal.showValidationMessage('Please write a review');
                    return false;
                }
                return { rating: rating, review: review };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire('Thank you!', 'Your review has been submitted.', 'success');
            }
        });
    });
});
</script>
@endsection