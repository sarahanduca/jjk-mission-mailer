<?php
namespace Database\Seeders;

use App\Models\Curse;
use Illuminate\Database\Seeder;

class CurseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Famous curses from JJK
        $famousCurses = [
            [
                'name'             => 'Sukuna (Ryomen Sukuna)',
                'description'      => 'The King of Curses, an ancient and powerful cursed spirit with immense cursed energy.',
                'curse_level'      => 's',
                'curse_type'       => 'vengeful',
                'abilities'        => 'Domain Expansion: Malevolent Shrine, Cleave, Dismantle, Flame Arrow',
                'known_weaknesses' => 'Can be sealed through specific binding vows',
                'status'           => 'sealed',
                'first_sighted_at' => now()->subYears(1000),
            ],
            [
                'name'             => 'Mahito',
                'description'      => 'A cursed spirit born from human hatred and fear. Can manipulate souls.',
                'curse_level'      => 's',
                'curse_type'       => 'natural',
                'abilities'        => 'Idle Transfiguration, Domain Expansion: Self-Embodiment of Perfection',
                'known_weaknesses' => 'Vulnerable to attacks on the soul',
                'status'           => 'exorcised',
                'first_sighted_at' => now()->subMonths(8),
            ],
            [
                'name'             => 'Jogo',
                'description'      => 'Disaster curse born from fear of volcanic eruptions and fire.',
                'curse_level'      => 's',
                'curse_type'       => 'disaster',
                'abilities'        => 'Pyrokinesis, Domain Expansion: Coffin of the Iron Mountain',
                'known_weaknesses' => 'Overconfidence in combat',
                'status'           => 'exorcised',
                'first_sighted_at' => now()->subMonths(10),
            ],
            [
                'name'             => 'Hanami',
                'description'      => 'Disaster curse born from fear of land-based natural disasters.',
                'curse_level'      => 's',
                'curse_type'       => 'disaster',
                'abilities'        => 'Plant manipulation, Cursed Buds',
                'known_weaknesses' => 'Hearing-based attacks',
                'status'           => 'exorcised',
                'first_sighted_at' => now()->subMonths(9),
            ],
            [
                'name'             => 'Dagon',
                'description'      => 'Disaster curse born from fear of water-based natural disasters.',
                'curse_level'      => 's',
                'curse_type'       => 'disaster',
                'abilities'        => 'Domain Expansion: Horizon of the Captivating Skandha',
                'known_weaknesses' => 'Incomplete domain',
                'status'           => 'exorcised',
                'first_sighted_at' => now()->subMonths(6),
            ],
            [
                'name'             => 'Rika Orimoto (Queen of Curses)',
                'description'      => 'Extremely powerful cursed spirit born from a deceased human.',
                'curse_level'      => 's',
                'curse_type'       => 'vengeful',
                'abilities'        => 'Immense cursed energy, Copy technique support',
                'known_weaknesses' => 'Bound to Yuta Okkotsu',
                'status'           => 'contained',
                'first_sighted_at' => now()->subYears(2),
            ],
            [
                'name'             => 'Finger Bearer (Yasohachi Bridge)',
                'description'      => 'Cursed spirit born from Sukuna\'s finger.',
                'curse_level'      => 's',
                'curse_type'       => 'cursed_object',
                'abilities'        => 'Domain Expansion',
                'known_weaknesses' => 'Limited intelligence',
                'status'           => 'exorcised',
                'first_sighted_at' => now()->subMonths(12),
            ],
            [
                'name'             => 'Smallpox Deity',
                'description'      => 'Ancient curse related to disease and illness.',
                'curse_level'      => '1',
                'curse_type'       => 'natural',
                'abilities'        => 'Disease manipulation, Infection spread',
                'known_weaknesses' => 'Susceptible to purification techniques',
                'status'           => 'sealed',
                'first_sighted_at' => now()->subYears(5),
            ],
        ];

        foreach ($famousCurses as $curse) {
            Curse::create($curse);
        }

        // Create additional random curses
        Curse::factory(30)->create();
    }
}
