<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

try {
    // Check if admin exists
    $admin = DB::table('admin')->where('username', 'admin')->first();
    
    if (!$admin) {
        // Insert admin user
        $result = DB::table('admin')->insert([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => md5('admin123'),
        ]);
        
        if ($result) {
            echo "Admin user created successfully!\n";
        } else {
            echo "Failed to create admin user.\n";
        }
    } else {
        echo "Admin user already exists!\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 