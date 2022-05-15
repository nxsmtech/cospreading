<?php

namespace Database\Seeders;

use App\Models\RiskLevel;
use Illuminate\Database\Seeder;

class RiskLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        RiskLevel::factory()->count(5)->create();
    }
}
