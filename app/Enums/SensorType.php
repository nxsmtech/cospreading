<?php

namespace App\Enums;

use App\Resources\Sensors\CarbonDioxideSensor;
use App\Resources\Sensors\HumiditySensor;
use App\Resources\Sensors\RegisterSystemSensor;

enum SensorType: string
{
    case CARBON_DIOXIDE = 'CarbonDioxide';
    case HUMIDITY = 'Humidity';
    case REGISTER_SYSTEM = 'RegisterSystem';

    public function typeClass(): string
    {
        return match ($this) {
            self::CARBON_DIOXIDE => CarbonDioxideSensor::class,
            self::HUMIDITY => HumiditySensor::class,
            self::REGISTER_SYSTEM => RegisterSystemSensor::class,
        };
    }
}
