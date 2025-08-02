<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Governorate extends BaseModel
{
    use Filterable, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that are searchable.
     *
     * @var array<string>
     */
    protected $searchable = [
        'name',
    ];

    /**
     * The attributes that are filterable.
     *
     * @var array<string>
     */
    protected $filterable = [
        'where' => [
            'name',
            'created_at',
            'updated_at',
        ],
        'in' => [
            'id',
        ],
    ];

    /**
     * The relationships that should be loaded by default.
     *
     * @var array<string>
     */
    public $relationships = [
        'deliveryPersons',
    ];

    /**
     * Get the delivery persons assigned to this governorate
     */
    public function deliveryPersons(): HasMany
    {
        return $this->hasMany(DeliveryPerson::class, 'assigned_governorate_id');
    }
}
