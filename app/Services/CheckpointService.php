<?php

namespace App\Services;

use App\Models\Checkpoint;

class CheckpointService extends BaseService
{
    public function __construct(Checkpoint $model)
    {
        parent::__construct($model);

    }
}
