<?php

namespace App\Enums;

enum TaskStatusEnum: string
{
    case TODO        = 'todo';
    case IN_PROGRESS = 'in_progress';
    case REVIEW      = 'review';
    case DONE        = 'done';
    case BLOCKED     = 'blocked';

    public function label(): string
    {
        return match ($this) {
            self::TODO        => 'To Do',
            self::IN_PROGRESS => 'In Progress',
            self::REVIEW      => 'In Review',
            self::DONE        => 'Done',
            self::BLOCKED     => 'Blocked',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
