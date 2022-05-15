<?php

namespace App\Resources\Sensors;

abstract class Sensor
{
    private string $sensorId;
    private string $sensorType;
    private int $roomId;
    private array $measurements;

    public function __construct(string $sensorId, string $sensorType, int $roomId, array $measurements)
    {
        $this->sensorId = $sensorId;
        $this->sensorType = $sensorType;
        $this->roomId = $roomId;
        $this->measurements = $measurements;
    }

    /**
     * @return string
     */
    public function getSensorId(): string
    {
        return $this->sensorId;
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

    /**
     * @return array
     */
    public function getMeasurements(): array
    {
        return $this->measurements;
    }

    abstract public function calculateRiskLevel(): int;
}
