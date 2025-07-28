<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeliveryPerson extends BaseModel
{
    use Filterable, Searchable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'delivery_persons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'assigned_governorate_id',
        'vehicle_description',
        'driving_license_number',
    ];

    /**
     * The attributes that are searchable.
     *
     * @var array<string>
     */
    protected $searchable = [
        'vehicle_description',
        'driving_license_number',
        'user.name',
        'user.email',
        'user.phone',
        'assignedGovernorate.name',
    ];

    /**
     * The attributes that are filterable.
     *
     * @var array<string>
     */
    protected $filterable = [
        'where' => [
            'user_id',
            'assigned_governorate_id',
            'vehicle_description',
            'driving_license_number',
            'created_at',
            'updated_at',
            'user.name',
            'user.email',
            'user.phone',
            'user.role',
            'assignedGovernorate.name',
            'user',
            'assignedGovernorate',
        ],
        'in' => [
            'user_id',
            'assigned_governorate_id',
            'user.role',
            'assignedGovernorate',
        ],
    ];

    /**
     * The relationships that should be loaded by default.
     *
     * @var array<string>
     */
    public $relationships = [
        'user',
        'assignedGovernorate',
    ];

    /**
     * Get the user that owns the delivery person profile
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the governorate assigned to this delivery person
     */
    public function assignedGovernorate(): BelongsTo
    {
        return $this->belongsTo(Governorate::class, 'assigned_governorate_id');
    }

    /**
     * Get the delivery person's full name from user
     */
    public function getNameAttribute(): string
    {
        return $this->user->name;
    }

    /**
     * Get the delivery person's email from user
     */
    public function getEmailAttribute(): string
    {
        return $this->user->email;
    }

    /**
     * Get the delivery person's phone from user
     */
    public function getPhoneAttribute(): string
    {
        return $this->user->phone;
    }

    /**
     * Get the assigned governorate name
     */
    public function getGovernorateNameAttribute(): string
    {
        return $this->assignedGovernorate->name;
    }

    /**
     * Get the shipments assigned to this delivery person
     */
    public function assignedShipments(): HasMany
    {
        return $this->hasMany(Shipment::class, 'assigned_delivery_person_id');
    }
}
