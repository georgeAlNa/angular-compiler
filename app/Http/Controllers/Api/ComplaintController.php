<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ComplaintStoreRequest;
use App\Http\Requests\ComplaintUpdateRequest;
use App\Http\Resources\ComplaintResource;
use App\Services\ComplaintService;

class ComplaintController extends BaseController
{
    public function __construct(ComplaintService $service)
    {
        parent::__construct($service);
        $this->resourceClass = ComplaintResource::class;
        $this->createRequestClass = ComplaintStoreRequest::class;
        $this->updateRequestClass = ComplaintUpdateRequest::class;
    }
}