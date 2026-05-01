<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::where('role', 'admin')->first();
$product = App\Models\Product::first();

$request = Illuminate\Http\Request::create('/admin/products/' . $product->id . '/edit', 'GET');
$request->setUserResolver(function () use ($user) {
    return $user;
});

auth()->login($user);
$response = app()->make(Illuminate\Contracts\Http\Kernel::class)->handle($request);
$content = $response->getContent();

if (preg_match('/<form[^>]+>/', $content, $matches)) {
    echo "Form tag found:\n" . $matches[0] . "\n";
} else {
    echo "Form tag not found.\n";
}
