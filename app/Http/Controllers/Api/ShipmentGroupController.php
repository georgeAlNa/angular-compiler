<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Services\ShipmentGroupService;
use App\Http\Resources\ShipmentGroupResource;
use App\Http\Requests\ShipmentGroupStoreRequest;
use App\Http\Requests\ShipmentGroupUpdateRequest;
use App\Http\Requests\ShipmentGroupWithShipmentsAndCheckpointsRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShipmentGroupController extends BaseController
{
    public function __construct(ShipmentGroupService $service)
    {
        parent::__construct($service);
        $this->resourceClass = ShipmentGroupResource::class;
        $this->createRequestClass = ShipmentGroupStoreRequest::class;
        $this->updateRequestClass = ShipmentGroupUpdateRequest::class;
    }

    public function createWithShipmentsAndCheckpoints(ShipmentGroupWithShipmentsAndCheckpointsRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $shipmentGroupService = app(ShipmentGroupService::class);
            $shipmentGroup = $shipmentGroupService->createWithShipmentsAndCheckpoints($validated);

            return response()->json([
                'success' => true,
                'message' => 'Shipment group created successfully with shipments and checkpoints',
                'data' => new ShipmentGroupResource($shipmentGroup)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create shipment group',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getShipmentGroupCheckpoints(Request $request, $shipment_group): JsonResponse
    {
        try {
            $shipmentGroupService = app(ShipmentGroupService::class);
            $checkpoints = $shipmentGroupService->getShipmentGroupCheckpoints($shipment_group);

            return response()->json([
                'success' => true,
                'message' => 'Shipment group checkpoints retrieved successfully',
                'data' => $checkpoints
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve shipment group checkpoints',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
