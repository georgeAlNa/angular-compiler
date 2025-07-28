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
        Schema::create('shipment_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->constrained('drivers');
            $table->foreignId('created_by_admin_id')->constrained('users');
            $table->foreignId('last_updated_by_admin_id')->constrained('users');
            $table->foreignId('from_governorate_id')->constrained('governorates');
            $table->foreignId('to_governorate_id')->constrained('governorates');
            $table->foreignId('from_center_id')->constrained('company_centers');
            $table->foreignId('to_center_id')->constrained('company_centers');
            $table->string('route_description')->nullable();
            $table->enum('status', Status::values())->default(Status::PENDING_FOR_ASSIGNMENT->value);
            $table->string('code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipment_groups');
    }
};
