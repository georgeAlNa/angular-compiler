<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\DeliveryPersonController;
use App\Http\Controllers\Api\CheckpointController;
use App\Http\Controllers\Api\ComplaintController;
use App\Http\Controllers\Api\DeliveryConfirmationController;
use App\Http\Controllers\Api\GovernorateController;
use App\Http\Controllers\Api\GroupCheckpointController;
use App\Http\Controllers\Api\GroupTrackingController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ShipmentController;
use App\Http\Controllers\Api\ShipmentGroupController;
use App\Http\Controllers\CompanyCenterController;
use Illuminate\Support\Facades\Route;

// Authentication routes (public)
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Protected authentication routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
    Route::put('user/update-profile', [UserController::class, 'updateProfile']);
});

// Users routes - restricted to admin
Route::middleware('auth:sanctum')->group(function () {
    Route::get('users/all', [UserController::class, 'all']);
    Route::get('users', [UserController::class, 'index']);
    Route::post('users', [UserController::class, 'store']);
    Route::get('users/{user}', [UserController::class, 'show']);
    Route::put('users/{user}', [UserController::class, 'update']);
    Route::delete('users/{user}', [UserController::class, 'destroy']);
});

// Drivers routes
Route::middleware(['auth:sanctum'])->group(function () {
    // Admin and drivers can view drivers
    Route::middleware('role:admin,driver')->group(function () {
        Route::get('drivers/all', [DriverController::class, 'all']);
        Route::get('drivers', [DriverController::class, 'index']);
    });

    // Only admin can create drivers
    Route::middleware('role:admin')->group(function () {
        Route::post('drivers', [DriverController::class, 'store']);
    });

    Route::middleware('role:driver')->group(function () {
        Route::get('drivers/available-shipment-groups', [DriverController::class, 'getAvailableShipmentsGroup']);
        Route::post('drivers/start-shipment', [DriverController::class, 'startShipment']);
        Route::post('drivers/end-shipment', [DriverController::class, 'endShipment']);
        Route::post('drivers/mark-checkpoint', [DriverController::class, 'markCheckpointAsChecked']);
    });

    // Admin and drivers can view specific drivers
    Route::middleware('role:admin,driver')->group(function () {
        Route::get('drivers/{driver}', [DriverController::class, 'show']);
        Route::put('drivers/{driver}', [DriverController::class, 'update']);
    });

    // Only admin can delete drivers
    Route::middleware('role:admin')->group(function () {
        Route::delete('drivers/{driver}', [DriverController::class, 'destroy']);
    });
});

// Delivery persons routes
Route::middleware(['auth:sanctum'])->group(function () {
    // Admin and delivery persons can view delivery persons
    Route::middleware('role:admin,delivery_person')->group(function () {
        Route::get('delivery-persons/all', [DeliveryPersonController::class, 'all']);
        Route::get('delivery-persons', [DeliveryPersonController::class, 'index']);
    });

    // Only admin can delete delivery persons
    Route::middleware('role:admin')->group(function () {
        Route::post('delivery-persons', [DeliveryPersonController::class, 'store']);
    });

    Route::middleware('role:delivery_person')->group(function () {
        Route::get('delivery-persons/my-assigned-shipments', [DeliveryPersonController::class, 'getMyAssignedShipments']);
    });

    // Admin and delivery persons can view specific delivery persons
    Route::middleware('role:admin,delivery_person')->group(function () {
        Route::get('delivery-persons/{delivery_person}', [DeliveryPersonController::class, 'show']);
        Route::put('delivery-persons/{delivery_person}', [DeliveryPersonController::class, 'update']);
    });

    // Only admin can delete delivery persons
    Route::middleware('role:admin')->group(function () {
        Route::delete('delivery-persons/{delivery_person}', [DeliveryPersonController::class, 'destroy']);
    });
});

// Governorates routes - accessible to all authenticated users
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('governorates/all', [GovernorateController::class, 'all']);
    Route::get('governorates', [GovernorateController::class, 'index']);
    Route::get('governorates/{governorate}', [GovernorateController::class, 'show']);

    // Only admin can modify governorates
    Route::middleware('role:admin')->group(function () {
        Route::post('governorates', [GovernorateController::class, 'store']);
        Route::put('governorates/{governorate}', [GovernorateController::class, 'update']);
        Route::delete('governorates/{governorate}', [GovernorateController::class, 'destroy']);
    });
});

// Company Centers routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('company-centers/all', [CompanyCenterController::class, 'all']);
    Route::get('company-centers', [CompanyCenterController::class, 'index']);
    Route::get('company-centers/{company_center}', [CompanyCenterController::class, 'show']);
    Route::post('company-centers', [CompanyCenterController::class, 'store']);
    Route::put('company-centers/{company_center}', [CompanyCenterController::class, 'update']);
    Route::delete('company-centers/{company_center}', [CompanyCenterController::class, 'destroy']);
});

