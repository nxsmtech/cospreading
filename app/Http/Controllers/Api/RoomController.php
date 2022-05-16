<?php

namespace App\Http\Controllers\Api;

use App\Enums\RiskLevel;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Http\Resources\RoomEventResourceCollection;
use App\Http\Resources\RoomResource;
use App\Http\Resources\RoomRiskResourceCollection;
use App\Http\Resources\RoomRiskResource;
use App\Models\Event;
use App\Models\Room;
use App\Services\AttendanceRiskPredictionService;
use Illuminate\Http\JsonResponse;

class RoomController extends Controller
{
    public function allRoomRiskLevel(): RoomRiskResourceCollection
    {
        return new RoomRiskResourceCollection(Room::get());
    }

    public function roomRiskLevel(Room $room): RoomRiskResource
    {
        return new RoomRiskResource($room);
    }

    public function roomEvents(Room $room): RoomEventResourceCollection
    {
        return new RoomEventResourceCollection($room->events);
    }

    public function roomEventRiskLevel(Room $room, Event $event): JsonResponse
    {
        $riskLevelPrediction = app(AttendanceRiskPredictionService::class)->predictEventAttendanceRiskLevel($event);
        return response()->json([
            'riskLevel' => RiskLevel::RISK_LEVELS[$riskLevelPrediction]->level(),
            'room' => new RoomResource($room),
            'event' => new EventResource($event),
        ]);
    }
}
