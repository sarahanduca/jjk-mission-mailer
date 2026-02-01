<?php
namespace Database\Factories;

use App\Models\Mission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mission>
 */
class MissionFactory extends Factory
{
    protected $model = Mission::class;

    public function definition(): array
    {
        $grades        = ['1', '2', '3', '4', 's'];
        $curseLevels   = ['1', '2', '3', '4', 's'];
        $categories    = ['exorcism', 'investigation', 'rescue', 'escort'];
        $urgencyLevels = ['low', 'medium', 'high', 'critical'];
        $statuses      = ['at_large', 'exorcised', 'sealed', 'contained'];

        $locations = [
            'Shibuya District, Tokyo',
            'Kyoto Prefecture',
            'Sendai City',
            'Yokohama Port',
            'Osaka Castle Ruins',
            'Tokyo Jujutsu High',
        ];

        return [
            'title'                   => fake()->randomElement([
                'Cursed Spirit Investigation',
                'Domain Exorcism Mission',
                'Civilian Protection Detail',
                'Cursed Object Retrieval',
                'Special Grade Threat Assessment',
                'Curse User Apprehension',
            ]) . ' - ' . fake()->city(),
            'description'             => fake()->paragraph(3),
            'required_sorcerer_grade' => fake()->randomElement($grades),
            'curse_level'             => fake()->randomElement($curseLevels),
            'category'                => fake()->randomElement($categories),
            'location'                => fake()->randomElement($locations),
            'urgency_level'           => fake()->randomElement($urgencyLevels),
            'status'                  => fake()->randomElement($statuses),
            'deadline'                => fake()->dateTimeBetween('now', '+30 days'),
        ];
    }

    public function available(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'at_large',
        ]);
    }

    public function critical(): static
    {
        return $this->state(fn(array $attributes) => [
            'urgency_level' => 'critical',
        ]);
    }

    public function specialGrade(): static
    {
        return $this->state(fn(array $attributes) => [
            'curse_level'             => 's',
            'required_sorcerer_grade' => 's',
        ]);
    }
}
