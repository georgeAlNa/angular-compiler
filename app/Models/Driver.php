<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Driver extends BaseModel
{
    use Filterable, Searchable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
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
    ];

    /**
     * The attributes that are filterable.
     *
     * @var array<string>
     */
    protected $filterable = [
        'where' => [
            'user_id',
            'vehicle_description',
            'driving_license_number',
            'created_at',
            'updated_at',
            'user.name',
            'user.email',
            'user.phone',
            'user.role',
            'user',
        ],
        'in' => [
            'user_id',
            'user.role',
        ],
    ];

    /**
     * The relationships that should be loaded by default.
     *
     * @var array<string>
     */
    public $relationships = [
        'user',
    ];

    /**
     * Get the user that owns the driver profile
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
