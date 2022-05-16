<?php

namespace App\Models;

use Database\Factories\RoomFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'allowed_attendee_count',
    ];

    protected static function newFactory(): RoomFactory
    {
        return new RoomFactory();
    }

    public function riskLevel(): HasOne
    {
        return $this->hasOne(RiskLevel::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
