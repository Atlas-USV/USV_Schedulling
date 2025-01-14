<?php

namespace App\Shared;


enum ERoles: string
{
    case ADMIN = 'admin';
    case TEACHER = 'teacher';
    case STUDENT = 'student';
    case SECRETARY = 'secretary';

    public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}