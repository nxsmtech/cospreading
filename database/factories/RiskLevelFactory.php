<?php

namespace Database\Factories;

use App\Enums\RiskLevel;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RiskLevel>
 */
class RiskLevelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'level' => $this->faker->randomElement(RiskLevel::RISK_LEVELS)->level(),
            'room' => Room::factory(),
        ];
    }
}
