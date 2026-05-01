<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestCheckout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:checkout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try { 
            $cart = \App\Models\Cart::first(); 
            if(!$cart) {
                $this->info('No cart');
                return 0;
            }
            
            $order = \App\Models\Order::create([
                'user_id' => $cart->user_id, 
                'order_number' => 'ORD-TEST' . uniqid(), 
                'total' => 10, 
                'subtotal' => 10, 
                'status' => 'pending', 
                'shipping_address' => 'A', 
                'billing_address' => 'A'
            ]); 
            $this->info('Order created! '); 
            
            $order->payment()->create([
                'amount' => 10, 
                'payment_method' => 'online_banking', 
                'status' => 'pending'
            ]); 
            $this->info('Payment created! '); 
            
            $order->delivery()->create([
                'status' => 'preparing', 
                'estimated_delivery' => now()->addDays(5), 
                'current_location' => 'Processing'
            ]); 
            $this->info('Delivery created! ');
            return 0;
        } catch(\Exception $e) { 
            $this->error('Error: ' . $e->getMessage()); 
            return 1;
        }
    }
}
