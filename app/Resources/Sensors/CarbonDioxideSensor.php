<?php

namespace App\Resources\Sensors;

use App\Enums\RiskLevel;

class CarbonDioxideSensor extends Sensor
{
    public function calculateRiskLevel(): int
    {
        $sensorMeasurements = $this->getMeasurements();
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
