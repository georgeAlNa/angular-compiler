<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShipmentGroup extends BaseModel
{
    use Filterable, Searchable;

    protected $fillable = [
        'driver_id',
        'created_by_admin_id',
        'last_updated_by_admin_id',
        'from_governorate_id',
        'to_governorate_id',
        'from_center_id',
        'to_center_id',
        'route_description',
        'status',
    ];

    protected $searchable = [
        'route_description',
        'driver.user.name',
        'fromGovernorate.name',
        'toGovernorate.name',
        'fromCenter.name',
        'toCenter.name',
    ];

    protected $filterable = [
        'where' => [
            'driver_id',
            'created_by_admin_id',
            'last_updated_by_admin_id',
            'from_governorate_id',
            'to_governorate_id',
            'from_center_id',
            'to_center_id',
            'created_at',
            'updated_at',
        ],
        'in' => [
            'driver_id',
            'from_governorate_id',
            'to_governorate_id',
            'from_center_id',
            'to_center_id',
            'status',
        ],
    ];

    protected $relationships = [
        'driver',
        'createdByAdmin',
        'lastUpdatedByAdmin',
        'fromGovernorate',
        'toGovernorate',
        'fromCenter',
        'toCenter',
    ];

    /**
     * Get the driver that owns the shipment group
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * Get the admin who created the shipment group
     */
    public function createdByAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_admin_id');
    }

    /**
     * Get the admin who last updated the shipment group
     */
    public function lastUpdatedByAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_updated_by_admin_id');
    }

    /**
     * Get the from governorate
     */
    public function fromGovernorate(): BelongsTo
    {
        return $this->belongsTo(Governorate::class, 'from_governorate_id');
    }

    /**
     * Get the to governorate
     */
    public function toGovernorate(): BelongsTo
    {
        return $this->belongsTo(Governorate::class, 'to_governorate_id');
    }

    /**
     * Get the from center
     */
    public function fromCenter(): BelongsTo
    {
        return $this->belongsTo(CompanyCenter::class, 'from_center_id');
    }

    /**
     * Get the to center
     */
    public function toCenter(): BelongsTo
    {
        return $this->belongsTo(CompanyCenter::class, 'to_center_id');
    }

    /**
     * Get the group checkpoints for the shipment group
     */
    public function groupCheckpoints(): HasMany
    {
        return $this->hasMany(GroupCheckpoint::class, 'group_id');
    }

    /**
     * Get the shipments for the shipment group
     */
    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class, 'group_id');
    }
}
