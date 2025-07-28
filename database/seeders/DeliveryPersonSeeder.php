<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\DeliveryPerson;
use App\Models\Governorate;
use App\Models\User;
use Illuminate\Database\Seeder;

class DeliveryPersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $deliveryUsers = User::where('role', Role::DELIVERY_PERSON->value)->get();
        $governorates = Governorate::all();
        $vehicleTypes = [
            'Toyota Hilux - Pickup truck',
            'Nissan Navara - Pickup truck',
            'Ford Ranger - Pickup truck',
            'Mitsubishi L200 - Pickup truck',
            'Isuzu D-Max - Pickup truck',
            'Suzuki Carry - Mini truck',
            'Daihatsu Hijet - Mini truck',
            'Honda Acty - Mini truck',
            'Mazda Bongo - Van',
            'Toyota Hiace - Van'
        ];

        foreach ($deliveryUsers as $index => $deliveryUser) {
            // Assign delivery person to a governorate (distribute evenly)
            $assignedGovernorate = $governorates[$index % $governorates->count()];

            DeliveryPerson::create([
                'user_id' => $deliveryUser->id,
                'vehicle_description' => $vehicleTypes[$index % count($vehicleTypes)],
                'driving_license_number' => 'DP-' . str_pad($index + 1, 6, '0', STR_PAD_LEFT),
                'assigned_governorate_id' => $assignedGovernorate->id,
            ]);
        }
    }
}
