<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\GroupCheckpoint;
use App\Models\GroupTracking;
use App\Models\ShipmentGroup;
use Illuminate\Database\Seeder;

class GroupTrackingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shipmentGroups = ShipmentGroup::whereIn('status', [Status::IN_TRANSIT->value, Status::DELIVERED->value])->get();

        foreach ($shipmentGroups as $group) {
            // Get checkpoints for this group
            $groupCheckpoints = GroupCheckpoint::where('group_id', $group->id)
                ->orderBy('order')
                ->get();

            // Create tracking records for some checkpoints (simulating progress)
            $trackedCheckpoints = $groupCheckpoints->take(rand(1, $groupCheckpoints->count()));

            foreach ($trackedCheckpoints as $checkpoint) {
                // Create tracking record with realistic timestamp
                $trackingDate = now()->subDays(rand(1, 30))->subHours(rand(1, 24));

                GroupTracking::create([
                    'group_id' => $group->id,
                    'checkpoint_id' => $checkpoint->checkpoint_id,
                    'created_at' => $trackingDate,
                    'updated_at' => $trackingDate,
                ]);
            }
        }
    }
}
