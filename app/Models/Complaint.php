<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Complaint extends BaseModel
{
    protected $fillable = [
        'shipment_id',
        'customer_id',
        'description',
    ];

    protected $searchable = [
        'description',
    ];

    protected $filterable = [
    ];

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
