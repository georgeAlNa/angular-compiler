<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $driverUsers = User::where('role', Role::DRIVER->value)->get();
        $vehicleTypes = [
            'Mercedes-Benz Actros 1844 - 18-ton truck',
            'Volvo FH16 - 20-ton truck',
            'Scania R500 - 16-ton truck',
            'MAN TGX 18.510 - 18-ton truck',
            'Iveco Stralis - 15-ton truck',
            'DAF XF 105 - 16-ton truck',
            'Renault Magnum - 18-ton truck',
            'Ford Cargo - 12-ton truck',
            'Isuzu NPR - 8-ton truck',
            'Hino 500 Series - 10-ton truck'
        ];

        foreach ($driverUsers as $index => $driverUser) {
            Driver::create([
                'user_id' => $driverUser->id,
                'vehicle_description' => $vehicleTypes[$index % count($vehicleTypes)],
                'driving_license_number' => 'DL-' . str_pad($index + 1, 6, '0', STR_PAD_LEFT),
            ]);
        }
    }
}
