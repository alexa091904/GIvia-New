<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$path = __DIR__ . '/test_img.jpg';
file_put_contents($path, "\xFF\xD8\xFF\xE0\x00\x10JFIF\x00\x01\x01\x01\x00\x48\x00\x48\x00\x00"); // Fake JPG header

$file = new \Illuminate\Http\UploadedFile(
    $path, 
    'test_img.jpg',
    'image/jpeg',
    0, 
    true
);

$validator = Validator::make(
    ['image' => $file], 
    ['image' => 'nullable|image|max:2048']
);

echo json_encode($validator->errors()) . "\n";
