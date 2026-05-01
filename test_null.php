<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$validator = Validator::make(
    ['image' => null], 
    ['image' => 'nullable|image|max:2048']
);

echo json_encode($validator->errors()) . "\n";
