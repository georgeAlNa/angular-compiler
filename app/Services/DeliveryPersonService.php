<?php

namespace App\Services;

use App\Models\DeliveryPerson;

class DeliveryPersonService extends BaseService
{
    public function __construct(DeliveryPerson $model)
    {
        parent::__construct($model);
    }
}
