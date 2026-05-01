<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $user = Auth::user();
        
        // Check if orders table exists
        $hasOrdersTable = Schema::hasTable('orders');
        $hasTotalColumn = $hasOrdersTable && Schema::hasColumn('orders', 'total');
        $hasStatusColumn = $hasOrdersTable && Schema::hasColumn('orders', 'status');
        
        // Initialize variables with default values
        $totalOrders = 0;
        $totalSpent = 0;
        $pendingOrders = 0;
        $recentOrders = collect();
        
        if ($hasOrdersTable) {
            try {
                // Get total orders count
                $totalOrders = Order::where('user_id', $user->id)->count();
                
                // Get total spent (only if total column exists)
                if ($hasTotalColumn) {
                    $totalSpent = Order::where('user_id', $user->id)
                        ->where('status', '!=', 'cancelled')
                        ->sum('total');
                }
                
                // Get pending orders count (only if status column exists)
                if ($hasStatusColumn) {
                    $pendingOrders = Order::where('user_id', $user->id)
                        ->whereIn('status', ['pending', 'processing'])
                        ->count();
                }
                
                // Get recent orders (last 5)
                $recentOrders = Order::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();
                    
            } catch (\Exception $e) {
                \Log::error('Dashboard query error: ' . $e->getMessage());
            }
        }
        
        // Get wishlist count
        $wishlistCount = 0;
        
        // Get recently viewed products from session
        $recentlyViewed = collect();
        if (session()->has('recently_viewed') && Schema::hasTable('products')) {
            $recentIds = session()->get('recently_viewed');
            if (!empty($recentIds)) {
                try {
                    $recentlyViewed = Product::whereIn('id', $recentIds)->limit(4)->get();
                } catch (\Exception $e) {
                    $recentlyViewed = collect();
                }
            }
        }
        
        return view('dashboard', compact(
            'totalOrders',
            'totalSpent',
            'pendingOrders',
            'wishlistCount',
            'recentOrders',
            'recentlyViewed'
        ));
    }
}