<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::firstOrCreate(
            ['email' => 'admin@givia.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('Admin@1234'),
                'role' => 'admin'
            ]
        );
    }
}