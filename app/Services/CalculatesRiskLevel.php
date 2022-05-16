<?php

namespace App\Services;

use App\Resources\Sensors\Sensor;

interface CalculatesRiskLevel
{
    public function calculateRiskLevel(Sensor $sensor): array;
}
