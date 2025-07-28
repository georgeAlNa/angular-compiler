<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Enums\Status;
use App\Models\CompanyCenter;
use App\Models\Driver;
use App\Models\Governorate;
use App\Models\ShipmentGroup;
use App\Models\User;
use Illuminate\Database\Seeder;

class ShipmentGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $governorates = Governorate::all();
        $drivers = Driver::all();
        $admins = User::where('role', Role::ADMIN->value)->get();
        $companyCenters = CompanyCenter::all();

        // Major transport corridors
        $routes = [
            // Damascus - Aleppo corridor
            ['from' => 'Damascus', 'to' => 'Aleppo', 'description' => 'Main Damascus to Aleppo route via Homs and Hama'],
            ['from' => 'Aleppo', 'to' => 'Damascus', 'description' => 'Main Aleppo to Damascus route via Hama and Homs'],

            // Damascus - Latakia corridor
            ['from' => 'Damascus', 'to' => 'Latakia', 'description' => 'Damascus to Latakia coastal route'],
            ['from' => 'Latakia', 'to' => 'Damascus', 'description' => 'Latakia to Damascus coastal route'],

            // Damascus - Daraa corridor
            ['from' => 'Damascus', 'to' => 'Daraa', 'description' => 'Damascus to Daraa southern route'],
            ['from' => 'Daraa', 'to' => 'Damascus', 'description' => 'Daraa to Damascus southern route'],

            // Aleppo - Al-Hasakah corridor
            ['from' => 'Aleppo', 'to' => 'Al-Hasakah', 'description' => 'Aleppo to Al-Hasakah eastern route'],
            ['from' => 'Al-Hasakah', 'to' => 'Aleppo', 'description' => 'Al-Hasakah to Aleppo eastern route'],

            // Homs - Deir ez-Zor corridor
            ['from' => 'Homs', 'to' => 'Deir ez-Zor', 'description' => 'Homs to Deir ez-Zor via Palmyra'],
            ['from' => 'Deir ez-Zor', 'to' => 'Homs', 'description' => 'Deir ez-Zor to Homs via Palmyra'],

            // Additional routes
            ['from' => 'Damascus', 'to' => 'Tartus', 'description' => 'Damascus to Tartus coastal route'],
            ['from' => 'Tartus', 'to' => 'Damascus', 'description' => 'Tartus to Damascus coastal route'],
            ['from' => 'Aleppo', 'to' => 'Raqqa', 'description' => 'Aleppo to Raqqa northern route'],
            ['from' => 'Raqqa', 'to' => 'Aleppo', 'description' => 'Raqqa to Aleppo northern route'],
        ];

        foreach ($routes as $index => $route) {
            $fromGovernorate = $governorates->where('name', $route['from'])->first();
            $toGovernorate = $governorates->where('name', $route['to'])->first();

            if ($fromGovernorate && $toGovernorate) {
                // Get centers for these governorates
                $fromCenter = $companyCenters->where('governorate_id', $fromGovernorate->id)->first();
                $toCenter = $companyCenters->where('governorate_id', $toGovernorate->id)->first();

                if ($fromCenter && $toCenter) {
                    $statuses = [Status::PENDING_FOR_ASSIGNMENT->value, Status::IN_TRANSIT->value, Status::DELIVERED->value];
                    $status = $statuses[$index % count($statuses)]; // Distribute statuses

                    ShipmentGroup::create([
                        'driver_id' => $drivers[$index % $drivers->count()]->id,
                        'created_by_admin_id' => $admins->random()->id,
                        'last_updated_by_admin_id' => $admins->random()->id,
                        'from_governorate_id' => $fromGovernorate->id,
                        'to_governorate_id' => $toGovernorate->id,
                        'from_center_id' => $fromCenter->id,
                        'to_center_id' => $toCenter->id,
                        'route_description' => $route['description'],
                        'status' => $status,
                        'code' => 'SG-' . str_pad($index + 1, 6, '0', STR_PAD_LEFT),
                    ]);
                }
            }
        }
    }
}
