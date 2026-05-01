<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        $defaults = [
            'site_name'               => 'GIVIA',
            'site_email'              => 'admin@givia.com',
            'site_phone'              => '+63 900 000 0000',
            'site_address'            => 'Philippines',
            'currency'                => 'PHP',
            'free_shipping_threshold' => '2000',
            'standard_shipping_cost'  => '150',
            'express_shipping_cost'   => '350',
            'cod_enabled'             => '1',
        ];

        foreach ($defaults as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
