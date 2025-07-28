<?php

namespace App\Services;

use App\Models\GroupCheckpoint;
use Illuminate\Support\Facades\DB;

class GroupCheckpointService extends BaseService
{
    public function __construct(GroupCheckpoint $model)
    {
        parent::__construct($model);
    }

    /**
     * Create multiple group checkpoints in bulk
     */
    public function createBulk(array $data): array
    {
        $groupId = $data['group_id'];
        $checkpoints = $data['checkpoints'];
        $createdCheckpoints = [];

        DB::transaction(function () use ($groupId, $checkpoints, &$createdCheckpoints) {
            foreach ($checkpoints as $checkpoint) {
                $createdCheckpoint = $this->model->create([
                    'group_id' => $groupId,
                    'checkpoint_id' => $checkpoint['checkpoint_id'],
                    'order' => $checkpoint['order'],
                ]);
                $createdCheckpoints[] = $createdCheckpoint;
            }
        });

        return $createdCheckpoints;
    }
}
