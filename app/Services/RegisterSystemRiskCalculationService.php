<?php

namespace App\Services;

use App\Enums\SensorType;
use App\Models\Room;
use App\Resources\Sensors\Sensor;

class RegisterSystemRiskCalculationService implements CalculatesRiskLevel
{
    private AttendanceRiskPredictionService $attendanceRiskPredictionService;

    public function __construct(AttendanceRiskPredictionService $attendanceRiskPredictionService)
    {
        $this->attendanceRiskPredictionService = $attendanceRiskPredictionService;
    }

    public function calculateRiskLevel(Sensor $sensor): array
    {
        $room = Room::find($sensor->getRoomId());
        $roomAllowedAttendeeAmount = $room->allowed_attendee_count;
        $sensorMeasurements = $sensor->getMeasurements();

        return [
            'type' => SensorType::REGISTER_SYSTEM,
            'riskLevel' => $this->attendanceRiskPredictionService->calculateAttendanceRiskLevel(
                $sensorMeasurements[0]->attendees,
                $roomAllowedAttendeeAmount,
            ),
            'measurements' => $sensorMeasurements,
        ];
    }
}
