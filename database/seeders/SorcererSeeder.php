<?php
namespace Database\Seeders;

use App\Models\Sorcerer;
use Illuminate\Database\Seeder;

class SorcererSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Famous sorcerers from JJK
        $famousSorcerers = [
            [
                'name'           => 'Satoru Gojo',
                'email'          => 'gojo@jujutsu-high.jp',
                'username'       => 'gojo_satoru',
                'sorcerer_grade' => 's',
                'technique'      => 'Limitless',
                'affiliation'    => 'Tokyo Jujutsu High',
                'status'         => 'active',
            ],
            [
                'name'           => 'Megumi Fushiguro',
                'email'          => 'fushiguro@jujutsu-high.jp',
                'username'       => 'megumi_f',
                'sorcerer_grade' => '2',
                'technique'      => 'Ten Shadows Technique',
                'affiliation'    => 'Tokyo Jujutsu High',
                'status'         => 'active',
            ],
            [
                'name'           => 'Yuji Itadori',
                'email'          => 'itadori@jujutsu-high.jp',
                'username'       => 'yuji_itadori',
                'sorcerer_grade' => '1',
                'technique'      => 'Divergent Fist',
                'affiliation'    => 'Tokyo Jujutsu High',
                'status'         => 'active',
            ],
            [
                'name'           => 'Nobara Kugisaki',
                'email'          => 'kugisaki@jujutsu-high.jp',
                'username'       => 'nobara_k',
                'sorcerer_grade' => '3',
                'technique'      => 'Straw Doll Technique',
                'affiliation'    => 'Tokyo Jujutsu High',
                'status'         => 'active',
            ],
            [
                'name'           => 'Kento Nanami',
                'email'          => 'nanami@jujutsu-sorcerer.jp',
                'username'       => 'nanami_kento',
                'sorcerer_grade' => '1',
                'technique'      => 'Ratio Technique',
                'affiliation'    => 'Independent',
                'status'         => 'dead',
            ],
            [
                'name'           => 'Maki Zenin',
                'email'          => 'maki@jujutsu-high.jp',
                'username'       => 'maki_zenin',
                'sorcerer_grade' => '4',
                'technique'      => 'Heavenly Restriction',
                'affiliation'    => 'Tokyo Jujutsu High',
                'status'         => 'active',
            ],
            [
                'name'           => 'Toge Inumaki',
                'email'          => 'inumaki@jujutsu-high.jp',
                'username'       => 'toge_inumaki',
                'sorcerer_grade' => '1',
                'technique'      => 'Cursed Speech',
                'affiliation'    => 'Tokyo Jujutsu High',
                'status'         => 'active',
            ],
            [
                'name'           => 'Yuta Okkotsu',
                'email'          => 'okkotsu@jujutsu-high.jp',
                'username'       => 'yuta_okkotsu',
                'sorcerer_grade' => 's',
                'technique'      => 'Copy',
                'affiliation'    => 'Tokyo Jujutsu High',
                'status'         => 'active',
            ],
            [
                'name'           => 'Aoi Todo',
                'email'          => 'todo@kyoto-jujutsu.jp',
                'username'       => 'aoi_todo',
                'sorcerer_grade' => '1',
                'technique'      => 'Boogie Woogie',
                'affiliation'    => 'Kyoto Jujutsu High',
                'status'         => 'active',
            ],
            [
                'name'           => 'Mai Zenin',
                'email'          => 'mai@kyoto-jujutsu.jp',
                'username'       => 'mai_zenin',
                'sorcerer_grade' => '3',
                'technique'      => 'Construction',
                'affiliation'    => 'Kyoto Jujutsu High',
                'status'         => 'dead',
            ],
        ];

        foreach ($famousSorcerers as $sorcerer) {
            Sorcerer::create($sorcerer);
        }

        // Create additional random sorcerers
        Sorcerer::factory(40)->create();
    }
}
