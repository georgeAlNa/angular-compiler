<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends BaseModel
{
    protected $fillable = [
        'shipment_id',
        'amount',
        'payment_method',
        'payment_date',
    ];

    protected $casts = [
        'amount' => 'float',
        'payment_date' => 'datetime',
    ];

    protected $searchable = [
        'payment_method',
        'amount',
    ];

    protected $filterable = [
    ];

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }
}
