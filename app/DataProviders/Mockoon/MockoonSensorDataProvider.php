<?php

namespace App\DataProviders\Mockoon;

use App\DataProviders\Contracts\ProvidesSensorData;

class MockoonSensorDataProvider implements ProvidesSensorData
{
    public function getRoomSensorData(string $roomCode): array
    {
        return [];
    }
}
