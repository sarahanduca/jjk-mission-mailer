<?php
namespace Database\Seeders;

use App\Models\Curse;
use App\Models\Mission;
use App\Models\MissionCurse;
use Illuminate\Database\Seeder;

class MissionCurseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $missions = Mission::all();
        $curses   = Curse::all();

        // Assign curses to missions
        foreach ($missions as $mission) {
            // Each mission has 1-4 curses
            $numCurses      = rand(1, 4);
            $selectedCurses = $curses->random(min($numCurses, $curses->count()));

            $isPrimaryAssigned = false;

            foreach ($selectedCurses as $index => $curse) {
                // First curse is always primary, others have 30% chance
                $isPrimary = ! $isPrimaryAssigned && ($index === 0 || rand(1, 100) <= 30);

                MissionCurse::create([
                    'mission_id'        => $mission->id,
                    'curse_id'          => $curse->id,
                    'is_primary_target' => $isPrimary,
                ]);

                if ($isPrimary) {
                    $isPrimaryAssigned = true;
                }
            }
        }
    }
}
