<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\PaymentStoreRequest;
use App\Http\Requests\PaymentUpdateRequest;
use App\Http\Resources\PaymentResource;
use App\Services\PaymentService;

class PaymentController extends BaseController
{
    public function __construct(PaymentService $service)
    {
        parent::__construct($service);
        $this->resourceClass = PaymentResource::class;
        $this->createRequestClass = PaymentStoreRequest::class;
        $this->updateRequestClass = PaymentUpdateRequest::class;
    }
}
