<?php

namespace Database\Seeders;

use App\Models\Checkpoint;
use App\Models\Governorate;
use App\Models\GroupCheckpoint;
use App\Models\ShipmentGroup;
use Illuminate\Database\Seeder;

class GroupCheckpointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shipmentGroups = ShipmentGroup::all();
        $checkpoints = Checkpoint::all();
        $governorates = Governorate::all();

        foreach ($shipmentGroups as $group) {
            $fromGovernorate = $governorates->find($group->from_governorate_id);
            $toGovernorate = $governorates->find($group->to_governorate_id);

            // Get checkpoints along the route
            $routeCheckpoints = $this->getRouteCheckpoints($fromGovernorate, $toGovernorate, $checkpoints);

            // Create group checkpoints with proper ordering
            foreach ($routeCheckpoints as $order => $checkpoint) {
                GroupCheckpoint::create([
                    'group_id' => $group->id,
                    'checkpoint_id' => $checkpoint->id,
                    'order' => $order + 1,
                ]);
            }
        }
    }

    private function getRouteCheckpoints($fromGovernorate, $toGovernorate, $checkpoints)
    {
        $routeCheckpoints = [];
        $governorates = \App\Models\Governorate::all();

        // Define route checkpoints based on governorate pairs
        $routeMap = [
            'Damascus-Aleppo' => ['Damascus', 'Homs', 'Hama', 'Aleppo'],
            'Aleppo-Damascus' => ['Aleppo', 'Hama', 'Homs', 'Damascus'],
            'Damascus-Latakia' => ['Damascus', 'Latakia'],
            'Latakia-Damascus' => ['Latakia', 'Damascus'],
            'Damascus-Daraa' => ['Damascus', 'Daraa'],
            'Daraa-Damascus' => ['Daraa', 'Damascus'],
            'Aleppo-Al-Hasakah' => ['Aleppo', 'Raqqa', 'Al-Hasakah'],
            'Al-Hasakah-Aleppo' => ['Al-Hasakah', 'Raqqa', 'Aleppo'],
            'Homs-Deir ez-Zor' => ['Homs', 'Deir ez-Zor'],
            'Deir ez-Zor-Homs' => ['Deir ez-Zor', 'Homs'],
            'Damascus-Tartus' => ['Damascus', 'Tartus'],
            'Tartus-Damascus' => ['Tartus', 'Damascus'],
            'Aleppo-Raqqa' => ['Aleppo', 'Raqqa'],
            'Raqqa-Aleppo' => ['Raqqa', 'Aleppo'],
        ];

        $routeKey = $fromGovernorate->name . '-' . $toGovernorate->name;

        if (isset($routeMap[$routeKey])) {
            $governorateNames = $routeMap[$routeKey];

            foreach ($governorateNames as $governorateName) {
                $checkpoint = $checkpoints->where('governorate_id',
                    $governorates->where('name', $governorateName)->first()->id)->first();

                if ($checkpoint) {
                    $routeCheckpoints[] = $checkpoint;
                }
            }
        }

        return $routeCheckpoints;
    }
}
