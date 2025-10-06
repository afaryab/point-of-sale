<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Counter;
use App\Models\Product;
use App\Models\Service;
use App\Models\ServiceProvider;
use App\Models\Plan;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;

class InitialDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@pos.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create reception user
        User::create([
            'name' => 'Reception User',
            'email' => 'reception@pos.com',
            'password' => Hash::make('password'),
            'role' => 'reception',
        ]);

        // Create counters
        Counter::create(['name' => 'Counter 1', 'status' => 'closed']);
        Counter::create(['name' => 'Counter 2', 'status' => 'closed']);

        // Create products
        Product::create([
            'name' => 'Laptop',
            'description' => 'High-performance laptop',
            'price' => 999.99,
            'quantity' => 10,
            'sku' => 'LAP-001',
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'Mouse',
            'description' => 'Wireless mouse',
            'price' => 29.99,
            'quantity' => 50,
            'sku' => 'MOU-001',
            'is_active' => true,
        ]);

        // Create services
        Service::create([
            'name' => 'Haircut',
            'description' => 'Professional haircut service',
            'price' => 25.00,
            'duration' => 30,
            'requires_provider' => true,
            'is_active' => true,
        ]);

        Service::create([
            'name' => 'Consultation',
            'description' => 'Professional consultation',
            'price' => 100.00,
            'duration' => 60,
            'requires_provider' => true,
            'is_active' => true,
        ]);

        // Create service providers
        ServiceProvider::create([
            'name' => 'John Doe',
            'email' => 'john@pos.com',
            'phone' => '123-456-7890',
            'is_active' => true,
        ]);

        ServiceProvider::create([
            'name' => 'Jane Smith',
            'email' => 'jane@pos.com',
            'phone' => '123-456-7891',
            'is_active' => true,
        ]);

        // Create plans
        Plan::create([
            'name' => 'Basic Package',
            'description' => 'Basic service package',
            'price' => 199.99,
            'is_active' => true,
        ]);

        // Create settings
        Setting::create([
            'key' => 'default_payment_type',
            'value' => 'prepaid',
            'type' => 'string',
            'description' => 'Default payment type for bills',
        ]);

        Setting::create([
            'key' => 'tax_rate',
            'value' => '0',
            'type' => 'integer',
            'description' => 'Tax rate percentage',
        ]);
    }
}
