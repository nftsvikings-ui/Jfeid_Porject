<?php

namespace App\Models;

use App\Models\MaintenanceRecord;
use Illuminate\Database\Eloquent\Model;

class OilChange extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'record_id',
        'current_km',
        'oil_type',
        'oil_quantity',
        'filter',
        'next_change_km'
    ];

    /**
     * Get the maintenance record that owns the oil change.
     */
    public function maintenanceRecord()
    {
        return $this->belongsTo(MaintenanceRecord::class, 'record_id');
    }
}
