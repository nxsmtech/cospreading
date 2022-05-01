<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoomCollection;
use App\Models\Room;

class RoomController extends Controller
{
    public function rooms()
    {
        return new RoomCollection(Room::all());
    }
}
