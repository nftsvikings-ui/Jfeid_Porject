<?php

namespace Tests\Feature;

use App\Models\MaintenanceRecord;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaintenanceRecordDetailsTest extends TestCase
{
    use RefreshDatabase;

    private function record(string $type): MaintenanceRecord
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test' . uniqid() . '@example.com',
            'phonenumber' => '000',
            'password' => 'secret',
        ]);

        $vehicle = Vehicle::create([
            'user_id' => $user->id,
            'type' => 'Toyota Hilux',
        ]);

        return MaintenanceRecord::create([
            'vehicle_id' => $vehicle->id,
            'maintenance_date' => now(),
            'type' => $type,
        ]);
    }

    public function test_wheel_service_details_are_persisted(): void
    {
        $record = $this->record('wheel_service');

        $record->syncTypeDetails([
            'wheel_name' => 'Michelin',
            'quantity' => '4',
            'wheel_size' => 'R17',
        ]);

        $this->assertDatabaseHas('wheel_services', [
            'record_id' => $record->id,
            'wheel_name' => 'Michelin',
            'quantity' => '4',
            'wheel_size' => 'R17',
        ]);

        // this is what the mobile app reads
        $this->assertNotNull($record->fresh()->wheelService);
    }

    public function test_battery_service_uses_submitted_values_not_defaults(): void
    {
        $record = $this->record('battery_service');

        $record->syncTypeDetails(['brand' => 'Varta', 'size' => '70Ah']);

        $this->assertDatabaseHas('battery_services', [
            'record_id' => $record->id,
            'brand' => 'Varta',
            'size' => '70Ah',
        ]);
        $this->assertDatabaseMissing('battery_services', ['brand' => 'Default Brand']);
    }

    public function test_oil_change_details_are_persisted(): void
    {
        $record = $this->record('oil_change');

        $record->syncTypeDetails([
            'oil_type' => '5W-30',
            'oil_quantity' => '5',
            'current_km' => '120000',
            'next_change_km' => '125000',
            'filter' => 'Bosch',
        ]);

        $this->assertDatabaseHas('oil_changes', [
            'record_id' => $record->id,
            'oil_type' => '5W-30',
            'filter' => 'Bosch',
        ]);
    }

    public function test_sync_is_idempotent_and_updates_in_place(): void
    {
        $record = $this->record('wheel_service');

        $record->syncTypeDetails(['wheel_name' => 'Michelin', 'quantity' => '4', 'wheel_size' => 'R17']);
        $record->syncTypeDetails(['wheel_name' => 'Pirelli', 'quantity' => '2', 'wheel_size' => 'R18']);

        $this->assertDatabaseCount('wheel_services', 1);
        $this->assertSame('Pirelli', $record->fresh()->wheelService->wheel_name);
    }

    public function test_missing_fields_do_not_write_a_broken_row(): void
    {
        $record = $this->record('wheel_service');

        $record->syncTypeDetails(['wheel_name' => 'Michelin']);

        $this->assertDatabaseCount('wheel_services', 0);
    }

    public function test_changing_type_removes_the_previous_detail_row(): void
    {
        $record = $this->record('wheel_service');
        $record->syncTypeDetails(['wheel_name' => 'Michelin', 'quantity' => '4', 'wheel_size' => 'R17']);
        $this->assertDatabaseCount('wheel_services', 1);

        // admin edits the record and switches it to an oil change
        $record->update(['type' => 'oil_change']);
        $record->syncTypeDetails([
            'oil_type' => '5W-30',
            'oil_quantity' => '5',
            'current_km' => '120000',
            'next_change_km' => '125000',
            'filter' => 'Bosch',
        ]);

        $this->assertDatabaseCount('wheel_services', 0);
        $this->assertDatabaseCount('oil_changes', 1);

        // the API eager-loads every relation; only the current one may be set
        $fresh = $record->fresh();
        $this->assertNull($fresh->wheelService);
        $this->assertNotNull($fresh->oilChange);
    }

    public function test_editing_details_does_not_duplicate_rows(): void
    {
        $record = $this->record('oil_change');
        $payload = [
            'oil_type' => '5W-30',
            'oil_quantity' => '5',
            'current_km' => '120000',
            'next_change_km' => '125000',
            'filter' => 'Bosch',
        ];

        $record->syncTypeDetails($payload);
        $record->syncTypeDetails(array_merge($payload, ['current_km' => '130000']));

        $this->assertDatabaseCount('oil_changes', 1);
        $this->assertSame('130000', $record->fresh()->oilChange->current_km);
    }
}
