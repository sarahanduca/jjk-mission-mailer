<?php
namespace Database\Factories;

use App\Models\Curse;
use App\Models\Mission;
use App\Models\MissionCurse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MissionCurse>
 */
class MissionCurseFactory extends Factory
{
    protected $model = MissionCurse::class;

    public function definition(): array
    {
        return [
            'mission_id'        => Mission::factory(),
            'curse_id'          => Curse::factory(),
            'is_primary_target' => fake()->boolean(70), // 70% chance of being primary target
        ];
    }

    public function primaryTarget(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_primary_target' => true,
        ]);
    }

    public function secondaryTarget(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_primary_target' => false,
        ]);
    }
}
