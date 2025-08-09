<?php

use App\Enums\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users');
            $table->foreignId('receiver_id')->constrained('users');
            $table->foreignId('group_id')->nullable()->constrained('shipment_groups')->nullOnDelete();
            $table->string('type_of_cargo');
            $table->float('weight');
            $table->string('origin_address');
            $table->string('destination_address');
            $table->string('special_handling_instructions')->nullable();
            $table->foreignId('origin_governorate_id')->constrained('governorates');
            $table->foreignId('destination_governorate_id')->constrained('governorates');
            $table->foreignId('origin_center_id')->nullable()->constrained('company_centers');
            $table->foreignId('destination_center_id')->nullable()->constrained('company_centers');
            $table->foreignId('assigned_delivery_person_id')->nullable()->constrained('delivery_persons');
            $table->enum('status', Status::values())->default(Status::PENDING_ADMIN_APPROVAL->value);
            $table->string('qr_code')->nullable()->unique();
            $table->string('code')->unique();
            $table->float('price')->nullable();
            $table->foreignId('price_set_by_admin_id')->nullable()->constrained('users');
            $table->timestamp('price_set_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
