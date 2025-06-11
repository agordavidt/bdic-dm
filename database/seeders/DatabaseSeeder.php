<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default admin user
        User::create([
            'name' => 'BDIC Admin',
            'email' => 'admin@bdic.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'phone' => '+234-800-BDIC-ADMIN',
            'status' => 'active',
        ]);

        // Create sample vendor
        User::create([
            'name' => 'John Vendor',
            'email' => 'vendor@example.com',
            'password' => Hash::make('password123'),
            'role' => 'vendor',
            'phone' => '+234-800-VENDOR-01',
            'company_name' => 'Tech Solutions Ltd',
            'status' => 'active',
        ]);

        // Create sample buyer
        User::create([
            'name' => 'Jane Buyer',
            'email' => 'buyer@example.com',
            'password' => Hash::make('password123'),
            'role' => 'buyer',
            'phone' => '+234-800-BUYER-01',
            'status' => 'active',
        ]);

        // Create sample manufacturer
        User::create([
            'name' => 'BDIC Manufacturer',
            'email' => 'manufacturer@bdic.com',
            'password' => Hash::make('password123'),
            'role' => 'manufacturer',
            'phone' => '+234-800-BDIC-MFG',
            'company_name' => 'BDIC Manufacturing',
            'status' => 'active',
        ]);
    }
}