<?php
namespace Database\Factories;

use App\Models\Sorcerer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sorcerer>
 */
class SorcererFactory extends Factory
{
    protected $model = Sorcerer::class;

    public function definition(): array
    {
        $grades       = ['1', '2', '3', '4', 's'];
        $affiliations = ['Tokyo Jujutsu High', 'Kyoto Jujutsu High', 'Independent', 'Jujutsu Society'];
        $techniques   = [
            'Limitless',
            'Ten Shadows Technique',
            'Cursed Speech',
            'Construction',
            'Boogie Woogie',
            'Straw Doll Technique',
            'Projection Sorcery',
            'Blood Manipulation',
            'Ratio Technique',
            'Sky Manipulation',
        ];

        return [
            'name'           => fake()->name(),
            'email'          => fake()->unique()->safeEmail(),
            'username'       => fake()->unique()->userName(),
            'sorcerer_grade' => fake()->randomElement($grades),
            'technique'      => fake()->randomElement($techniques),
            'affiliation'    => fake()->randomElement($affiliations),
            'status'         => fake()->randomElement(['active', 'dead', 'injured', 'OOR']),
        ];
    }

    public function active(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'active',
        ]);
    }

    public function specialGrade(): static
    {
        return $this->state(fn(array $attributes) => [
            'sorcerer_grade' => 's',
        ]);
    }
}
