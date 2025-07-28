<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Phase 1: Foundation Data (No Dependencies)
        $this->call([
            GovernorateSeeder::class,
            UserSeeder::class,
        ]);

        // Phase 2: Geographic Infrastructure
        $this->call([
            CompanyCenterSeeder::class,
            CheckpointSeeder::class,
        ]);

        // Phase 3: Personnel Setup
        $this->call([
            DriverSeeder::class,
            DeliveryPersonSeeder::class,
        ]);

        // Phase 4: Core Business Data
        $this->call([
            ShipmentGroupSeeder::class,
            GroupCheckpointSeeder::class,
            ShipmentSeeder::class,
            GroupTrackingSeeder::class,
        ]);

        // Phase 5: Business Operations
        $this->call([
            PaymentSeeder::class,
            DeliveryConfirmationSeeder::class,
            ComplaintSeeder::class,
        ]);
    }
}
