<?php

namespace App\Repository;

use App\DataProviders\Contracts\ProvidesSensorData;

class RoomSensorDataRepository implements RoomSensorDataRepositoryInterface
{
    private ProvidesSensorData $providesSensorData;

    public function __construct(ProvidesSensorData $providesSensorData)
    {
        $this->providesSensorData = $providesSensorData;
    }

    public function getRoomSensorData(string $roomCode): array
    {
        return $this->providesSensorData->getRoomSensorData($roomCode);
    }
}
