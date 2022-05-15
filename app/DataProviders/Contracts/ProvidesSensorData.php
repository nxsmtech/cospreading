<?php

namespace App\DataProviders\Contracts;

interface ProvidesSensorData
{
    public function getRoomSensorData(string $roomCode): array;
}
