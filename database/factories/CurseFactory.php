<?php
namespace Database\Factories;

use App\Models\Curse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Curse>
 */
class CurseFactory extends Factory
{
    protected $model = Curse::class;

    public function definition(): array
    {
        $curseLevels = ['1', '2', '3', '4', 's'];
        $curseTypes  = ['vengeful', 'natural', 'cursed_object', 'disaster'];
        $statuses    = ['at_large', 'exorcised', 'sealed', 'contained'];

        $curseNames = [
            'Finger Bearer',
            'Rainbow Dragon',
            'Grasshopper Curse',
            'Smallpox Deity',
            'Roppongi Curse',
            'Cursed Womb',
            'Ocean Wave Curse',
            'Forest Spirit',
        ];

        return [
            'name'             => fake()->randomElement($curseNames) . ' (' . fake()->unique()->numerify('CS-####') . ')',
            'description'      => fake()->paragraph(2),
            'curse_level'      => fake()->randomElement($curseLevels),
            'curse_type'       => fake()->randomElement($curseTypes),
            'abilities'        => fake()->sentences(3, true),
            'known_weaknesses' => fake()->optional()->sentences(2, true),
            'status'           => fake()->randomElement($statuses),
            'first_sighted_at' => fake()->dateTimeBetween('-2 years', 'now'),
        ];
    }

    public function atLarge(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'at_large',
        ]);
    }

    public function specialGrade(): static
    {
        return $this->state(fn(array $attributes) => [
            'curse_level' => 's',
        ]);
    }

    public function exorcised(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'exorcised',
        ]);
    }
}
