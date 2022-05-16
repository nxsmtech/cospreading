<?php

namespace App\Repository;

use App\Models\Room;
use Illuminate\Support\Collection;

interface EventDataRepositoryInterface
{
    public function getRoomEvents(Room $room): Collection;
}
