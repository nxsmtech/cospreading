<?php

namespace App\Models;

use Database\Factories\RiskLevelFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiskLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'level',
        'room_id',
    ];

    protected static function newFactory(): RiskLevelFactory
    {
        return new RiskLevelFactory();
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
