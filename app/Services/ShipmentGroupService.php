<?php

namespace App\Services;

use App\Models\ShipmentGroup;
use App\Models\Shipment;
use App\Models\GroupCheckpoint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShipmentGroupService extends BaseService
{
    public function __construct(ShipmentGroup $model)
    {
        parent::__construct($model);
    }

    public function create(array $data): ShipmentGroup
    {
        $code = 'GS-' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);

        // Ensure code uniqueness
        while (ShipmentGroup::where('code', $code)->exists()) {
            $code = 'GS-' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);
        }

        $data['code'] = $code;
        $data['created_by_admin_id'] = Auth::id();
        $data['last_updated_by_admin_id'] = Auth::id();

        return parent::create($data);
    }

    public function createWithShipmentsAndCheckpoints(array $data): ShipmentGroup
    {
        return DB::transaction(function () use ($data) {
            $shipmentIds = $data['shipment_ids'] ?? [];
            $checkpoints = $data['checkpoints'] ?? [];

            unset($data['shipment_ids'], $data['checkpoints']);

            $shipmentGroup = $this->create($data);

            if (!empty($shipmentIds)) {
                Shipment::whereIn('id', $shipmentIds)->update([
                    'group_id' => $shipmentGroup->id
                ]);
            }

            if (!empty($checkpoints)) {
                foreach ($checkpoints as $checkpointData) {
                    GroupCheckpoint::create([
                        'group_id' => $shipmentGroup->id,
                        'checkpoint_id' => $checkpointData['checkpoint_id'],
                        'order' => $checkpointData['order']
                    ]);
                }
            }

            return $shipmentGroup->fresh([
                'driver',
                'createdByAdmin',
                'lastUpdatedByAdmin',
                'fromGovernorate',
                'toGovernorate',
                'fromCenter',
                'toCenter',
                'groupCheckpoints.checkpoint',
                'shipments'
            ]);
        });
    }

    public function deliverShipmentGroup(int $shipmentGroupId, int $driverId): ShipmentGroup
    {
        $shipmentGroup = ShipmentGroup::with([
            'driver',
            'createdByAdmin',
            'lastUpdatedByAdmin',
            'fromGovernorate',
            'toGovernorate',
            'fromCenter',
            'toCenter',
            'groupCheckpoints',
            'shipments'
        ])->find($shipmentGroupId);

        if (!$shipmentGroup) {
            throw new \Exception('Shipment group not found');
        }

        // If driver ID is provided, validate the driver is assigned to this group
        if ($driverId && $shipmentGroup->driver_id !== $driverId) {
            throw new \Exception('Driver is not assigned to this shipment group');
        }

        return DB::transaction(function () use ($shipmentGroup) {
            // Update shipment group status to delivered
            $shipmentGroup->update([
                'status' => \App\Enums\Status::DELIVERED->value,
                'last_updated_by_admin_id' => Auth::id()
            ]);

            // Update all shipments in this group to "delivered to destination center"
            $shipmentGroup->shipments()->update([
                'status' => \App\Enums\Status::DELIVERED_TO_DESTINATION_CENTER->value
            ]);

            return $shipmentGroup->fresh([
                'driver',
                'createdByAdmin',
                'lastUpdatedByAdmin',
                'fromGovernorate',
                'toGovernorate',
                'fromCenter',
                'toCenter',
                'groupCheckpoints',
                'shipments'
            ]);
        });
    }

    public function updateShipmentGroupStatus(int $shipmentGroupId, string $status, int $driverId): ShipmentGroup
    {
        $shipmentGroup = ShipmentGroup::with([
            'driver',
            'createdByAdmin',
            'lastUpdatedByAdmin',
            'fromGovernorate',
            'toGovernorate',
            'fromCenter',
            'toCenter',
            'groupCheckpoints'
        ])->find($shipmentGroupId);

        if (!$shipmentGroup) {
            throw new \Exception('Shipment group not found');
        }

        // If driver ID is provided, validate the driver is assigned to this group
        if ($driverId && $shipmentGroup->driver_id !== $driverId) {
            throw new \Exception('Driver is not assigned to this shipment group');
        }

        $shipmentGroup->update([
            'status' => $status,
            'last_updated_by_admin_id' => Auth::id()
        ]);

        return $shipmentGroup->fresh([
            'driver',
            'createdByAdmin',
            'lastUpdatedByAdmin',
            'fromGovernorate',
            'toGovernorate',
            'fromCenter',
            'toCenter',
            'groupCheckpoints'
        ]);
    }

    public function getShipmentGroupCheckpoints(int $shipmentGroupId): \Illuminate\Support\Collection
    {
        $shipmentGroup = ShipmentGroup::with([
            'groupCheckpoints.checkpoint',
            'groupCheckpoints.groupTracking'
        ])->find($shipmentGroupId);

        if (!$shipmentGroup) {
            throw new \Exception('Shipment group not found');
        }

        // Get all group checkpoints with their tracking status
        $checkpoints = $shipmentGroup->groupCheckpoints->map(function ($groupCheckpoint) {
            return [
                'id' => $groupCheckpoint->id,
                'group_id' => $groupCheckpoint->group_id,
                'checkpoint_id' => $groupCheckpoint->checkpoint_id,
                'order' => $groupCheckpoint->order,
                'created_at' => $groupCheckpoint->created_at,
                'updated_at' => $groupCheckpoint->updated_at,
                'checkpoint' => [
                    'id' => $groupCheckpoint->checkpoint->id,
                    'name' => $groupCheckpoint->checkpoint->name,
                    'description' => $groupCheckpoint->checkpoint->description,
                    'location' => $groupCheckpoint->checkpoint->location,
                    'created_at' => $groupCheckpoint->checkpoint->created_at,
                    'updated_at' => $groupCheckpoint->checkpoint->updated_at,
                ],
                'is_checked' => $groupCheckpoint->groupTracking ? true : false,
                'arrival_time' => $groupCheckpoint->groupTracking ? $groupCheckpoint->groupTracking->created_at : null,
            ];
        });

        return $checkpoints->sortBy('order');
    }

    public function markCheckpointAsChecked(int $shipmentGroupId, int $checkpointId, int $driverId): array
    {
        $shipmentGroup = ShipmentGroup::find($shipmentGroupId);

        if (!$shipmentGroup) {
            throw new \Exception('Shipment group not found');
        }

        // Validate that the driver is assigned to this group
        if ($shipmentGroup->driver_id !== $driverId) {
            throw new \Exception('Driver is not assigned to this shipment group');
        }

        // Check if the checkpoint exists in this group
        $groupCheckpoint = \App\Models\GroupCheckpoint::where('group_id', $shipmentGroupId)
            ->where('checkpoint_id', $checkpointId)
            ->first();

        if (!$groupCheckpoint) {
            throw new \Exception('Checkpoint not found in this shipment group');
        }

        // Check if checkpoint is already marked as checked
        $existingTracking = \App\Models\GroupTracking::where('group_id', $shipmentGroupId)
            ->where('checkpoint_id', $checkpointId)
            ->first();

        if ($existingTracking) {
            throw new \Exception('Checkpoint is already marked as checked');
        }

        return DB::transaction(function () use ($shipmentGroupId, $checkpointId) {
            // Create new group tracking record
            $groupTracking = \App\Models\GroupTracking::create([
                'group_id' => $shipmentGroupId,
                'checkpoint_id' => $checkpointId,
                'arrival_time' => now()
            ]);

            // Get updated checkpoint list
            $updatedCheckpoints = $this->getShipmentGroupCheckpoints($shipmentGroupId);

            return [
                'group_tracking' => $groupTracking,
                'checkpoints' => $updatedCheckpoints
            ];
        });
    }
}
