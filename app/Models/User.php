<?php

namespace App\Models;

use App\Enums\Role;
use App\Traits\HasEnums;
use App\Traits\Filterable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasEnums, Filterable, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'age',
        'role',
    ];

    /**
     * The attributes that are searchable.
     *
     * @var array<string>
     */
    protected $searchable = [
        'name',
        'email',
        'phone',
    ];

    /**
     * The attributes that are filterable.
     *
     * @var array<string>
     */
    protected $filterable = [
        'where' => [
            'name',
            'email',
            'phone',
            'age',
            'role',
            'created_at',
            'updated_at',
        ],
        'in' => [
            'role',
        ],
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => Role::class,
        ];
    }

    /**
     * Get the driver profile for this user
     */
    public function driver(): HasOne
    {
        return $this->hasOne(Driver::class);
    }

    /**
     * Get the delivery person profile for this user
     */
    public function deliveryPerson(): HasOne
    {
        return $this->hasOne(DeliveryPerson::class);
    }
}
