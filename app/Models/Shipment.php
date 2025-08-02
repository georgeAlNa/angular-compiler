<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Shipment extends BaseModel
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'group_id',
        'type_of_cargo',
        'weight',
        'origin_address',
        'destination_address',
        'special_handling_instructions',
        'origin_governorate_id',
        'destination_governorate_id',
        'origin_center_id',
        'destination_center_id',
        'assigned_delivery_person_id',
        'status',
        'qr_code',
        'code',
        'price',
        'price_set_by_admin_id',
        'price_set_at',
    ];

    protected $casts = [
        'weight' => 'float',
        'price' => 'float',
        'price_set_at' => 'datetime',
    ];

    protected $searchable = [
        'type_of_cargo',
        'origin_address',
        'destination_address',
        'status',
        'qr_code',
        'code',
    ];

    protected $filterable = [
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function shipmentGroup(): BelongsTo
    {
        return $this->belongsTo(ShipmentGroup::class, 'group_id');
    }

    public function originGovernorate(): BelongsTo
    {
        return $this->belongsTo(Governorate::class, 'origin_governorate_id');
    }

    public function destinationGovernorate(): BelongsTo
    {
        return $this->belongsTo(Governorate::class, 'destination_governorate_id');
    }

    public function originCenter(): BelongsTo
    {
        return $this->belongsTo(CompanyCenter::class, 'origin_center_id');
    }

    public function destinationCenter(): BelongsTo
    {
        return $this->belongsTo(CompanyCenter::class, 'destination_center_id');
    }

    public function priceSetByAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'price_set_by_admin_id');
    }

    public function deliveryConfirmation(): HasOne
    {
        return $this->hasOne(DeliveryConfirmation::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class);
    }

    public function assignedDeliveryPerson(): BelongsTo
    {
        return $this->belongsTo(DeliveryPerson::class, 'assigned_delivery_person_id');
    }
}
