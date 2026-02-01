<?php
namespace App\DTOs;

use DateTimeInterface;

class MissionAssignmentDTO
{
    public function __construct(
        public readonly int $mission_id,
        public readonly int $sorcerer_id,
        public readonly ?DateTimeInterface $assigned_at = null,
        public readonly ?DateTimeInterface $started_at = null,
        public readonly ?DateTimeInterface $completed_at = null,
        public readonly ?string $result_status = null,
        public readonly ?int $casualties = 0,
        public readonly ?string $mission_report = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            mission_id: $data['mission_id'],
            sorcerer_id: $data['sorcerer_id'],
            assigned_at: isset($data['assigned_at']) ? new \DateTime($data['assigned_at']) : null,
            started_at: isset($data['started_at']) ? new \DateTime($data['started_at']) : null,
            completed_at: isset($data['completed_at']) ? new \DateTime($data['completed_at']) : null,
            result_status: $data['result_status'] ?? null,
            casualties: $data['casualties'] ?? 0,
            mission_report: $data['mission_report'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'mission_id'     => $this->mission_id,
            'sorcerer_id'    => $this->sorcerer_id,
            'assigned_at'    => $this->assigned_at?->format('Y-m-d H:i:s'),
            'started_at'     => $this->started_at?->format('Y-m-d H:i:s'),
            'completed_at'   => $this->completed_at?->format('Y-m-d H:i:s'),
            'result_status'  => $this->result_status,
            'casualties'     => $this->casualties,
            'mission_report' => $this->mission_report,
        ];
    }
}
