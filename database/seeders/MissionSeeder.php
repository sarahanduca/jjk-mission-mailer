<?php
namespace Database\Seeders;

use App\Models\Mission;
use Illuminate\Database\Seeder;

class MissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some specific missions
        $specificMissions = [
            [
                'title'                   => 'Shibuya Incident Investigation',
                'description'             => 'Investigate the aftermath of the Shibuya Incident and assess remaining cursed energy levels in the area.',
                'required_sorcerer_grade' => 's',
                'curse_level'             => 's',
                'category'                => 'investigation',
                'location'                => 'Shibuya District, Tokyo',
                'urgency_level'           => 'critical',
                'status'                  => 'exorcised',
                'deadline'                => now()->subDays(30),
            ],
            [
                'title'                   => 'Cursed Womb Exorcism - Eishu Detention Center',
                'description'             => 'Exorcise cursed womb detected at juvenile detention center. High risk of special grade manifestation.',
                'required_sorcerer_grade' => '2',
                'curse_level'             => '2',
                'category'                => 'exorcism',
                'location'                => 'Eishu Juvenile Detention Center',
                'urgency_level'           => 'high',
                'status'                  => 'exorcised',
                'deadline'                => now()->subDays(90),
            ],
            [
                'title'                   => 'Cursed Object Retrieval - Sukuna Finger',
                'description'             => 'Retrieve and secure one of Sukuna\'s fingers before curse users can obtain it.',
                'required_sorcerer_grade' => '1',
                'curse_level'             => 's',
                'category'                => 'investigation',
                'location'                => 'Sendai City',
                'urgency_level'           => 'critical',
                'status'                  => 'at_large',
                'deadline'                => now()->addDays(7),
            ],
            [
                'title'                   => 'Exchange Event Security Detail',
                'description'             => 'Provide security for the annual Goodwill Event between Tokyo and Kyoto schools.',
                'required_sorcerer_grade' => '1',
                'curse_level'             => '3',
                'category'                => 'escort',
                'location'                => 'Tokyo Jujutsu High',
                'urgency_level'           => 'low',
                'status'                  => 'at_large',
                'deadline'                => now()->addDays(14),
            ],
            [
                'title'                   => 'Cursed Spirit Outbreak - Yokohama Port',
                'description'             => 'Multiple Grade 2 cursed spirits detected near shipping containers. Possible cursed object contamination.',
                'required_sorcerer_grade' => '2',
                'curse_level'             => '2',
                'category'                => 'exorcism',
                'location'                => 'Yokohama Port',
                'urgency_level'           => 'high',
                'status'                  => 'at_large',
                'deadline'                => now()->addDays(3),
            ],
        ];

        foreach ($specificMissions as $mission) {
            Mission::create($mission);
        }

        // Create additional random missions
        Mission::factory(45)->create();
    }
}
