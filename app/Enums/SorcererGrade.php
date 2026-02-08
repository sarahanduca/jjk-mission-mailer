<?php
namespace App\Enums;

enum SorcererGrade: string {
    case GRADE_4       = 'grade-4';
    case GRADE_3       = 'grade-3';
    case GRADE_2       = 'grade-2';
    case SEMI_GRADE_1  = 'semi-grade-1';
    case GRADE_1       = 'grade-1';
    case SPECIAL_GRADE = 'special-grade';

    public function value(): int
    {
        return match ($this) {
            self::GRADE_4       => 1,
            self::GRADE_3       => 2,
            self::GRADE_2       => 3,
            self::SEMI_GRADE_1  => 4,
            self::GRADE_1       => 5,
            self::SPECIAL_GRADE => 6,
        };
    }

    public static function fromString(?string $grade): ?self
    {
        if (! $grade) {
            return null;
        }

        return self::tryFrom(strtolower($grade));
    }

    public static function getValue(?string $grade): int
    {
        $enum = self::fromString($grade);
        return $enum?->value() ?? 1;
    }

    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }
}
