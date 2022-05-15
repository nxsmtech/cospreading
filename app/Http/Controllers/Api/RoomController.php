<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomResource;
use App\Http\Resources\RoomResourceCollection;
use App\Models\Room;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RoomController extends Controller
{
    public function allRoomRiskLevel(): ResourceCollection
    {
        return new RoomResourceCollection(Room::get());
    }

    public function roomRiskLevel(Room $room): RoomResource
    {
        return new RoomResource($room);
    }
}
