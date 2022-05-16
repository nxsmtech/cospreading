<?php

namespace App\Services;

use App\Models\RiskLevel;
use App\Enums\RiskLevel as RiskLevelEnum;
use App\Models\Room;
use App\Repository\RoomSensorDataRepository;
use App\Resources\Sensors\CarbonDioxideSensor;
use App\Resources\Sensors\HumiditySensor;

class RiskLevelService
{
    private const RISK_CALCULATION_TYPES = [
        CarbonDioxideSensor::class => CarbonDioxideRiskCalculationService::class,
        HumiditySensor::class => HumidityRiskCalculationService::class,
    ];

    private RoomSensorDataRepository $roomSensorDataRepository;

    public function __construct(RoomSensorDataRepository $roomSensorDataRepository)
    {
        $this->roomSensorDataRepository = $roomSensorDataRepository;
    }

    public function updateRoomRiskLevel(Room $room): RiskLevel
    {
        $sensorInformationData = $this->roomSensorDataRepository->getRoomSensorData($room->code);
        $currentSensorRiskMeasurements = $this->calculateRiskLevel($sensorInformationData);
        $overallRiskRating = $this->calculateOverallRiskRating($currentSensorRiskMeasurements);

        return $this->updateRiskLevel(
            $room,
            $overallRiskRating,
            $this->transformRiskRatingToRiskLevel($currentSensorRiskMeasurements)
        );
    }

    private function calculateRiskLevel(array $sensorData): array
    {
        $sensorDataRiskArray = [];
        foreach ($sensorData as $sensor) {
            $dataCalculationServiceClass = self::RISK_CALCULATION_TYPES[get_class($sensor)];
            $sensorDataRiskArray[] = app($dataCalculationServiceClass)->calculateRiskLevel($sensor);
        }

        return $sensorDataRiskArray;
    }

    private function updateRiskLevel(Room $room, int $currentRiskRating, array $sensorMeasurements): RiskLevel
    {
        //TODO add risk level logging
        return RiskLevel::updateOrCreate(
            ['room_id' => $room->id],
            [
                'level' => RiskLevelEnum::RISK_LEVELS[$currentRiskRating]->level(),
                'measurements' => $sensorMeasurements,
            ],
        );
    }

    private function calculateOverallRiskRating(array $sensorDataMeasurementRisks): int
    {
        $sensorDataMeasurementRiskGrades = [];
        foreach ($sensorDataMeasurementRisks as $sensorDataMeasurementRisk) {
            $sensorDataMeasurementRiskGrades[] = $sensorDataMeasurementRisk['riskLevel'];
        }

        return max($sensorDataMeasurementRiskGrades);
    }

    private function transformRiskRatingToRiskLevel(array $sensorDataMeasurementRisks): array
    {
        foreach ($sensorDataMeasurementRisks as &$sensorDataMeasurementRisk) {
            $sensorDataMeasurementRisk['riskLevel'] =
                RiskLevelEnum::RISK_LEVELS[$sensorDataMeasurementRisk['riskLevel']]->level();
        }

        return $sensorDataMeasurementRisks;
    }
}
