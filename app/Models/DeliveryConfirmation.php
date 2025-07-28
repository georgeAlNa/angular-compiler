<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryConfirmation extends BaseModel
{
    protected $fillable = [
        'shipment_id',
        'confirmed_by_delivery_person_id',
    ];

    protected $searchable = [
        'shipment_id',
        'confirmed_by_delivery_person_id',
    ];

    protected $filterable = [
    ];

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }

    public function confirmedByDeliveryPerson(): BelongsTo
    {
        return $this->belongsTo(DeliveryPerson::class, 'confirmed_by_delivery_person_id');
    }
}
