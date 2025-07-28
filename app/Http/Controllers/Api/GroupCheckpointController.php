<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Services\GroupCheckpointService;
use App\Http\Resources\GroupCheckpointResource;
use App\Http\Requests\GroupCheckpointStoreRequest;
use App\Http\Requests\GroupCheckpointUpdateRequest;
use App\Http\Requests\GroupCheckpointBulkCreateRequest;
use Illuminate\Http\JsonResponse;

class GroupCheckpointController extends BaseController
{
    public function __construct(GroupCheckpointService $service)
    {
        parent::__construct($service);
        $this->resourceClass = GroupCheckpointResource::class;
        $this->createRequestClass = GroupCheckpointStoreRequest::class;
        $this->updateRequestClass = GroupCheckpointUpdateRequest::class;
    }

    /**
     * Create multiple group checkpoints in bulk
     */
    public function createBulk(GroupCheckpointBulkCreateRequest $request): JsonResponse
    {
        $createdCheckpoints = $this->service->createBulk($request->validated());
        
        return $this->successResponse(
            __('messages.bulk_created_successfully'),
            GroupCheckpointResource::collection($createdCheckpoints),
            [],
            201
        );
    }
}
