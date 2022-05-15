<?php

namespace App\Services;

use App\Enums\RiskLevel;
use App\Resources\Sensors\Sensor;

class CarbonDioxideRiskCalculationService implements CalculatesRiskLevel
{
    public function calculateRiskLevel(Sensor $sensor): int
    {
        $sensorMeasurements = $sensor->getMeasurements();
        $carbonDioxideMeasurement = $sensorMeasurements[0]->carbonDioxide;

        return $this->getCarbonDioxideMeasurementRating($carbonDioxideMeasurement);
    }

    private function getCarbonDioxideMeasurementRating(int $measurement): string
    {
        $limits = config('sensor-data.limits.carbonDioxide');
        $carbonDioxideMeasurementRating = RiskLevel::NO_RISK->riskRating();

        foreach ($limits as $limit => $rating) {
            if ($measurement < $limit) {
                continue;
            }

            $carbonDioxideMeasurementRating = $rating;
        }

        return $carbonDioxideMeasurementRating;
    }
}
