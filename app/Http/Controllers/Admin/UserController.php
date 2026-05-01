<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        $query = User::withCount('orders')->orderBy('created_at', 'desc');

        // Handle Search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Handle Role Filter
        if ($request->has('role') && !empty($request->role) && $request->role !== 'All Roles') {
            $query->where('role', strtolower($request->role));
        }

        $users = $query->paginate(20)->appends($request->query());
        return view('admin.users.index', compact('users'));
    }

    /**
     * Export users to CSV
     */
    public function export(Request $request)
    {
        $query = User::withCount('orders')->orderBy('created_at', 'desc');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->has('role') && !empty($request->role) && $request->role !== 'All Roles') {
            $query->where('role', strtolower($request->role));
        }

        $users = $query->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=users_export_" . date('Y-m-d_H-i') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($users) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Email', 'Role', 'Total Orders', 'Registered Date']);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->role ?? 'user',
                    $user->orders_count,
                    $user->created_at->format('Y-m-d H:i:s')
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    
    /**
     * Display the specified user
     */
    public function show(User $user)
    {
        // Load relationships
        $user->load(['orders.items.product', 'cart.items.product']);
        return view('admin.users.show', compact('user'));
    }
    
    /**
     * Update user role
     */
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,admin'
        ]);
        
        // Prevent changing own role
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own role.');
        }
        
        $oldRole = $user->role ?? 'user';
        $user->update(['role' => $request->role]);
        
        return back()->with('success', "User role changed from {$oldRole} to {$request->role}");
    }
    
    /**
     * Remove the specified user
     */
    public function destroy(User $user)
    {
        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        
        // Check if user has orders
        if ($user->orders()->count() > 0) {
            return back()->with('error', 'Cannot delete user with existing orders.');
        }
        
        // Delete user's cart first
        if ($user->cart) {
            $user->cart->items()->delete();
            $user->cart->delete();
        }
        
        $userName = $user->name;
        $user->delete();
        
        return redirect()->route('admin.users.index')
                        ->with('success', "User '{$userName}' deleted successfully.");
    }
    
    /**
     * Clear user's cart
     */
    public function clearCart(User $user)
    {
        if ($user->cart) {
            $itemCount = $user->cart->items->count();
            $user->cart->items()->delete();
            $user->cart->update(['total_amount' => 0]);
            
            return back()->with('success', "Cleared {$itemCount} items from user's cart.");
        }
        
        return back()->with('info', 'User cart is already empty.');
    }
}