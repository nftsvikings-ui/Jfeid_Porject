<?php

namespace App\Models;

use App\Models\MaintenanceRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GearOilChange extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'record_id',
        'oil_type',
        'quantity',
    ];

    /**
     * Get the maintenance record that owns the gear oil change.
     */
public function maintenanceRecord()
{
    return $this->belongsTo(MaintenanceRecord::class, 'record_id');
}
}
