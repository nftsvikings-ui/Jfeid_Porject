<?php

namespace App\Models;

use App\Models\Vehicle;
use App\Models\OilChange;
use App\Models\WheelService;
use App\Models\GearOilChange;
use App\Models\BatteryService;
use App\Models\SteeringOilChange;
use App\Models\DifferentialOilChange;
use App\Models\TransmissionOilChange;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRecord extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'vehicle_id',
        'maintenance_date',
        'type',
    
    ];

    /**
     * Get the vehicle that owns the maintenance record.
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Get the steering oil change associated with the maintenance record.
     */
    public function steeringOilChange()
    {
        return $this->hasOne(SteeringOilChange::class,'record_id');
    }

    /**
     * Get the battery service associated with the maintenance record.
     */
    public function batteryService()
    {
      return $this->hasOne(BatteryService::class, 'record_id');
    }
    /**
     * Get the wheel service associated with the maintenance record.
     */
    public function wheelService()
    {
       return $this->hasOne(WheelService::class, 'record_id');
    }
    /**
     * Get the transmission oil change associated with the maintenance record.
     */
    public function transmissionOilChange()
    {
        return $this->hasOne(TransmissionOilChange::class,'record_id');
    }
    /**
     * Get the differential oil change associated with the maintenance record.
     */
    public function differentialOilChange()
    {
        return $this->hasOne(DifferentialOilChange::class,'record_id');
    }
    /**
     * Get the gear oil change associated with the maintenance record.
     */
    public function gearOilChange()
    {
        return $this->hasOne(GearOilChange::class,'record_id');
    }
    /**
     * Get the oil change associated with the maintenance record.
     */
    public function oilChange()
    {
        return $this->hasOne(OilChange::class, 'record_id');
    }
}
