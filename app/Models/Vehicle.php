<?php

namespace App\Models;

use App\Models\User;
use App\Models\MaintenanceRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'type'
    ];

    /**
     * Get the maintenance records for the vehicle.
     */
   public function maintenanceRecords()
{
    return $this->hasMany(MaintenanceRecord::class);
}
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
