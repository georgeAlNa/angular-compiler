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
        Schema::create('delivery_confirmations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')->constrained('shipments');
            $table->foreignId('confirmed_by_delivery_person_id')->constrained('delivery_persons');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_confirmations');
    }
};
