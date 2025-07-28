<?php

namespace Database\Seeders;

use App\Models\Checkpoint;
use App\Models\Governorate;
use Illuminate\Database\Seeder;

class CheckpointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $governorates = Governorate::all();

        // Create checkpoints for major transport corridors
        $checkpoints = [
            // Damascus - Aleppo corridor
            ['name' => 'Damascus Central Checkpoint', 'governorate' => 'Damascus'],
            ['name' => 'Homs Junction Checkpoint', 'governorate' => 'Homs'],
            ['name' => 'Hama Transit Checkpoint', 'governorate' => 'Hama'],
            ['name' => 'Aleppo Central Checkpoint', 'governorate' => 'Aleppo'],

            // Damascus - Latakia corridor
            ['name' => 'Latakia Port Checkpoint', 'governorate' => 'Latakia'],
            ['name' => 'Tartus Coastal Checkpoint', 'governorate' => 'Tartus'],

            // Damascus - Daraa corridor
            ['name' => 'Daraa Southern Checkpoint', 'governorate' => 'Daraa'],

            // Aleppo - Al-Hasakah corridor
            ['name' => 'Al-Hasakah Eastern Checkpoint', 'governorate' => 'Al-Hasakah'],
            ['name' => 'Raqqa River Checkpoint', 'governorate' => 'Raqqa'],

            // Homs - Deir ez-Zor corridor
            ['name' => 'Palmyra Desert Checkpoint', 'governorate' => 'Homs'],
            ['name' => 'Deir ez-Zor Eastern Checkpoint', 'governorate' => 'Deir ez-Zor'],

            // Additional strategic checkpoints
            ['name' => 'Idlib Northern Checkpoint', 'governorate' => 'Idlib'],
            ['name' => 'Quneitra Border Checkpoint', 'governorate' => 'Quneitra'],
            ['name' => 'As-Suwayda Mountain Checkpoint', 'governorate' => 'As-Suwayda'],
            ['name' => 'Damascus Countryside Suburban Checkpoint', 'governorate' => 'Damascus Countryside'],
        ];

        foreach ($checkpoints as $checkpoint) {
            $governorate = $governorates->where('name', $checkpoint['governorate'])->first();

            if ($governorate) {
                Checkpoint::create([
                    'name' => $checkpoint['name'],
                    'governorate_id' => $governorate->id,
                ]);
            }
        }
    }
}
