<?php

namespace App\Services;

use App\Models\DeliveryConfirmation;
use App\Models\Shipment;
use App\Enums\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeliveryConfirmationService extends BaseService
{
    public function __construct(DeliveryConfirmation $model)
    {
        parent::__construct($model);
    }

    public function confirmDelivery(string $qrCodeString): array
    {
        return DB::transaction(function () use ($qrCodeString) {
            try {
                $qrData = json_decode($qrCodeString, true);

                if (!$qrData || !isset($qrData['shipment_id'])) {
                    throw new \Exception('Invalid QR code format');
                }

                $shipmentId = $qrData['shipment_id'];
                $expectedReceiverId = $qrData['receiver_id'] ?? null;

                $deliveryPerson = Auth::user()->deliveryPerson;
                if (!$deliveryPerson) {
                    throw new \Exception('Delivery person profile not found');
                }

                $shipment = Shipment::with([
                    'sender',
                    'receiver',
                    'originGovernorate',
                    'destinationGovernorate',
                    'originCenter',
                    'destinationCenter',
                    'shipmentGroup',
                    'deliveryConfirmation'
                ])->find($shipmentId);

                if (!$shipment) {
                    throw new \Exception('Shipment not found');
                }

                // Verify the shipment belongs to the expected receiver (if provided)
                if ($expectedReceiverId && $shipment->receiver_id != $expectedReceiverId) {
                    throw new \Exception('QR code does not match the expected receiver');
                }

                // Check if delivery is already confirmed
                if ($shipment->deliveryConfirmation) {
                    throw new \Exception('Delivery already confirmed for this shipment');
                }

                // Verify shipment status allows delivery confirmation
                if ($shipment->status !== Status::IN_TRANSIT->value && $shipment->status !== Status::PAID->value) {
                    throw new \Exception('Shipment is not ready for delivery confirmation. Current status: ' . $shipment->status);
                }

                // Create delivery confirmation
                $deliveryConfirmation = $this->create([
                    'shipment_id' => $shipmentId,
                    'confirmed_by_delivery_person_id' => $deliveryPerson->id
                ]);

                // Update shipment status to delivered
                $shipment->update([
                    'status' => Status::DELIVERED->value
                ]);

                return [
                    'success' => true,
                    'message' => 'Delivery confirmed successfully'
                ];

            } catch (\Exception $e) {
                return [
                    'success' => false,
                    'message' => 'Delivery confirmation failed',
                    'error' => $e->getMessage()
                ];
            }
        });
    }
}
