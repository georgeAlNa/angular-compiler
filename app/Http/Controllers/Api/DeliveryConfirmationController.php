<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\DeliveryConfirmationStoreRequest;
use App\Http\Requests\DeliveryConfirmationUpdateRequest;
use App\Http\Resources\DeliveryConfirmationResource;
use App\Services\DeliveryConfirmationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeliveryConfirmationController extends BaseController
{
    public function __construct(DeliveryConfirmationService $service)
    {
        parent::__construct($service);
        $this->resourceClass = DeliveryConfirmationResource::class;
        $this->createRequestClass = DeliveryConfirmationStoreRequest::class;
        $this->updateRequestClass = DeliveryConfirmationUpdateRequest::class;
    }

    public function confirmDelivery(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'qr_code_string' => 'required|string'
            ]);

            $deliveryConfirmationService = app(DeliveryConfirmationService::class);
            $result = $deliveryConfirmationService->confirmDelivery($request->qr_code_string);

            if (!$result['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'],
                    'error' => $result['error']
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => $result['message']
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to confirm delivery',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
