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
        Schema::create('group_trackings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('shipment_groups')->onDelete('cascade');
            $table->foreignId('checkpoint_id')->constrained('checkpoints');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_trackings');
    }
};
