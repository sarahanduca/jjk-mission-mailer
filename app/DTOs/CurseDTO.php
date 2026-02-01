<?php
namespace App\DTOs;

use DateTimeInterface;

class CurseDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly string $curse_level,
        public readonly string $curse_type,
        public readonly ?string $abilities = null,
        public readonly ?string $known_weaknesses = null,
        public readonly string $status = 'at_large',
        public readonly ?DateTimeInterface $first_sighted_at = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            description: $data['description'],
            curse_level: $data['curse_level'],
            curse_type: $data['curse_type'],
            abilities: $data['abilities'] ?? null,
            known_weaknesses: $data['known_weaknesses'] ?? null,
            status: $data['status'] ?? 'at_large',
            first_sighted_at: isset($data['first_sighted_at']) ? new \DateTime($data['first_sighted_at']) : null,
        );
    }

    public function toArray(): array
    {
        return [
            'name'             => $this->name,
            'description'      => $this->description,
            'curse_level'      => $this->curse_level,
            'curse_type'       => $this->curse_type,
            'abilities'        => $this->abilities,
            'known_weaknesses' => $this->known_weaknesses,
            'status'           => $this->status,
            'first_sighted_at' => $this->first_sighted_at?->format('Y-m-d H:i:s'),
        ];
    }
}
