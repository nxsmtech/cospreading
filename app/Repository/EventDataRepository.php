<?php

namespace App\Repository;

use App\DataProviders\Contracts\ProvidesEventData;
use App\Models\Room;
use Illuminate\Support\Collection;

class EventDataRepository implements EventDataRepositoryInterface
{
    private ProvidesEventData $providesEventData;

    public function __construct(ProvidesEventData $providesEventData)
    {
        $this->providesEventData = $providesEventData;
    }

    public function getRoomEvents(Room $room): Collection
    {
        return $this->providesEventData->getRoomEventData($room);
    }
}
