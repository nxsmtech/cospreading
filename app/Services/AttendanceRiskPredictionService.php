<?php

namespace App\Services;

use App\Models\Event;

class AttendanceRiskPredictionService
{
    public function predictEventAttendanceRiskLevel(Event $event): int
    {
        $room = $event->room;
        return $this->calculateAttendanceRiskLevel($event->attendee_count, $room->allowed_attendee_count);
    }

    public function calculateAttendanceRiskLevel(int $attendance, int $allowedAmount): int
    {
        $occupancyPercentage = (int) round(($attendance / $allowedAmount) * 100);
        return $this->getAttendeeRiskLevelGrade($occupancyPercentage);
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
