<?php

namespace App\Services;

use App\Enums\RiskLevel;
use App\Enums\SensorType;
use App\Resources\Sensors\Sensor;

class CarbonDioxideRiskCalculationService implements CalculatesRiskLevel
{
    public function calculateRiskLevel(Sensor $sensor): array
    {
        $sensorMeasurements = $sensor->getMeasurements();
        $carbonDioxideMeasurement = $sensorMeasurements[0]->carbonDioxide;

        return [
            'type' => SensorType::CARBON_DIOXIDE,
            'riskLevel' => $this->getCarbonDioxideMeasurementRating($carbonDioxideMeasurement),
            'measurements' => $sensorMeasurements,
        ];
    }

    private function getCarbonDioxideMeasurementRating(int $measurement): int
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
