<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Checkpoint extends BaseModel
{
    use Filterable, Searchable;

    protected $fillable = [
        'name',
        'governorate_id',
    ];

    protected $searchable = [
        'name',
        'governorate.name',
    ];

    protected $filterable = [
        'where' => [
            'governorate_id',
        ],
        'in' => [
            'governorate_id',
        ],
    ];

    public $relationships = [
        'governorate',
    ];

    /**
     * Get the governorate that owns the checkpoint
     */
    public function governorate(): BelongsTo
    {
        return $this->belongsTo(Governorate::class);
    }

    /**
     * Get the group checkpoints for the checkpoint
     */
    public function groupCheckpoints(): HasMany
    {
        return $this->hasMany(GroupCheckpoint::class);
    }
}
