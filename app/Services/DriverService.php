<?php

namespace App\Services;

use App\Models\Driver;
use App\Models\ShipmentGroup;
use App\Enums\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class DriverService extends BaseService
{
    public function __construct(Driver $model)
    {
        parent::__construct($model);
    }

    public function getAvailableShipmentsGroup(): Collection
    {
        $driver = Auth::user()->driver;

        if (!$driver) {
            throw new \Exception('Driver profile not found');
        }

        return ShipmentGroup::with([
            'driver',
            'createdByAdmin',
            'lastUpdatedByAdmin',
            'fromGovernorate',
            'toGovernorate',
            'fromCenter',
            'toCenter',
            'groupCheckpoints'
        ])
        ->where('driver_id', $driver->id)
        ->where('status', '!=', Status::DELIVERED->value)
        ->orderBy('created_at', 'desc')
        ->get();
    }



}
