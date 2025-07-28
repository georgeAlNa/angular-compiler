<?php

namespace Database\Seeders;

use App\Models\CompanyCenter;
use App\Models\Governorate;
use Illuminate\Database\Seeder;

class CompanyCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $governorates = Governorate::all();

        foreach ($governorates as $governorate) {
            // Create 1-2 centers per governorate
            $numCenters = rand(1, 2);

            for ($i = 1; $i <= $numCenters; $i++) {
                CompanyCenter::create([
                    'name' => "{$governorate->name} Center {$i}",
                    'location' => "Main Street, {$governorate->name}",
                    'governorate_id' => $governorate->id,
                ]);
            }
        }
    }
}
