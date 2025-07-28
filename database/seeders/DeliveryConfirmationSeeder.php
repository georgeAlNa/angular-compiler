<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\DeliveryConfirmation;
use App\Models\Shipment;
use Illuminate\Database\Seeder;

class DeliveryConfirmationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get shipments that are delivered
        $deliveredShipments = Shipment::where('status', Status::DELIVERED->value)
            ->whereNotNull('assigned_delivery_person_id')
            ->get();

        foreach ($deliveredShipments as $shipment) {
            // Create delivery confirmation
            $confirmationDate = now()->subDays(rand(1, 7))->subHours(rand(1, 24));

            DeliveryConfirmation::create([
                'shipment_id' => $shipment->id,
                'confirmed_by_delivery_person_id' => $shipment->assigned_delivery_person_id,
                'created_at' => $confirmationDate,
                'updated_at' => $confirmationDate,
            ]);
        }
    }
}
