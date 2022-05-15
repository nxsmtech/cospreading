<?php

namespace App\Resources;

class SensorData
{
    private string $sensorName;
    private string $sensorType;
    private int $roomId;

    public function __construct(string $sensorName, string $sensorType, int $roomId)
    {
        $this->sensorName = $sensorName;
        $this->sensorType = $sensorType;
        $this->roomId = $roomId;
    }

    /**
     * @return string
     */
    public function getSensorName(): string
    {
        return $this->sensorName;
    }

    /**
     * @return string
     */
    public function getSensorType(): string
    {
        return $this->sensorType;
    }

    /**
     * @return int
     */
    public function getRoomId(): int
    {
        return $this->roomId;
    }


}
