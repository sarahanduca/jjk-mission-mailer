<?php
namespace Database\Seeders;

use App\Models\Mission;
use App\Models\MissionAssignment;
use App\Models\Sorcerer;
use Illuminate\Database\Seeder;

class MissionAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some missions and sorcerers
        $missions  = Mission::whereIn('status', ['exorcised', 'sealed', 'contained'])->get();
        $sorcerers = Sorcerer::where('status', 'active')->limit(20)->get();

        // Assign each mission to 1-3 sorcerers
        foreach ($missions as $mission) {
            $numSorcerers      = rand(1, 3);
            $selectedSorcerers = $sorcerers->random(min($numSorcerers, $sorcerers->count()));

            foreach ($selectedSorcerers as $sorcerer) {
                if ($mission->status === 'exorcised') {
                    MissionAssignment::factory()
                        ->completed()
                        ->create([
                            'mission_id'  => $mission->id,
                            'sorcerer_id' => $sorcerer->id,
                        ]);
                } elseif ($mission->status === 'sealed' || $mission->status === 'contained') {
                    MissionAssignment::factory()->create([
                        'mission_id'    => $mission->id,
                        'sorcerer_id'   => $sorcerer->id,
                        'assigned_at'   => now()->subDays(rand(1, 10)),
                        'started_at'    => now()->subDays(rand(1, 5)),
                        'completed_at'  => null,
                        'result_status' => null,
                    ]);
                } else { // at_large
                    MissionAssignment::factory()
                        ->pending()
                        ->create([
                            'mission_id'  => $mission->id,
                            'sorcerer_id' => $sorcerer->id,
                            'assigned_at' => now()->subDays(rand(1, 7)),
                        ]);
                }
            }
        }

        // Create some additional random assignments
        MissionAssignment::factory(30)->create();
    }
}
