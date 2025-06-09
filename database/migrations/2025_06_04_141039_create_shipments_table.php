<?php

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
            $table->foreignId('group_id')->constrained('shipment_groups');
            $table->string('type_of_cargo');
            $table->float('weight');
            $table->string('origin_address');
            $table->string('destination_address');
            $table->string('special_handling_instructions')->nullable();
            $table->foreignId('origin_governorate_id')->constrained('governorates');
            $table->foreignId('destination_governorate_id')->constrained('governorates');
            $table->foreignId('origin_center_id')->nullable()->constrained('company_centers');
            $table->foreignId('destination_center_id')->nullable()->constrained('company_centers');
            $table->string('status');
            $table->string('qr_code')->unique();
            $table->float('price');
            $table->foreignId('price_set_by_admin_id')->constrained('users');
            $table->timestamp('price_set_at');
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
