<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::where('role', 'admin')->first();
if (!$user) {
    echo "No admin user found.\n";
    exit;
}

$routesToTest = [
    '/admin/dashboard',
    '/admin/products',
    '/admin/orders',
    '/admin/inventory',
    '/admin/users',
    '/admin/reports',
    '/admin/settings'
];

$httpKernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

foreach ($routesToTest as $uri) {
    echo "Testing $uri ... ";
    $request = Illuminate\Http\Request::create($uri, 'GET');
    $request->setUserResolver(function () use ($user) {
        return $user;
    });
    
    auth()->login($user);
    
    try {
        $response = $httpKernel->handle($request);
        if ($response->getStatusCode() === 200) {
            echo "OK\n";
        } else {
            echo "FAILED (Status: " . $response->getStatusCode() . ")\n";
            echo substr($response->getContent(), 0, 500) . "\n";
        }
    } catch (\Exception $e) {
        echo "ERROR: " . $e->getMessage() . "\n";
        echo $e->getTraceAsString() . "\n";
    }
}
