<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$validator = Validator::make(
    ['image' => ''], 
    ['image' => 'nullable|image|max:2048']
);

echo "Empty string:\n";
echo json_encode($validator->errors()) . "\n";

$validator = Validator::make(
    [], 
    ['image' => 'nullable|image|max:2048']
);

echo "Not present:\n";
echo json_encode($validator->errors()) . "\n";
