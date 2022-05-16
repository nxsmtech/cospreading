<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Room;
use App\Services\EventDataService;
use Illuminate\Console\Command;

class UpdateRoomEvents extends Command
{
    private const ROOM_CHUNK_SIZE = 10;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update event visitor information for each room';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->info('Starting room event visitor information update');

        Room::chunk(self::ROOM_CHUNK_SIZE, function ($rooms) {
            foreach($rooms as $room) {
                $this->info('Updating event visitor information in the room: ' . $room->name);

                $roomEvents = app(EventDataService::class)->getRoomEventData($room);

                foreach ($roomEvents as $roomEvent) {
                    Event::updateOrCreate(
                        ['room_id' => $room->id, 'name' => $roomEvent->googleEvent->summary],
                        [
                            'start_date' => $roomEvent->googleEvent->start->dateTime,
                            'end_date' => $roomEvent->googleEvent->end->dateTime,
                            'attendee_count' => count($roomEvent->googleEvent->attendees),
                        ],
                    );
                }

                $this->info('Room ' . $room->name . ' event visitor information updated');
                $this->info('----');
            }
        });
    }
}
