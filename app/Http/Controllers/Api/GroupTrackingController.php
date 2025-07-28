<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Services\GroupTrackingService;
use App\Http\Resources\GroupTrackingResource;
use App\Http\Requests\GroupTrackingStoreRequest;
use App\Http\Requests\GroupTrackingUpdateRequest;

class GroupTrackingController extends BaseController
{
    public function __construct(GroupTrackingService $service)
    {
        parent::__construct($service);
        $this->resourceClass = GroupTrackingResource::class;
        $this->createRequestClass = GroupTrackingStoreRequest::class;
        $this->updateRequestClass = GroupTrackingUpdateRequest::class;
    }
}
