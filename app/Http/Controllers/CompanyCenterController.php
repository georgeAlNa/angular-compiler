<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyCenterRequest;
use App\Http\Requests\UpdateCompanyCenterRequest;
use App\Http\Resources\CompanyCenterResource;
use App\Services\CompanyCenterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompanyCenterController extends BaseController
{
    protected string $resourceClass = CompanyCenterResource::class;
    protected string $createRequestClass = StoreCompanyCenterRequest::class;
    protected string $updateRequestClass = UpdateCompanyCenterRequest::class;

    public function __construct(CompanyCenterService $companyCenterService)
    {
        parent::__construct($companyCenterService);
    }


}