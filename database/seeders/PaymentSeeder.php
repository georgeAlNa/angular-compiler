<?php

namespace Database\Seeders;

use App\Enums\PaymentMethod;
use App\Enums\Status;
use App\Models\Payment;
use App\Models\Shipment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get shipments that are paid or beyond
        $paidShipments = Shipment::whereIn('status', [
            Status::PAID->value,
            Status::IN_TRANSIT->value,
            Status::DELIVERED_TO_DESTINATION_CENTER->value,
            Status::DELIVERED->value
        ])->get();

        foreach ($paidShipments as $shipment) {
            // Create payment record
            $paymentDate = $shipment->price_set_at ?
                $shipment->price_set_at->addHours(rand(1, 48)) :
                now()->subDays(rand(1, 30));

            Payment::create([
                'shipment_id' => $shipment->id,
                'amount' => $shipment->price,
                'payment_method' => $this->getRandomPaymentMethod(),
                'payment_date' => $paymentDate,
            ]);
        }
    }

    private function getRandomPaymentMethod()
    {
        $methods = [PaymentMethod::SYRIATEL_CASH->value, PaymentMethod::MTN_CASH->value];
        return $methods[array_rand($methods)];
    }
}
