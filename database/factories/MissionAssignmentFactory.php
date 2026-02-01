<?php
namespace Database\Factories;

use App\Models\Mission;
use App\Models\MissionAssignment;
use App\Models\Sorcerer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MissionAssignment>
 */
class MissionAssignmentFactory extends Factory
{
    protected $model = MissionAssignment::class;

    public function definition(): array
    {
        $assignedAt  = fake()->dateTimeBetween('-30 days', 'now');
        $startedAt   = fake()->optional(0.7)->dateTimeBetween($assignedAt, 'now');
        $completedAt = $startedAt ? fake()->optional(0.5)->dateTimeBetween($startedAt, 'now') : null;

        $resultStatuses = ['success', 'partial_success', 'failure', 'aborted'];

        return [
            'mission_id'     => Mission::factory(),
            'sorcerer_id'    => Sorcerer::factory(),
            'assigned_at'    => $assignedAt,
            'started_at'     => $startedAt,
            'completed_at'   => $completedAt,
            'result_status'  => $completedAt ? fake()->randomElement($resultStatuses) : null,
            'casualties'     => $completedAt ? fake()->numberBetween(0, 5) : 0,
            'mission_report' => $completedAt ? fake()->paragraph(4) : null,
        ];
    }

    public function completed(): static
    {
        return $this->state(function (array $attributes) {
            $assignedAt  = fake()->dateTimeBetween('-30 days', '-10 days');
            $startedAt   = fake()->dateTimeBetween($assignedAt, '-9 days');
            $completedAt = fake()->dateTimeBetween($startedAt, '-1 days');

            return [
                'assigned_at'    => $assignedAt,
                'started_at'     => $startedAt,
                'completed_at'   => $completedAt,
                'result_status'  => fake()->randomElement(['success', 'partial_success', 'failure']),
                'casualties'     => fake()->numberBetween(0, 3),
                'mission_report' => fake()->paragraph(4),
            ];
        });
    }

    public function pending(): static
    {
        return $this->state(fn(array $attributes) => [
            'started_at'     => null,
            'completed_at'   => null,
            'result_status'  => null,
            'casualties'     => 0,
            'mission_report' => null,
        ]);
    }
}
