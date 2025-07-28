<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\GovernorateStoreRequest;
use App\Http\Requests\GovernorateUpdateRequest;
use App\Http\Resources\GovernorateResource;
use App\Services\GovernorateService;

class GovernorateController extends BaseController
{
    public function __construct(GovernorateService $service)
    {
        parent::__construct($service);
        $this->resourceClass = GovernorateResource::class;
        $this->createRequestClass = GovernorateStoreRequest::class;
        $this->updateRequestClass = GovernorateUpdateRequest::class;
    }
}