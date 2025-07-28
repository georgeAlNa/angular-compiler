<?php

namespace App\Services;

use App\Models\GroupTracking;

class GroupTrackingService extends BaseService
{
    public function __construct(GroupTracking $model)
    {
        parent::__construct($model);
    }
}
