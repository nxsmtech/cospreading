<?php

namespace App\Enums;

use App\Resources\Sensors\CarbonDioxideSensor;
use App\Resources\Sensors\HumiditySensor;

enum SensorType: string
{
    case CARBON_DIOXIDE = 'CarbonDioxide';
    case HUMIDITY = 'Humidity';

    public function typeClass(): string
    {
        return match ($this) {
            self::CARBON_DIOXIDE => CarbonDioxideSensor::class,
            self::HUMIDITY => HumiditySensor::class,
        };
    }
}
