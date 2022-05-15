<?php

namespace App\Services;

use App\Models\Room;
use App\Repository\RoomSensorDataRepository;

class RiskLevelService
{
    private RoomSensorDataRepository $roomSensorDataRepository;
    private RiskCalculationService $riskCalculationService;

    public function __construct(RoomSensorDataRepository $roomSensorDataRepository, RiskCalculationService $riskCalculationService)
    {
        $this->roomSensorDataRepository = $roomSensorDataRepository;
        $this->riskCalculationService = $riskCalculationService;
    }

    public function getRoomRiskLevel(Room $room): string
    {
        $sensorInformationData = $this->roomSensorDataRepository->getRoomSensorData($room->code);
        $riskLevel = $this->riskCalculationService->calculateRiskLevel($sensorInformationData);
        return '';
    }
}
