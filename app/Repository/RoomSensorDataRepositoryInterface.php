<?php

namespace App\Repository;

interface RoomSensorDataRepositoryInterface
{
    public function getRoomSensorData(string $roomCode): array;
}