// Shipments routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('shipments/all', [ShipmentController::class, 'all']);
    Route::get('shipments', [ShipmentController::class, 'index']);
    Route::post('shipments', [ShipmentController::class, 'store']);
    Route::post('shipments/bulk-assign-group', [ShipmentController::class, 'bulkAssignGroup']);

    // Customer routes
    Route::middleware('role:customer')->group(function () {
        Route::post('shipments/add-shipment-request', [ShipmentController::class, 'addShipmentRequest']);
        Route::post('shipments/approve-price', [ShipmentController::class, 'approvePrice']);
        Route::get('shipments/my-sent-shipments', [ShipmentController::class, 'getMySentShipments']);
        Route::get('shipments/my-received-shipments', [ShipmentController::class, 'getMyReceivedShipments']);
    });

    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::get('shipments/pending', [ShipmentController::class, 'getPendingShipments']);
        Route::post('shipments/price-shipment', [ShipmentController::class, 'priceShipment']);
        Route::post('shipments/assign-delivery', [ShipmentController::class, 'assignShipment']);
        Route::get('shipments/available-to-deliver', [ShipmentController::class, 'getAvailableShipmentsToDeliver']);
    });

    // Routes accessible by both admin and customer
    Route::middleware('role:admin,customer')->group(function () {
        Route::post('shipments/reject-shipment', [ShipmentController::class, 'rejectShipment']);
    });

    // Specific shipment routes (must come after specific routes)
    Route::get('shipments/{shipment}', [ShipmentController::class, 'show']);
    Route::put('shipments/{shipment}', [ShipmentController::class, 'update']);
    Route::delete('shipments/{shipment}', [ShipmentController::class, 'destroy']);
});

// Shipment Groups routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('shipment-groups/all', [ShipmentGroupController::class, 'all']);
    Route::get('shipment-groups', [ShipmentGroupController::class, 'index']);
    Route::post('shipment-groups', [ShipmentGroupController::class, 'store']);
    Route::post('shipment-groups/with-shipments-checkpoints', [ShipmentGroupController::class, 'createWithShipmentsAndCheckpoints']);

    // Specific shipment group routes (must come after specific routes)
    Route::get('shipment-groups/{shipment_group}/checkpoints', [ShipmentGroupController::class, 'getShipmentGroupCheckpoints']);
    Route::get('shipment-groups/{shipment_group}', [ShipmentGroupController::class, 'show']);
    Route::put('shipment-groups/{shipment_group}', [ShipmentGroupController::class, 'update']);
    Route::delete('shipment-groups/{shipment_group}', [ShipmentGroupController::class, 'destroy']);
});

// Checkpoints routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('checkpoints/all', [CheckpointController::class, 'all']);
    Route::get('checkpoints', [CheckpointController::class, 'index']);
    Route::post('checkpoints', [CheckpointController::class, 'store']);
    Route::get('checkpoints/{checkpoint}', [CheckpointController::class, 'show']);
    Route::put('checkpoints/{checkpoint}', [CheckpointController::class, 'update']);
    Route::delete('checkpoints/{checkpoint}', [CheckpointController::class, 'destroy']);
});

// Group Checkpoints routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('group-checkpoints/all', [GroupCheckpointController::class, 'all']);
    Route::get('group-checkpoints', [GroupCheckpointController::class, 'index']);
    Route::post('group-checkpoints', [GroupCheckpointController::class, 'store']);
    Route::get('group-checkpoints/{group_checkpoint}', [GroupCheckpointController::class, 'show']);
    Route::put('group-checkpoints/{group_checkpoint}', [GroupCheckpointController::class, 'update']);
    Route::delete('group-checkpoints/{group_checkpoint}', [GroupCheckpointController::class, 'destroy']);
    Route::post('group-checkpoints/bulk-create', [GroupCheckpointController::class, 'createBulk']);
});

// Group Tracking routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('group-trackings/all', [GroupTrackingController::class, 'all']);
    Route::get('group-trackings', [GroupTrackingController::class, 'index']);
    Route::post('group-trackings', [GroupTrackingController::class, 'store']);
    Route::get('group-trackings/{group_tracking}', [GroupTrackingController::class, 'show']);
    Route::put('group-trackings/{group_tracking}', [GroupTrackingController::class, 'update']);
    Route::delete('group-trackings/{group_tracking}', [GroupTrackingController::class, 'destroy']);
});

// Delivery Confirmations routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('delivery-confirmations/all', [DeliveryConfirmationController::class, 'all']);
    Route::get('delivery-confirmations', [DeliveryConfirmationController::class, 'index']);
    Route::post('delivery-confirmations', [DeliveryConfirmationController::class, 'store']);
    Route::post('delivery-confirmations/confirm-delivery', [DeliveryConfirmationController::class, 'confirmDelivery']);
    Route::get('delivery-confirmations/{delivery_confirmation}', [DeliveryConfirmationController::class, 'show']);
    Route::put('delivery-confirmations/{delivery_confirmation}', [DeliveryConfirmationController::class, 'update']);
    Route::delete('delivery-confirmations/{delivery_confirmation}', [DeliveryConfirmationController::class, 'destroy']);
});

// Payments routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('payments/all', [PaymentController::class, 'all']);
    Route::get('payments', [PaymentController::class, 'index']);
    Route::post('payments', [PaymentController::class, 'store']);
    Route::get('payments/{payment}', [PaymentController::class, 'show']);
    Route::put('payments/{payment}', [PaymentController::class, 'update']);
    Route::delete('payments/{payment}', [PaymentController::class, 'destroy']);
});

// Complaints routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('complaints/all', [ComplaintController::class, 'all']);
    Route::get('complaints', [ComplaintController::class, 'index']);
    Route::post('complaints', [ComplaintController::class, 'store']);
    Route::get('complaints/{complaint}', [ComplaintController::class, 'show']);
    Route::put('complaints/{complaint}', [ComplaintController::class, 'update']);
    Route::delete('complaints/{complaint}', [ComplaintController::class, 'destroy']);
});
