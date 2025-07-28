<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Complaint;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Database\Seeder;

class ComplaintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = User::where('role', Role::CUSTOMER->value)->get();
        $shipments = Shipment::all();

        $complaintDescriptions = [
            'Package arrived damaged - items inside are broken',
            'Delivery was delayed by 3 days without notification',
            'Wrong address was used for delivery',
            'Package was left outside without signature confirmation',
            'Items are missing from the shipment',
            'Delivery person was not professional',
            'Package was delivered to wrong person',
            'Tracking information was not updated properly',
            'Package was not handled with care as requested',
            'Delivery time was not as promised',
            'Package was opened and resealed',
            'No delivery attempt was made despite being home',
            'Package was delivered to neighbor without permission',
            'Shipping cost was higher than quoted',
            'Package was lost during transit'
        ];

        // Create complaints for some shipments (about 5% of shipments)
        $shipmentsForComplaints = $shipments->random(ceil($shipments->count() * 0.05));

        foreach ($shipmentsForComplaints as $shipment) {
            $customer = $customers->where('id', $shipment->sender_id)->first() ??
                       $customers->where('id', $shipment->receiver_id)->first() ??
                       $customers->random();

            Complaint::create([
                'shipment_id' => $shipment->id,
                'customer_id' => $customer->id,
                'description' => $complaintDescriptions[array_rand($complaintDescriptions)],
            ]);
        }
    }
}
