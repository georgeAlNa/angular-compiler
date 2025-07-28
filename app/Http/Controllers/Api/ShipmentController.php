<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ShipmentStoreRequest;
use App\Http\Requests\ShipmentUpdateRequest;
use App\Http\Requests\ShipmentBulkAssignGroupRequest;
use App\Http\Requests\AddShipmentRequest;
use App\Http\Resources\ShipmentResource;
use App\Services\ShipmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShipmentController extends BaseController
{
    public function __construct(ShipmentService $service)
    {
        parent::__construct($service);
        $this->resourceClass = ShipmentResource::class;
        $this->createRequestClass = ShipmentStoreRequest::class;
        $this->updateRequestClass = ShipmentUpdateRequest::class;
    }

    /**
     * Add a new shipment request
     */
    public function addShipmentRequest(AddShipmentRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $shipment = $this->service->create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Shipment request created successfully',
                'data' => new ShipmentResource($shipment)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create shipment request',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getPendingShipments(): JsonResponse
    {
        try {
            $shipmentService = app(ShipmentService::class);
            $shipments = $shipmentService->getPendingShipments();

            return response()->json([
                'success' => true,
                'message' => 'Pending shipments retrieved successfully',
                'data' => ShipmentResource::collection($shipments)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve pending shipments',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function priceShipment(\Illuminate\Http\Request $request): JsonResponse
    {
        try {
            $request->validate([
                'shipment_id' => 'required|integer|exists:shipments,id',
                'price' => 'required|numeric|min:0.01|max:10000'
            ]);

            $shipmentService = app(ShipmentService::class);
            $shipment = $shipmentService->priceShipment($request->shipment_id, $request->price);

            return response()->json([
                'success' => true,
                'message' => 'Shipment priced successfully',
                'data' => new ShipmentResource($shipment)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to price shipment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function approvePrice(\Illuminate\Http\Request $request): JsonResponse
    {
        try {
            $request->validate([
                'shipment_id' => 'required|integer|exists:shipments,id'
            ]);

            $shipmentService = app(ShipmentService::class);
            $shipment = $shipmentService->approvePrice($request->shipment_id);

            return response()->json([
                'success' => true,
                'message' => 'Shipment price approved successfully',
                'data' => new ShipmentResource($shipment)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve shipment price',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function rejectShipment(\Illuminate\Http\Request $request): JsonResponse
    {
        try {
            $request->validate([
                'shipment_id' => 'required|integer|exists:shipments,id'
            ]);

            $shipmentService = app(ShipmentService::class);
            $shipment = $shipmentService->rejectShipment($request->shipment_id);

            $user = Auth::user();
            $message = $user->role === \App\Enums\Role::ADMIN
                ? 'Shipment rejected by admin successfully'
                : 'Shipment rejected successfully';

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => new ShipmentResource($shipment)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject shipment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk assign shipments to a group
     */
    public function bulkAssignGroup(ShipmentBulkAssignGroupRequest $request): JsonResponse
    {
        $shipmentService = app(ShipmentService::class);
        $updatedShipments = $shipmentService->bulkAssignGroup($request->validated());

        return $this->successResponse(
            __('messages.bulk_updated_successfully'),
            ShipmentResource::collection($updatedShipments)
        );
    }

    public function assignShipment(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'shipment_id' => 'required|integer|exists:shipments,id',
                'delivery_person_id' => 'required|integer|exists:delivery_persons,id'
            ]);

            $shipmentService = app(ShipmentService::class);
            $shipment = $shipmentService->assignShipmentToDelivery(
                $request->shipment_id,
                $request->delivery_person_id
            );

            return response()->json([
                'success' => true,
                'message' => 'Delivery person assigned to shipment successfully',
                'data' => new ShipmentResource($shipment)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to assign delivery person to shipment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get shipments available for delivery
     */
    public function getAvailableShipmentsToDeliver(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'destination_center_id' => 'nullable|integer|exists:company_centers,id',
                'destination_governorate_id' => 'nullable|integer|exists:governorates,id'
            ]);

            $shipmentService = app(ShipmentService::class);
            $shipments = $shipmentService->getAvailableShipmentsToDeliver(
                $request->destination_center_id,
                $request->destination_governorate_id
            );

            return response()->json([
                'success' => true,
                'message' => 'Available shipments for delivery retrieved successfully',
                'data' => ShipmentResource::collection($shipments)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve available shipments for delivery',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get shipments sent by the authenticated customer
     */
    public function getMySentShipments(): JsonResponse
    {
        try {
            $shipmentService = app(ShipmentService::class);
            $shipments = $shipmentService->getMySentShipments();

            return response()->json([
                'success' => true,
                'message' => 'Sent shipments retrieved successfully',
                'data' => ShipmentResource::collection($shipments)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve sent shipments',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get shipments received by the authenticated customer
     */
    public function getMyReceivedShipments(): JsonResponse
    {
        try {
            $shipmentService = app(ShipmentService::class);
            $shipments = $shipmentService->getMyReceivedShipments();

            return response()->json([
                'success' => true,
                'message' => 'Received shipments retrieved successfully',
                'data' => ShipmentResource::collection($shipments)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve received shipments',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
