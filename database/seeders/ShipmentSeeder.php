<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Enums\Status;
use App\Models\CompanyCenter;
use App\Models\Governorate;
use App\Models\Shipment;
use App\Models\ShipmentGroup;
use App\Models\User;
use Illuminate\Database\Seeder;

class ShipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = User::where('role', Role::CUSTOMER->value)->get();
        $admins = User::where('role', Role::ADMIN->value)->get();
        $governorates = Governorate::all();
        $companyCenters = CompanyCenter::all();
        $shipmentGroups = ShipmentGroup::all();
        $deliveryPersons = \App\Models\DeliveryPerson::all();

        $cargoTypes = [
            'Electronics', 'Clothing', 'Documents', 'Food', 'Furniture',
            'Machinery', 'Textiles', 'Automotive Parts', 'Medical Supplies',
            'Construction Materials', 'Agricultural Products', 'Books'
        ];

        $specialInstructions = [
            'Handle with care - fragile items',
            'Keep dry - sensitive to moisture',
            'Temperature controlled - refrigerated',
            'Heavy items - use proper equipment',
            'Urgent delivery required',
            'Signature required upon delivery',
            'Do not stack heavy items on top',
            'Keep upright position',
            null, null, null, null, null, null, null // 50% chance of no special instructions
        ];

        // Create 200 shipments with realistic status distribution
        for ($i = 1; $i <= 200; $i++) {
            $sender = $customers->random();
            $receiver = $customers->where('id', '!=', $sender->id)->random();

            $originGovernorate = $governorates->random();
            $destinationGovernorate = $governorates->where('id', '!=', $originGovernorate->id)->random();

            $originCenter = $companyCenters->where('governorate_id', $originGovernorate->id)->first();
            $destinationCenter = $companyCenters->where('governorate_id', $destinationGovernorate->id)->first();

            // Determine status based on business logic
            $status = $this->determineShipmentStatus($i, $shipmentGroups);

            // Only assign to group if status is 'paid' or beyond
            $groupId = null;
            $assignedDeliveryPersonId = null;

            if (in_array($status, [Status::PAID->value, Status::IN_TRANSIT->value, Status::DELIVERED_TO_DESTINATION_CENTER->value, Status::DELIVERED->value])) {
                // Find a suitable group for this route
                $suitableGroup = $shipmentGroups->where('from_governorate_id', $originGovernorate->id)
                    ->where('to_governorate_id', $destinationGovernorate->id)
                    ->first();

                if ($suitableGroup) {
                    $groupId = $suitableGroup->id;

                    // Assign delivery person if shipment is delivered to destination center or delivered
                    if (in_array($status, [Status::DELIVERED_TO_DESTINATION_CENTER->value, Status::DELIVERED->value])) {
                        $assignedDeliveryPerson = $deliveryPersons->where('assigned_governorate_id', $destinationGovernorate->id)->first();
                        if ($assignedDeliveryPerson) {
                            $assignedDeliveryPersonId = $assignedDeliveryPerson->id;
                        }
                    }
                }
            }

            // Set price and admin if status is 'priced by admin' or beyond
            $price = null;
            $priceSetByAdminId = null;
            $priceSetAt = null;

            if (in_array($status, [Status::PRICED_BY_ADMIN->value, Status::PENDING_CUSTOMER_APPROVAL->value, Status::PAID->value, Status::IN_TRANSIT->value, Status::DELIVERED_TO_DESTINATION_CENTER->value, Status::DELIVERED->value])) {
                $price = rand(5000, 50000) / 100; // 50.00 to 500.00
                $priceSetByAdminId = $admins->random()->id;
                $priceSetAt = now()->subDays(rand(1, 30));
            }

            Shipment::create([
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'group_id' => $groupId,
                'type_of_cargo' => $cargoTypes[array_rand($cargoTypes)],
                'weight' => rand(1, 1000) / 10, // 0.1 to 100.0 kg
                'origin_address' => "Street " . rand(1, 100) . ", " . $originGovernorate->name,
                'destination_address' => "Street " . rand(1, 100) . ", " . $destinationGovernorate->name,
                'special_handling_instructions' => $specialInstructions[array_rand($specialInstructions)],
                'origin_governorate_id' => $originGovernorate->id,
                'destination_governorate_id' => $destinationGovernorate->id,
                'origin_center_id' => $originCenter ? $originCenter->id : null,
                'destination_center_id' => $destinationCenter ? $destinationCenter->id : null,
                'assigned_delivery_person_id' => $assignedDeliveryPersonId,
                'status' => $status,
                'qr_code' => 'QR-' . str_pad($i, 8, '0', STR_PAD_LEFT),
                'code' => 'SH-' . str_pad($i, 8, '0', STR_PAD_LEFT),
                'price' => $price,
                'price_set_by_admin_id' => $priceSetByAdminId,
                'price_set_at' => $priceSetAt,
            ]);
        }
    }

    private function determineShipmentStatus($index, $shipmentGroups)
    {
        // Distribute statuses realistically
        $statusDistribution = [
            Status::DRAFT->value => 10, // 10%
            Status::PENDING_ADMIN_APPROVAL->value => 15, // 15%
            Status::PRICED_BY_ADMIN->value => 10, // 10%
            Status::PENDING_CUSTOMER_APPROVAL->value => 10, // 10%
            Status::PAID->value => 20, // 20%
            Status::IN_TRANSIT->value => 15, // 15%
            Status::DELIVERED_TO_DESTINATION_CENTER->value => 10, // 10%
            Status::DELIVERED->value => 10, // 10%
        ];

        $total = array_sum($statusDistribution);
        $random = $index % $total;

        $cumulative = 0;
        foreach ($statusDistribution as $status => $count) {
            $cumulative += $count;
            if ($random < $cumulative) {
                return $status;
            }
        }

        return Status::DRAFT->value; // fallback
    }
}
