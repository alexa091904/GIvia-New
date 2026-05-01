<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Get data for dashboard
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalUsers = User::count();
        $totalRevenue = Order::sum('total');
        $recentOrders = Order::with('user')->latest()->take(5)->get();
        $lowStockProducts = Product::where('stock', '<', 10)->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalUsers',
            'totalRevenue',
            'recentOrders',
            'lowStockProducts'
        ));
    }
}