<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RiskLevelResource;
use App\Models\RiskLevel;
use Illuminate\Http\Resources\Json\JsonResource;

class RiskApiController extends Controller
{
    public function currentRiskLevel(): JsonResource
    {
        return new RiskLevelResource(RiskLevel::first());
    }
}
