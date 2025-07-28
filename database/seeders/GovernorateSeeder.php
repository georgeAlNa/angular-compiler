<?php

namespace Database\Seeders;

use App\Models\Governorate;
use Illuminate\Database\Seeder;

class GovernorateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $governorates = [
            'Damascus',
            'Aleppo',
            'Homs',
            'Hama',
            'Latakia',
            'Tartus',
            'Idlib',
            'Raqqa',
            'Deir ez-Zor',
            'Al-Hasakah',
            'Quneitra',
            'Daraa',
            'As-Suwayda',
            'Damascus Countryside'
        ];

        foreach ($governorates as $governorate) {
            Governorate::create([
                'name' => $governorate
            ]);
        }
    }
}
