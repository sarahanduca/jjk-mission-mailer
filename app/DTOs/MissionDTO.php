<?php
namespace App\DTOs;

use DateTimeInterface;

class MissionDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly string $required_sorcerer_grade,
        public readonly string $curse_level,
        public readonly string $category,
        public readonly string $location,
        public readonly string $urgency_level = 'medium',
        public readonly string $status = 'at_large',
        public readonly ?DateTimeInterface $deadline = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            description: $data['description'],
            required_sorcerer_grade: $data['required_sorcerer_grade'],
            curse_level: $data['curse_level'],
            category: $data['category'],
            location: $data['location'],
            urgency_level: $data['urgency_level'] ?? 'medium',
            status: $data['status'] ?? 'at_large',
            deadline: isset($data['deadline']) ? new \DateTime($data['deadline']) : null,
        );
    }

    public function toArray(): array
    {
        return [
            'title'                   => $this->title,
            'description'             => $this->description,
            'required_sorcerer_grade' => $this->required_sorcerer_grade,
            'curse_level'             => $this->curse_level,
            'category'                => $this->category,
            'location'                => $this->location,
            'urgency_level'           => $this->urgency_level,
            'status'                  => $this->status,
            'deadline'                => $this->deadline?->format('Y-m-d H:i:s'),
        ];
    }
}
