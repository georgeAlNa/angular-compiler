<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupCheckpoint extends BaseModel
{
    use Filterable, Searchable;

    protected $fillable = [
        'group_id',
        'checkpoint_id',
        'order',
    ];

    protected $searchable = [
        'checkpoint.name',
        'group.route_description',
    ];

    protected $filterable = [
        'where' => [
            'group_id',
            'checkpoint_id',
            'order',
            'created_at',
            'updated_at',
        ],
        'in' => [
            'group_id',
            'checkpoint_id',
        ],
    ];

    public $relationships = [
        'group',
        'checkpoint',
    ];

    /**
     * Get the shipment group that owns the group checkpoint
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(ShipmentGroup::class, 'group_id');
    }

    /**
     * Get the checkpoint that owns the group checkpoint
     */
    public function checkpoint(): BelongsTo
    {
        return $this->belongsTo(Checkpoint::class);
    }

    /**
     * Get the group tracking record for this checkpoint
     */
    public function groupTracking(): BelongsTo
    {
        return $this->belongsTo(GroupTracking::class, 'checkpoint_id', 'checkpoint_id')
            ->where('group_id', $this->group_id);
    }
}
