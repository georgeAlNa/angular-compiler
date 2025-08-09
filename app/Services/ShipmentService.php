<?php

namespace App\Services;

use App\Enums\Status;
use App\Models\Shipment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ShipmentService extends BaseService
{
    public function __construct(Shipment $model)
    {
        parent::__construct($model);
    }

    public function create(array $data): Shipment
    {
        $code = 'SH-' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);

        // Ensure code uniqueness
        while (Shipment::where('code', $code)->exists()) {
            $code = 'SH-' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);
        }

        $data['code'] = $code;
        $data['sender_id'] = Auth::id();
        $data['status'] = Status::PENDING_ADMIN_APPROVAL->value;

        // Create the shipment first to get the ID
        $shipment = parent::create($data);

        // Generate QR code string containing sender_id, receiver_id, shipment code, and shipment_id
        $qrData = [
            'sender_id' => $data['sender_id'],
            'receiver_id' => $data['receiver_id'],
            'shipment_code' => $code,
            'shipment_id' => $shipment->id,
            'random_string' => Str::random(10),
        ];

        // Update the shipment with the QR code
        $shipment->update(['qr_code' => json_encode($qrData)]);

        return $shipment->fresh();
    }

    public function bulkAssignGroup(array $data): array
    {
        $groupId = $data['group_id'];
        $shipmentIds = $data['shipment_ids'];
        $updatedShipments = [];

        DB::transaction(function () use ($groupId, $shipmentIds, &$updatedShipments) {
            $updatedShipments = $this->model->whereIn('id', $shipmentIds)
                ->get()
                ->map(function ($shipment) use ($groupId) {
                    $shipment->update(['group_id' => $groupId]);
                    return $shipment->fresh();
                })
                ->toArray();
        });

        return $updatedShipments;
    }

    public function getPendingShipments(): \Illuminate\Support\Collection
    {
        $user = Auth::user();
        $role = $user->role;

        $query = $this->model->with([
            'sender',
            'receiver',
            'originGovernorate',
            'destinationGovernorate',
            'originCenter',
            'destinationCenter',
            'shipmentGroup'
        ]);

        if ($role === \App\Enums\Role::ADMIN) {
            $query->where('status', Status::PENDING_ADMIN_APPROVAL->value);
        } elseif ($role === \App\Enums\Role::CUSTOMER) {
            $query->where('sender_id', $user->id)
                  ->where('status', Status::PENDING_CUSTOMER_APPROVAL->value);
        } else {
            return collect([]);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function priceShipment(int $shipmentId, float $price): Shipment
    {
        $user = Auth::user();

        $shipment = $this->model->with([
            'sender',
            'receiver',
            'originGovernorate',
            'destinationGovernorate',
            'originCenter',
            'destinationCenter',
            'shipmentGroup'
        ])->find($shipmentId);

        if (!$shipment) {
            throw new \Exception('Shipment not found');
        }

        if ($shipment->status !== Status::PENDING_ADMIN_APPROVAL->value) {
            throw new \Exception('Can only price shipments that are pending admin approval. Current status: ' . $shipment->status);
        }

        $shipment->update([
            'price' => $price,
            'price_set_by_admin_id' => $user->id,
            'price_set_at' => now(),
            'status' => Status::PENDING_CUSTOMER_APPROVAL->value
        ]);

        return $shipment->fresh([
            'sender',
            'receiver',
            'originGovernorate',
            'destinationGovernorate',
            'originCenter',
            'destinationCenter',
            'shipmentGroup'
        ]);
    }

    public function approvePrice(int $shipmentId): Shipment
    {
        $user = Auth::user();

        $shipment = $this->model->with([
            'sender',
            'receiver',
            'originGovernorate',
            'destinationGovernorate',
            'originCenter',
            'destinationCenter',
            'shipmentGroup'
        ])->find($shipmentId);

        if (!$shipment) {
            throw new \Exception('Shipment not found');
        }

        if ($shipment->sender_id !== $user->id) {
            throw new \Exception('You can only approve shipments that belong to you');
        }

        if ($shipment->status !== Status::PENDING_CUSTOMER_APPROVAL->value) {
            throw new \Exception('Can only approve shipments that are pending customer approval. Current status: ' . $shipment->status);
        }

        $shipment->update([
            'status' => Status::PAID->value
        ]);

        return $shipment->fresh([
            'sender',
            'receiver',
            'originGovernorate',
            'destinationGovernorate',
            'originCenter',
            'destinationCenter',
            'shipmentGroup'
        ]);
    }

    public function rejectShipment(int $shipmentId): Shipment
    {
        $user = Auth::user();
        $role = $user->role;

        $shipment = $this->model->with([
            'sender',
            'receiver',
            'originGovernorate',
            'destinationGovernorate',
            'originCenter',
            'destinationCenter',
            'shipmentGroup'
        ])->find($shipmentId);

        if (!$shipment) {
            throw new \Exception('Shipment not found');
        }

        if ($role === \App\Enums\Role::ADMIN) {
            // Admin can reject shipments pending admin approval
            if ($shipment->status !== Status::PENDING_ADMIN_APPROVAL->value) {
                throw new \Exception('Admin can only reject shipments that are pending admin approval. Current status: ' . $shipment->status);
            }

            $shipment->update([
                'status' => Status::REJECTED_BY_ADMIN->value
            ]);
        } elseif ($role === \App\Enums\Role::CUSTOMER) {
            // Customer can only reject their own shipments pending customer approval
            if ($shipment->sender_id !== $user->id) {
                throw new \Exception('You can only reject shipments that belong to you');
            }

            if ($shipment->status !== Status::PENDING_CUSTOMER_APPROVAL->value) {
                throw new \Exception('Customer can only reject shipments that are pending customer approval. Current status: ' . $shipment->status);
            }

            $shipment->update([
                'status' => Status::REJECTED_BY_CUSTOMER->value
            ]);
        } else {
            throw new \Exception('Only admins and customers can reject shipments');
        }

        return $shipment->fresh([
            'sender',
            'receiver',
            'originGovernorate',
            'destinationGovernorate',
            'originCenter',
            'destinationCenter',
            'shipmentGroup'
        ]);
    }

    public function assignShipmentToDelivery(int $shipmentId, int $deliveryPersonId): Shipment
    {
        $shipment = $this->model->with([
            'sender',
            'receiver',
            'originGovernorate',
            'destinationGovernorate',
            'originCenter',
            'destinationCenter',
            'shipmentGroup',
            'assignedDeliveryPerson'
        ])->find($shipmentId);

        if (!$shipment) {
            throw new \Exception('Shipment not found');
        }

        // Check if delivery person exists
        $deliveryPerson = \App\Models\DeliveryPerson::find($deliveryPersonId);
        if (!$deliveryPerson) {
            throw new \Exception('Delivery person not found');
        }

        // Validate that delivery person is assigned to the destination governorate
        if ($deliveryPerson->assigned_governorate_id !== $shipment->destination_governorate_id) {
            throw new \Exception('Delivery person is not assigned to the destination governorate');
        }

        // Update the shipment with the assigned delivery person
        $shipment->update(['assigned_delivery_person_id' => $deliveryPersonId]);

        return $shipment->fresh([
            'sender',
            'receiver',
            'originGovernorate',
            'destinationGovernorate',
            'originCenter',
            'destinationCenter',
            'shipmentGroup',
            'assignedDeliveryPerson'
        ]);
    }

    /**
     * Get shipments available for delivery (delivered to destination center)
     */
    public function getAvailableShipmentsToDeliver(?int $destinationCenterId = null, ?int $destinationGovernorateId = null): \Illuminate\Support\Collection
    {
        $query = $this->model->with([
            'sender',
            'receiver',
            'originGovernorate',
            'destinationGovernorate',
            'originCenter',
            'destinationCenter',
            'shipmentGroup',
            'assignedDeliveryPerson'
        ])->where('status', Status::DELIVERED_TO_DESTINATION_CENTER->value);

        // Apply optional filters
        if ($destinationCenterId) {
            $query->where('destination_center_id', $destinationCenterId);
        }

        if ($destinationGovernorateId) {
            $query->where('destination_governorate_id', $destinationGovernorateId);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get shipments assigned to a delivery person with status "delivered to destination center"
     */
    public function getDeliveryPersonAssignedShipments(int $deliveryPersonId): \Illuminate\Support\Collection
    {
        return $this->model->with([
            'sender',
            'receiver',
            'originGovernorate',
            'destinationGovernorate',
            'originCenter',
            'destinationCenter',
            'shipmentGroup',
            'assignedDeliveryPerson'
        ])
        ->where('assigned_delivery_person_id', $deliveryPersonId)
        ->where('status', Status::DELIVERED_TO_DESTINATION_CENTER->value)
        ->orderBy('created_at', 'desc')
        ->get();
    }

    /**
     * Get shipments sent by the authenticated customer
     */
    public function getMySentShipments(): \Illuminate\Support\Collection
    {
        $user = Auth::user();

        return $this->model->with([
            'sender',
            'receiver',
            'originGovernorate',
            'destinationGovernorate',
            'originCenter',
            'destinationCenter',
            'shipmentGroup',
            'assignedDeliveryPerson'
        ])
        ->where('sender_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();
    }

    /**
     * Get shipments received by the authenticated customer
     */
    public function getMyReceivedShipments(): \Illuminate\Support\Collection
    {
        $user = Auth::user();

        return $this->model->with([
            'sender',
            'receiver',
            'originGovernorate',
            'destinationGovernorate',
            'originCenter',
            'destinationCenter',
            'shipmentGroup',
            'assignedDeliveryPerson'
        ])
        ->where('receiver_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();
    }
}
