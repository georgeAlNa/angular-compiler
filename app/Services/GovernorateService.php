<?php

namespace App\Services;

use App\Models\Governorate;

class GovernorateService extends BaseService
{
    public function __construct(Governorate $model)
    {
        parent::__construct($model);
    }
}
