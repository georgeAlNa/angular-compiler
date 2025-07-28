<?php

namespace App\Services;

use App\Models\Complaint;

class ComplaintService extends BaseService
{
    public function __construct(Complaint $model)
    {
        parent::__construct($model);
    }
}
