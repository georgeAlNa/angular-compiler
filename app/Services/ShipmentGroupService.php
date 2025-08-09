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

    public function update(int $id, array $data): ShipmentGroup
    {
        $shipmentIds = $data['shipment_ids'] ?? null;
        $checkpoints = $data['checkpoints'] ?? null;
        unset($data['shipment_ids'], $data['checkpoints']);

        return DB::transaction(function () use ($id, $data, $shipmentIds, $checkpoints) {
            $shipmentGroup = ShipmentGroup::with(['shipments', 'groupCheckpoints'])->find($id);
            if (!$shipmentGroup) {
                throw new \Exception('Shipment group not found');
            }

            // Update group fields
            $data['last_updated_by_admin_id'] = Auth::id();
            if (!empty($data)) {
                $shipmentGroup->update($data);
            }

            // Replace shipments set if provided
            if (is_array($shipmentIds)) {
                $newShipmentIds = array_values(array_unique(array_map('intval', $shipmentIds)));

                $currentShipmentIds = $shipmentGroup->shipments->pluck('id')->all();
                $toDetach = array_diff($currentShipmentIds, $newShipmentIds);
                $toAttach = array_diff($newShipmentIds, $currentShipmentIds);

                if (!empty($toDetach)) {
                    Shipment::whereIn('id', $toDetach)->update(['group_id' => null]);
                }

                if (!empty($toAttach)) {
                    Shipment::whereIn('id', $toAttach)->update(['group_id' => $shipmentGroup->id]);
                }
            }

            // Replace checkpoints set if provided
            if (is_array($checkpoints)) {
                // Normalize checkpoints: keep entries with checkpoint_id and order
                $normalized = [];
                foreach ($checkpoints as $cp) {
                    if (isset($cp['checkpoint_id'])) {
                        $normalized[] = [
                            'checkpoint_id' => (int) $cp['checkpoint_id'],
                            'order' => (int) ($cp['order'] ?? 0),
                        ];
                    }
                }

                $newCheckpointIds = array_column($normalized, 'checkpoint_id');

                // Remove checkpoints no longer in the list
                if (!empty($newCheckpointIds)) {
                    GroupCheckpoint::where('group_id', $shipmentGroup->id)
                        ->whereNotIn('checkpoint_id', $newCheckpointIds)
                        ->delete();

                    // Also remove group trackings for those removed checkpoints
                    \App\Models\GroupTracking::where('group_id', $shipmentGroup->id)
                        ->whereNotIn('checkpoint_id', $newCheckpointIds)
                        ->delete();
                } else {
                    // If empty array provided, clear all checkpoints and trackings
                    GroupCheckpoint::where('group_id', $shipmentGroup->id)->delete();
                    \App\Models\GroupTracking::where('group_id', $shipmentGroup->id)->delete();
                }

                // Upsert checkpoints with new order
                foreach ($normalized as $cp) {
                    GroupCheckpoint::updateOrCreate(
                        [
                            'group_id' => $shipmentGroup->id,
                            'checkpoint_id' => $cp['checkpoint_id'],
                        ],
                        [
                            'order' => $cp['order'],
                        ]
                    );
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
                'shipments',
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

        return DB::transaction(function () use ($shipmentGroup, $status) {
            $shipmentGroup->update([
                'status' => $status,
                'last_updated_by_admin_id' => Auth::id()
            ]);

            if ($status === \App\Enums\Status::IN_TRANSIT->value) {
                // Start shipment: mark all shipments as in transit
                $shipmentGroup->shipments()->update([
                    'status' => \App\Enums\Status::IN_TRANSIT->value
                ]);
            } elseif ($status === \App\Enums\Status::DELIVERED->value) {
                // End shipment: mark all shipments as delivered to destination center
                $shipmentGroup->shipments()->update([
                    'status' => \App\Enums\Status::DELIVERED_TO_DESTINATION_CENTER->value
                ]);
            }

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
