<?php


namespace App\Shared;

enum EvaluationTypes: string
{
    case EXAM = 'exam';
    case RETAKE = 'retake';
    case COLLOQUIUM = 'colloquium';
    case PROJECT = 'project';
    case REEXAMINATION = 'reexamination';


    public function getColor(): string
    {
        return match ($this) {
            self::EXAM => '#7E3AF2',         // Color for exam
            self::RETAKE => '#C27803',       // Color for retake
            self::COLLOQUIUM => '#0E9F6E',   // Color for colloquium
            self::PROJECT => '#1C64F2',      // Color for project
            self::REEXAMINATION => '#D61F69',// Color for reexamination
        };
    }

    public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
    
    public static function getLocalizedArray(): array
    {
        return [
            self::EXAM->value => 'Examen',
            self::RETAKE->value => 'Restanță',
            self::COLLOQUIUM->value => 'Colocviu',
            self::PROJECT->value => 'Proiect',
            self::REEXAMINATION->value => 'Reexaminare',
        ];
    }
}