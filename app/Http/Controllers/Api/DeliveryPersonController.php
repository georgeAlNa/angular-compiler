<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Services\DeliveryPersonService;
use App\Services\ShipmentService;
use App\Http\Resources\DeliveryPersonResource;
use App\Http\Resources\ShipmentResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryPersonController extends BaseController
{
    public function __construct(DeliveryPersonService $service)
    {
        parent::__construct($service);
        $this->resourceClass = DeliveryPersonResource::class;
    }

    /**
     * Get shipments assigned to the current delivery person
     */
    public function getMyAssignedShipments(): JsonResponse
    {
        try {
            $deliveryPerson = Auth::user()->deliveryPerson;
            if (!$deliveryPerson) {
                throw new \Exception('Delivery person profile not found');
            }

            $shipmentService = app(ShipmentService::class);
            $shipments = $shipmentService->getDeliveryPersonAssignedShipments($deliveryPerson->id);

            return response()->json([
                'success' => true,
                'message' => 'Assigned shipments retrieved successfully',
                'data' => ShipmentResource::collection($shipments)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve assigned shipments',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
