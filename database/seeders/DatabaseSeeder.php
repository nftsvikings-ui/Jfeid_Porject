<?php

namespace Database\Seeders;

use App\Models\BatteryService;
use App\Models\DifferentialOilChange;
use App\Models\GearOilChange;
use App\Models\MaintenanceRecord;
use App\Models\OilChange;
use App\Models\Policy;
use App\Models\SteeringOilChange;
use App\Models\TransmissionOilChange;
use App\Models\Vehicle;
use App\Models\WheelService;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $vehicle = Vehicle::updateOrCreate(
            ['user_id' => $user->id, 'type' => 'Sedan'],
            ['type' => 'Sedan']
        );

        $oilRecord = MaintenanceRecord::updateOrCreate(
            ['vehicle_id' => $vehicle->id, 'type' => 'oil_change'],
            ['maintenance_date' => Carbon::parse('2025-01-15 09:00:00')]
        );
        OilChange::updateOrCreate(
            ['record_id' => $oilRecord->id],
            [
                'current_km' => '52000',
                'oil_type' => '5W-30',
                'oil_quantity' => '4.5L',
                'filter' => 'OEM',
                'next_change_km' => '57000',
            ]
        );

        $steeringRecord = MaintenanceRecord::updateOrCreate(
            ['vehicle_id' => $vehicle->id, 'type' => 'steering_oil_change'],
            ['maintenance_date' => Carbon::parse('2025-02-10 11:00:00')]
        );
        SteeringOilChange::updateOrCreate(
            ['record_id' => $steeringRecord->id],
            [
                'oil_type' => 'ATF',
                'quantity' => 1.0,
            ]
        );

        $batteryRecord = MaintenanceRecord::updateOrCreate(
            ['vehicle_id' => $vehicle->id, 'type' => 'battery_service'],
            ['maintenance_date' => Carbon::parse('2025-03-05 13:30:00')]
        );
        BatteryService::updateOrCreate(
            ['record_id' => $batteryRecord->id],
            [
                'brand' => 'Bosch',
                'size' => 'Group 35',
            ]
        );

        $wheelRecord = MaintenanceRecord::updateOrCreate(
            ['vehicle_id' => $vehicle->id, 'type' => 'wheel_service'],
            ['maintenance_date' => Carbon::parse('2025-04-20 15:45:00')]
        );
        WheelService::updateOrCreate(
            ['record_id' => $wheelRecord->id],
            [
                'wheel_name' => 'Michelin',
                'quantity' => '4',
                'wheel_size' => '18',
            ]
        );

        $transmissionRecord = MaintenanceRecord::updateOrCreate(
            ['vehicle_id' => $vehicle->id, 'type' => 'transmission_oil_change'],
            ['maintenance_date' => Carbon::parse('2025-05-12 08:15:00')]
        );
        TransmissionOilChange::updateOrCreate(
            ['record_id' => $transmissionRecord->id],
            [
                'oil_type' => 'ATF',
                'quantity' => 6.5,
            ]
        );

        $differentialRecord = MaintenanceRecord::updateOrCreate(
            ['vehicle_id' => $vehicle->id, 'type' => 'differential_oil_change'],
            ['maintenance_date' => Carbon::parse('2025-06-18 16:20:00')]
        );
        DifferentialOilChange::updateOrCreate(
            ['record_id' => $differentialRecord->id],
            [
                'oil_type' => '75W-90',
                'quantity' => 1.2,
            ]
        );

        $gearRecord = MaintenanceRecord::updateOrCreate(
            ['vehicle_id' => $vehicle->id, 'type' => 'gear_oil_change'],
            ['maintenance_date' => Carbon::parse('2025-07-25 10:30:00')]
        );
        GearOilChange::updateOrCreate(
            ['record_id' => $gearRecord->id],
            [
                'oil_type' => '75W-90',
                'quantity' => 2.0,
            ]
        );

        Policy::updateOrCreate(
            ['slug' => 'privacy-policy'],
            [
                'title' => 'Privacy Policy',
                'content' => 'This is sample privacy policy text for development/testing.',
            ]
        );
        Policy::updateOrCreate(
            ['slug' => 'terms-conditions'],
            [
                'title' => 'Terms & Conditions',
                'content' => 'This is sample terms and conditions text for development/testing.',
            ]
        );
    }
}
