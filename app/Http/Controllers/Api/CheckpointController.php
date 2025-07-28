<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Services\CheckpointService;
use App\Http\Resources\CheckpointResource;
use App\Http\Requests\CheckpointStoreRequest;
use App\Http\Requests\CheckpointUpdateRequest;

class CheckpointController extends BaseController
{
    public function __construct(CheckpointService $service)
    {
        parent::__construct($service);
        $this->resourceClass = CheckpointResource::class;
        $this->createRequestClass = CheckpointStoreRequest::class;
        $this->updateRequestClass = CheckpointUpdateRequest::class;
    }
}
