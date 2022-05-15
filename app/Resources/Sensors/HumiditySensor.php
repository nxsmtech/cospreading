<?php

namespace App\Resources\Sensors;

use App\Enums\RiskLevel;

class HumiditySensor extends Sensor
{
    public function calculateRiskLevel(): int
    {
        $sensorMeasurements = $this->getMeasurements();
        $humidityMeasurement = $sensorMeasurements[0]->humidity;
        $temperatureMeasurement = $sensorMeasurements[1]->temperature;

        $humidityGradesByTemperature =
            $this->getHumidityTemperatureGradesByHumidityMeasurementLevel($humidityMeasurement);

        return $this->getHumidityGradeByTemperature($temperatureMeasurement, $humidityGradesByTemperature);
    }

    private function getHumidityTemperatureGradesByHumidityMeasurementLevel(int $humidityMeasurement): array
    {
        $limits = config('sensor-data.limits.humidity');
        $temperatureHumidityGrades = $limits[0];
        foreach ($limits as $humidity => $temperatureLimits) {
            if ($humidityMeasurement < $humidity) {
                continue;
            }

            $temperatureHumidityGrades = $temperatureLimits;
        }

        return $temperatureHumidityGrades['temperature'];
    }

    private function getHumidityGradeByTemperature(int $temperatureMeasurement, array $humidityTemperatureGrades)
    {
        if ($temperatureMeasurement < array_key_first($humidityTemperatureGrades)) {
            return RiskLevel::CRITICAL->riskRating();
        }

        if ($temperatureMeasurement > array_key_last($humidityTemperatureGrades)) {
            return RiskLevel::CRITICAL->riskRating();
        }

        return $humidityTemperatureGrades[$temperatureMeasurement];
    }
}
