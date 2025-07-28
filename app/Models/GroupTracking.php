<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupTracking extends BaseModel
{
    use Filterable, Searchable;

    protected $fillable = [
        'group_id',
        'checkpoint_id',
    ];

    /**
     * The attributes that are searchable.
     * Include fields that users should be able to search by (text fields, names, descriptions, etc.)
     */
    protected $searchable = [
        'shipmentGroup.name',
        'checkpoint.name',
    ];

    /**
     * The attributes that are filterable.
     * Include fields that users should be able to filter by
     */
    protected $filterable = [
        'where' => [
            'group_id',
            'checkpoint_id',
            'created_at',
            'updated_at',
        ],
        'in' => [
            'group_id',
            'checkpoint_id',
        ],
    ];

    /**
     * The relationships that should be loaded by default.
     * Include relationships that are commonly needed when fetching this model
     */
    protected $relationships = [
        'shipmentGroup',
        'checkpoint',
    ];

    /**
     * Get the shipment group that owns the tracking record.
     */
    public function shipmentGroup(): BelongsTo
    {
        return $this->belongsTo(ShipmentGroup::class, 'group_id');
    }

    /**
     * Get the checkpoint that owns the tracking record.
     */
    public function checkpoint(): BelongsTo
    {
        return $this->belongsTo(Checkpoint::class);
    }
}
