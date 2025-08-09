<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Services\DriverService;
use App\Services\ShipmentGroupService;
use App\Http\Resources\DriverResource;
use App\Http\Resources\ShipmentGroupResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DriverController extends BaseController
{
    public function __construct(DriverService $service)
    {
        parent::__construct($service);
        $this->resourceClass = DriverResource::class;
    }

    public function getAvailableShipmentsGroup(): JsonResponse
    {
        try {
            $driverService = app(DriverService::class);
            $shipmentGroups = $driverService->getAvailableShipmentsGroup();

            return response()->json([
                'success' => true,
                'message' => 'Available shipment groups retrieved successfully',
                'data' => ShipmentGroupResource::collection($shipmentGroups)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve available shipment groups',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function startShipment(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'shipment_group_id' => 'required|integer|exists:shipment_groups,id'
            ]);

            $driver = Auth::user()->driver;
            if (!$driver) {
                throw new \Exception('Driver profile not found');
            }

            $shipmentGroupService = app(ShipmentGroupService::class);
            $shipmentGroup = $shipmentGroupService->updateShipmentGroupStatus($request->shipment_group_id, \App\Enums\Status::IN_TRANSIT->value, $driver->id);

            return response()->json([
                'success' => true,
                'message' => 'Shipment started successfully',
                'data' => new ShipmentGroupResource($shipmentGroup)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to start shipment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function endShipment(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'shipment_group_id' => 'required|integer|exists:shipment_groups,id'
            ]);

            $driver = Auth::user()->driver;
            if (!$driver) {
                throw new \Exception('Driver profile not found');
            }

            $shipmentGroupService = app(ShipmentGroupService::class);
            $shipmentGroup = $shipmentGroupService->updateShipmentGroupStatus($request->shipment_group_id, \App\Enums\Status::DELIVERED->value, $driver->id);

            return response()->json([
                'success' => true,
                'message' => 'Shipment delivered successfully',
                'data' => new ShipmentGroupResource($shipmentGroup)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to end shipment',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function markCheckpointAsChecked(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'shipment_group_id' => 'required|integer|exists:shipment_groups,id',
                'checkpoint_id' => 'required|integer|exists:checkpoints,id'
            ]);

            $driver = Auth::user()->driver;
            if (!$driver) {
                throw new \Exception('Driver profile not found');
            }

            $shipmentGroupService = app(ShipmentGroupService::class);
            $result = $shipmentGroupService->markCheckpointAsChecked(
                $request->shipment_group_id,
                $request->checkpoint_id,
                $driver->id
            );

            return response()->json([
                'success' => true,
                'message' => 'Checkpoint marked as checked successfully',
                'data' => [
                    'group_tracking' => [
                        'id' => $result['group_tracking']->id,
                        'group_id' => $result['group_tracking']->group_id,
                        'checkpoint_id' => $result['group_tracking']->checkpoint_id,
                        'arrival_time' => $result['group_tracking']->arrival_time,
                        'created_at' => $result['group_tracking']->created_at,
                        'updated_at' => $result['group_tracking']->updated_at,
                    ],
                    'checkpoints' => $result['checkpoints']
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark checkpoint as checked',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
