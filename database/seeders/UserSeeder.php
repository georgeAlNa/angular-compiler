<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 Admins
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => "Admin User {$i}",
                'email' => "admin{$i}@cargotransport.com",
                'password' => Hash::make('password123'),
                'phone' => "+963" . rand(900000000, 999999999),
                'address' => "Admin Address {$i}, Damascus",
                'age' => rand(25, 60),
                'role' => Role::ADMIN->value,
                'email_verified_at' => now(),
            ]);
        }

        // Create 30 Drivers
        for ($i = 1; $i <= 30; $i++) {
            User::create([
                'name' => "Driver User {$i}",
                'email' => "driver{$i}@cargotransport.com",
                'password' => Hash::make('password123'),
                'phone' => "+963" . rand(900000000, 999999999),
                'address' => "Driver Address {$i}, Damascus",
                'age' => rand(25, 55),
                'role' => Role::DRIVER->value,
                'email_verified_at' => now(),
            ]);
        }

        // Create 50 Delivery Persons
        for ($i = 1; $i <= 50; $i++) {
            User::create([
                'name' => "Delivery Person {$i}",
                'email' => "delivery{$i}@cargotransport.com",
                'password' => Hash::make('password123'),
                'phone' => "+963" . rand(900000000, 999999999),
                'address' => "Delivery Address {$i}, Damascus",
                'age' => rand(20, 50),
                'role' => Role::DELIVERY_PERSON->value,
                'email_verified_at' => now(),
            ]);
        }

        // Create 75 Customers
        for ($i = 1; $i <= 75; $i++) {
            User::create([
                'name' => "Customer User {$i}",
                'email' => "customer{$i}@cargotransport.com",
                'password' => Hash::make('password123'),
                'phone' => "+963" . rand(900000000, 999999999),
                'address' => "Customer Address {$i}, Damascus",
                'age' => rand(18, 70),
                'role' => Role::CUSTOMER->value,
                'email_verified_at' => now(),
            ]);
        }
    }
}
