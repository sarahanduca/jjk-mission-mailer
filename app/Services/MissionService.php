<?php
namespace App\Services;

use App\Enums\SorcererGrade;
use App\Jobs\SendAssignMissionMail;
use App\Models\Curse;
use App\Models\Mission;
use App\Models\MissionAssignment;
use App\Models\MissionCurse;
use App\Models\Sorcerer;
use Illuminate\Support\Facades\DB;

class MissionService
{
    public function generateMission(array $params): Mission
    {
        return DB::transaction(function () use ($params) {
            $curseLevel = $params['curse_level'] ?? null;
            $curse      = null;

            if (isset($params['curse_id'])) {
                $curse = Curse::find($params['curse_id']);
                if ($curse && ! $curseLevel) {
                    $curseLevel = $curse->curse_level;
                }
            }

            $requiredGrade = $params['sorcerer_grade'] ?? $curseLevel ?? 'grade-4';

            $title = $params['title'] ?? $this->generateMissionTitle($curse, $curseLevel);

            $mission = Mission::create([
                'title'                   => $title,
                'description'             => $params['description'] ?? $this->generateMissionDescription($curse),
                'required_sorcerer_grade' => $requiredGrade,
                'curse_level'             => $curseLevel,
                'category'                => $params['category'] ?? 'exorcism',
                'location'                => $params['location'] ?? null,
                'urgency_level'           => $params['urgency_level'] ?? 'medium',
                'status'                  => 'available',
                'deadline'                => $params['deadline'] ?? now()->addDays(7),
            ]);

            if ($curse) {
                MissionCurse::create([
                    'mission_id'        => $mission->id,
                    'curse_id'          => $curse->id,
                    'is_primary_target' => true,
                ]);
            }

            if (isset($params['sorcerer_id'])) {
                $sorcerer = Sorcerer::find($params['sorcerer_id']);
                if ($sorcerer && $this->canSorcererHandleMission($sorcerer, $mission)) {
                    $this->assignSorcererToMission($mission, $sorcerer);
                }
            }

            return $mission->fresh(['curses', 'assignments.sorcerer']);
        });
    }

    public function sendMissionEmails(int $missionId): array
    {
        $mission = Mission::with(['assignments.sorcerer', 'curses'])->findOrFail($missionId);

        if ($mission->assignments->isEmpty()) {
            return [
                'success' => false,
                'message' => 'No sorcerers assigned to this mission',
                'mission' => $mission,
            ];
        }

        $notifiedSorcerers = [];

        foreach ($mission->assignments as $assignment) {
            if ($assignment->sorcerer) {
                SendAssignMissionMail::dispatch($mission, $assignment->sorcerer);
                $notifiedSorcerers[] = $assignment->sorcerer;
            }
        }

        return [
            'success'            => true,
            'message'            => count($notifiedSorcerers) . ' email(s) sent',
            'mission'            => $mission,
            'notified_sorcerers' => $notifiedSorcerers,
        ];
    }

    protected function findSuitableSorcerers(Mission $mission): \Illuminate\Support\Collection
    {
        $requiredGradeValue = $this->getGradeValue($mission->required_sorcerer_grade ?? $mission->curse_level);

        $singleSorcerer = Sorcerer::where('status', 'active')
            ->whereDoesntHave('missionAssignments', function ($query) {
                $query->whereNull('completed_at')
                    ->whereIn('result_status', ['pending', 'in_progress']);
            })
            ->get()
            ->filter(function ($sorcerer) use ($requiredGradeValue) {
                return $this->getGradeValue($sorcerer->sorcerer_grade) >= $requiredGradeValue;
            })
            ->first();

        if ($singleSorcerer) {
            return collect([$singleSorcerer]);
        }

        return $this->findSorcererPair($requiredGradeValue);
    }

    protected function findSorcererPair(int $requiredGradeValue): \Illuminate\Support\Collection
    {
        $availableSorcerers = Sorcerer::where('status', 'active')
            ->whereDoesntHave('missionAssignments', function ($query) {
                $query->whereNull('completed_at')
                    ->whereIn('result_status', ['pending', 'in_progress']);
            })
            ->get()
            ->sortByDesc(function ($sorcerer) {
                return $this->getGradeValue($sorcerer->sorcerer_grade);
            });

        foreach ($availableSorcerers as $i => $sorcerer1) {
            foreach ($availableSorcerers->slice($i + 1) as $sorcerer2) {
                $combinedValue = $this->getGradeValue($sorcerer1->sorcerer_grade)
                 + $this->getGradeValue($sorcerer2->sorcerer_grade);

                if ($combinedValue >= $requiredGradeValue) {
                    return collect([$sorcerer1, $sorcerer2]);
                }
            }
        }

        return collect();
    }

    protected function canSorcererHandleMission(Sorcerer $sorcerer, Mission $mission): bool
    {
        $sorcererGradeValue = SorcererGrade::getValue($sorcerer->sorcerer_grade);
        $requiredGradeValue = SorcererGrade::getValue($mission->required_sorcerer_grade ?? $mission->curse_level);

        return $sorcererGradeValue >= $requiredGradeValue;
    }

    protected function getGradeValue(?string $grade): int
    {
        return SorcererGrade::getValue($grade);
    }

    protected function assignSorcererToMission(Mission $mission, Sorcerer $sorcerer): MissionAssignment
    {
        return MissionAssignment::create([
            'mission_id'    => $mission->id,
            'sorcerer_id'   => $sorcerer->id,
            'assigned_at'   => now(),
            'result_status' => null,
        ]);
    }

    protected function generateMissionTitle(?Curse $curse, ?string $curseLevel): string
    {
        if ($curse) {
            return "Exorcise: {$curse->name}";
        }

        $levelLabel = ucfirst(str_replace('-', ' ', $curseLevel ?? 'Unknown'));
        return "{$levelLabel} Curse Exorcism Mission";
    }

    protected function generateMissionDescription(?Curse $curse): string
    {
        if ($curse) {
            return "Mission to exorcise {$curse->name}. " . ($curse->description ?? 'Exercise extreme caution.');
        }

        return 'Curse exorcism mission. Details to be provided upon acceptance.';
    }

    public function getUnassignedMissions(): \Illuminate\Database\Eloquent\Collection
    {
        return Mission::where('status', 'available')
            ->whereDoesntHave('assignments')
            ->with('curses')
            ->get();
    }
}
