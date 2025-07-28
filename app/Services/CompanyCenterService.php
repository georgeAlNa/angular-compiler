<?php

namespace App\Services;

use App\Models\CompanyCenter;

class CompanyCenterService extends BaseService
{
    public function __construct(CompanyCenter $model)
    {
        parent::__construct($model);
    }
}
