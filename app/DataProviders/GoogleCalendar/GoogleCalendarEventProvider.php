<?php

namespace App\DataProviders\GoogleCalendar;

use App\DataProviders\Contracts\ProvidesEventData;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\GoogleCalendar\Event;

class GoogleCalendarEventProvider implements ProvidesEventData
{
    private const EVENTS_FROM_FUTURE_WEEK_COUNT = 2;

    public function getRoomEventData(Room $room): Collection
    {
        //TODO query all events for the room by query (currently not available on free google calendar)
        $allEvents = Event::get(Carbon::now(), Carbon::now()->addWeeks(self::EVENTS_FROM_FUTURE_WEEK_COUNT));
        return $this->getRoomEventsByRoomCode($room, $allEvents);
    }

    private function getRoomEventsByRoomCode(Room $room, Collection $events): Collection
    {
        return $events->filter(function ($event) use ($room) {
            return $event->googleEvent->description === $room->code;
        });
    }
}
