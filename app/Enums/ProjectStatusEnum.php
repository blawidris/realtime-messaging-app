<?php

namespace App\Enums;

enum ProjectStatusEnum: string
{
    case PLANNED   = 'planned';
    case ACTIVE    = 'active';
    case PAUSED    = 'paused';
    case COMPLETED = 'completed';
    case ARCHIVED  = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::PLANNED   => 'Planned',
            self::ACTIVE    => 'Active',
            self::PAUSED    => 'Paused',
            self::COMPLETED => 'Completed',
            self::ARCHIVED  => 'Archived',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
