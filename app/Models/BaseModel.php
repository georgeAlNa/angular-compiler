<?php

namespace App\Models;

use App\Traits\HasEnums;
use App\Enums\Role;
use App\Enums\Status;
use App\Enums\PaymentMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

abstract class BaseModel extends Model
{
    use HasFactory, HasEnums;

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get enum casts for common enum fields
     */
    protected function getEnumCasts(): array
    {
        return [
            'role' => Role::class,
            'status' => Status::class,
            'payment_method' => PaymentMethod::class,
        ];
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Add any global model events here
        static::creating(function ($model) {
            // Set default status if not set and model has status field
            if (array_key_exists('status', $model->attributes) && !$model->status) {
                $model->status = Status::DRAFT;
            }
        });
    }
}
