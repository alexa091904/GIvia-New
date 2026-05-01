<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page
     */
    public function index()
    {
        // Get user's cart with items
        $cart = Cart::where('user_id', Auth::id())
                    ->with('items.product')
                    ->first();
        
        // Check if cart exists and has items
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                           ->with('error', 'Your cart is empty. Please add some items first.');
        }
        
        // Calculate totals
        $subtotal = $cart->items->sum(function($item) {
            return $item->quantity * $item->product->price;
        });
        
        // Get coupon discount if applied
        $discount = session('discount', 0);
        $coupon = session('coupon');
        
        // Calculate shipping (simple logic - can be enhanced)
        $shipping = $subtotal > 50 ? 0 : 5.99;
        
        // Calculate tax (10% tax rate)
        $tax = ($subtotal - $discount) * 0.10;
        
        // Calculate total
        $total = $subtotal - $discount + $shipping + $tax;
        
        return view('checkout', compact(
            'cart', 
            'subtotal', 
            'discount', 
            'coupon', 
            'shipping', 
            'tax', 
            'total'
        ));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'country' => 'required|string',
            'payment_method' => 'required|string'
        ]);
        
        $cart = Cart::where('user_id', Auth::id())
                   ->with('items.product')
                   ->first();
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty');
        }
        
        $fullAddress = $request->address . ', ' . $request->city . ', ' . $request->postal_code . ', ' . $request->country;
        
        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            $totalAmount = 0;
            $orderItems = [];
            
            foreach ($cart->items as $item) {
                $product = $item->product;
                if ($product->stock < $item->quantity) {
                    throw new \Exception("Insufficient stock for {$product->name}");
                }
                $totalAmount += $item->quantity * $product->price;
                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $item->quantity,
                    'price' => $product->price,
                    'product_name' => $product->name
                ];
            }
            
            $shipping = $totalAmount > 50 ? 0 : 5.99;
            $tax = $totalAmount * 0.10;
            $finalTotal = $totalAmount + $shipping + $tax;
            
            $order = \App\Models\Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'total' => $finalTotal,
                'subtotal' => $totalAmount,
                'status' => 'pending',
                'shipping_address' => $fullAddress,
                'billing_address' => $fullAddress
            ]);
            
            foreach ($orderItems as $item) {
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
                
                $product = \App\Models\Product::find($item['product_id']);
                $oldStock = $product->stock;
                $product->decrement('stock', $item['quantity']);
                
                \App\Models\InventoryLog::create([
                    'product_id' => $product->id,
                    'quantity_change' => -$item['quantity'],
                    'old_quantity' => $oldStock,
                    'new_quantity' => $product->stock,
                    'reason' => 'order_placed',
                    'reference_id' => $order->id,
                    'notes' => "Order #{$order->order_number} - {$item['quantity']} x {$item['product_name']}"
                ]);
            }
            
            $order->payment()->create([
                'amount' => $finalTotal,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
                'transaction_id' => null
            ]);
            
            $order->delivery()->create([
                'status' => 'pending',
                'estimated_delivery' => now()->addDays(5),
                'tracking_number' => null,
                'current_location' => 'Processing'
            ]);
            
            $cart->items()->delete();
            $cart->update(['total_amount' => 0]);
            
            \Illuminate\Support\Facades\DB::commit();
            
            return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}