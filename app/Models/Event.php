<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    protected $fillable = [
        'name',
        'room_id',
        'start_date',
        'end_date',
        'attendee_count',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
