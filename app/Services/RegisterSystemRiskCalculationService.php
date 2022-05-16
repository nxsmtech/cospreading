<?php

namespace App\Services;

use App\Enums\SensorType;
use App\Models\Room;
use App\Resources\Sensors\Sensor;

class RegisterSystemRiskCalculationService implements CalculatesRiskLevel
{
    public function calculateRiskLevel(Sensor $sensor): array
    {
        $room = Room::find($sensor->getRoomId());
        $roomAllowedAttendeeAmount = $room->allowed_attendee_count;
        $sensorMeasurements = $sensor->getMeasurements();

        $occupationPercentage = (int) round(($sensorMeasurements[0]->attendees / $roomAllowedAttendeeAmount) * 100);

        return [
            'type' => SensorType::REGISTER_SYSTEM,
            'riskLevel' => $this->getAttendeeRiskLevelGrade($occupationPercentage),
            'measurements' => $sensorMeasurements,
        ];
    }

    private function getAttendeeRiskLevelGrade(int $occupationPercentage): int
    {
        $limits = config('sensor-data.limits.attendees');

        $attendeeRiskGrades = $limits[0];
        foreach ($limits as $percentage => $riskGrade) {
            if ($occupationPercentage < $percentage) {
                continue;
            }

            $attendeeRiskGrades = $riskGrade;
        }

        return $attendeeRiskGrades;
    }
}
