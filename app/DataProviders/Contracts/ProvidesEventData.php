<?php

namespace App\DataProviders\Contracts;

use App\Models\Room;
use Illuminate\Support\Collection;

interface ProvidesEventData
{
    public function getRoomEventData(Room $room): Collection;
}
