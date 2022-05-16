<?php

namespace App\Services;

use App\Models\Room;
use App\Repository\EventDataRepository;
use Illuminate\Support\Collection;

class EventDataService
{
    private EventDataRepository $eventDataRepository;

    public function __construct(EventDataRepository $eventDataRepository)
    {
        $this->eventDataRepository = $eventDataRepository;
    }

    public function getRoomEventData(Room $room): Collection
    {
        return $this->eventDataRepository->getRoomEvents($room);
    }
}
