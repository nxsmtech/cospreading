<?php

namespace App\DataProviders\Mockoon;

use App\DataProviders\Contracts\ProvidesSensorData;
use App\Enums\SensorType;
use App\Models\Room;
use App\Resources\Sensors\Sensor;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

class MockoonSensorDataProvider implements ProvidesSensorData
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getRoomSensorData(string $roomCode): array
    {
        try {
            $roomSensorDataResponse = $this->client->get('http://host.docker.internal:3001/room');
        } catch (BadResponseException $exception) {
            throw new BadResponseException(
                $exception->getMessage(),
                $exception->getRequest(),
                $exception->getResponse(),
            );
        }

        $roomSensorData = json_decode($roomSensorDataResponse->getBody());

        $roomSensorDataArray = [];
        foreach ($roomSensorData->data as $sensorData)
        {
            $roomSensorDataArray[] = $this->transformSensorDataToResource($sensorData);
        }

        return $roomSensorDataArray;
    }

    private function transformSensorDataToResource(object $sensorData): Sensor
    {
        $room = Room::where('code', '=', $sensorData->roomCode)->first();
        $sensorClass = SensorType::from($sensorData->sensorType)->typeClass();

        return new $sensorClass(
            $sensorData->sensorId,
            $sensorData->sensorType,
            $room->id ?? 0,
            $sensorData->measurements,
        );
    }
}
