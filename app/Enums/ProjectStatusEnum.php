<?php
namespace App\Enums;

enum ProjectStatusEnum: string
{
    case OPEN = 'open';
    case IN_PROGRESS = 'in_progress';
    case CLOSED = 'closed';
      public static function getValues(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
