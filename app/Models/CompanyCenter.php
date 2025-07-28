<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompanyCenter extends BaseModel
{
    use Filterable, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'location',
        'governorate_id',
    ];

    /**
     * The attributes that are searchable.
     *
     * @var array<string>
     */
    protected $searchable = [
        'name',
        'location',
    ];

    /**
     * The attributes that are filterable.
     *
     * @var array<string>
     */
    protected $filterable = [
        'where' => [
            'governorate_id',
            'name',
            'location',
            'created_at',
            'updated_at',
        ],
        'in' => [
            'governorate_id',
        ],
    ];

    /**
     * The relationships that should be loaded by default.
     *
     * @var array<string>
     */
    protected $relationships = [
        'governorate',
    ];

    /**
     * Get the governorate that owns the company center
     */
    public function governorate(): BelongsTo
    {
        return $this->belongsTo(Governorate::class);
    }


}
