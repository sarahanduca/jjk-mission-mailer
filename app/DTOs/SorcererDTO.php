<?php
namespace App\DTOs;

class SorcererDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $username,
        public readonly string $sorcerer_grade,
        public readonly ?string $technique = null,
        public readonly ?string $affiliation = null,
        public readonly string $status = 'active',
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            username: $data['username'],
            sorcerer_grade: $data['sorcerer_grade'],
            technique: $data['technique'] ?? null,
            affiliation: $data['affiliation'] ?? null,
            status: $data['status'] ?? 'active',
        );
    }

    public function toArray(): array
    {
        return [
            'name'           => $this->name,
            'email'          => $this->email,
            'username'       => $this->username,
            'sorcerer_grade' => $this->sorcerer_grade,
            'technique'      => $this->technique,
            'affiliation'    => $this->affiliation,
            'status'         => $this->status,
        ];
    }
}
