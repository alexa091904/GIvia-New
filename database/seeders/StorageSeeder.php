<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class StorageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ensure products directory exists
        if (!Storage::disk('public')->exists('products')) {
            Storage::disk('public')->makeDirectory('products');
        }

        // Path to the placeholder in storage
        $targetPath = storage_path('app/public/products/placeholder.png');

        // If the file doesn't exist, we can't seed it from nothing easily without a source
        // But since we just created it manually, this seeder will mainly be used to 
        // ensure the structure is correct for future products.
        
        $this->command->info('Storage directory for products verified.');
        
        if (File::exists($targetPath)) {
            $this->command->info('Placeholder image found.');
        } else {
            $this->command->warn('Placeholder image not found. Please upload a placeholder.png to storage/app/public/products/');
        }
    }
}
