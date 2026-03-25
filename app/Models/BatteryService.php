<?php

namespace App\Models;

use App\Models\Vehicle;
use App\Models\MaintenanceRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BatteryService extends Model
{
   
   protected $fillable = [
        'record_id',
        'brand',
        'size',
    ];

    public function maintenanceRecord(): BelongsTo
    {
        return $this->belongsTo(MaintenanceRecord::class, 'record_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

}
