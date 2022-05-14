<?php

namespace App\Models;

use Database\Factories\RiskLevelFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'level',
        'room',
    ];

    protected static function newFactory(): RiskLevelFactory
    {
        return new RiskLevelFactory();
    }
}
