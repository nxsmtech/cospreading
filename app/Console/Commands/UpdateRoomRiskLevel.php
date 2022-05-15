<?php

namespace App\Console\Commands;

use App\Enums\RiskLevel;
use App\Models\Room;
use Illuminate\Console\Command;

class UpdateRoomRiskLevel extends Command
{
    private const ROOM_CHUNK_SIZE = 10;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'risk:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update risk level for each room';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->info('Starting room risk update');

        Room::chunk(self::ROOM_CHUNK_SIZE, function ($rooms) {
            foreach($rooms as $room) {
                $this->info('Updating risk level in the room: ' . $room->name);

                $this->updateRoomRiskLevel($room);

                $this->info('Room '
                    . $room->name
                    . ' current risk level is '
                    . $this->formatRiskLevelOutput($room->riskLevel->level));

                $this->info('----');
            }
        });
    }

    private function updateRoomRiskLevel(Room $room): void
    {
        $riskLevel = $room->riskLevel;
        $riskLevel->level = 'Critical';
        $riskLevel->save();
    }

    private function formatRiskLevelOutput(string $riskLevel): string
    {
        if (in_array($riskLevel, [RiskLevel::NO_RISK->level(), RiskLevel::LOW->level()], true))
        {
            return '<fg=black;bg=white>'. $riskLevel . '</>';
        }

        if ($riskLevel === RiskLevel::MEDIUM->level())
        {
            return '<fg=black;bg=yellow>'. $riskLevel . '</>';
        }

        if (in_array($riskLevel, [RiskLevel::HIGH->level(), RiskLevel::CRITICAL->level()], true))
        {
            return '<fg=white;bg=red>'. $riskLevel . '</>';
        }

        return $riskLevel;
    }
}
