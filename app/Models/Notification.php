<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'topic',
        'title',
        'body',
        'response',
    ];
    
    protected $casts = [
        'response' => 'array',
    ];
}
