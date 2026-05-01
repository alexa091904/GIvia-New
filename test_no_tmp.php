<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$file = new \Illuminate\Http\UploadedFile(
    '', // fake path
    '',
    '',
    UPLOAD_ERR_NO_TMP_DIR, // 6
    true
);

$validator = Validator::make(
    ['image' => $file], 
    ['image' => 'nullable|image|max:2048']
);

echo json_encode($validator->errors()) . "\n";
