<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RiskLevelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'level' => $this->level,
            'timestamp' => $this->updated_at,
            'measurements' => json_decode($this->measurements),
        ];
    }
}
