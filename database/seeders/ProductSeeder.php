<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $souvenirs = \App\Models\Category::where('slug', 'souvenirs')->first();
        $handmade = \App\Models\Category::where('slug', 'handmade-gifts')->first();
        
        if ($souvenirs) {
            \App\Models\Product::create([
                'name' => 'City Keychain',
                'description' => 'A beautiful metallic keychain representing the city skyline.',
                'price' => 49.00,
                'stock' => 50,
                'category_id' => $souvenirs->id,
                'sku' => 'KC-CITY-01',
                'is_active' => true,
            ]);
        }
        
        if ($handmade) {
            \App\Models\Product::create([
                'name' => 'Woven Basket',
                'description' => 'Hand-woven traditional basket made from local materials.',
                'price' => 120.00,
                'stock' => 15,
                'category_id' => $handmade->id,
                'sku' => 'BSKT-01',
                'is_active' => true,
            ]);
        }
    }
}
