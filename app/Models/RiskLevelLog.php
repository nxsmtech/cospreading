<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiskLevelLog extends Model
{
    protected $fillable = [
        'level',
        'room_id',
        'measurements',
    ];
}
