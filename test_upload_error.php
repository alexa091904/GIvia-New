<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$file = new \Illuminate\Http\UploadedFile(
    __DIR__.'/artisan', // fake path
    'fake.jpg',
    'image/jpeg',
    1, // error = UPLOAD_ERR_INI_SIZE
    true
);

$validator = Validator::make(
    ['image' => $file], 
    ['image' => 'nullable|image|max:2048']
);

echo json_encode($validator->errors()) . "\n";
