<?php

namespace App\Enums;

enum BudgetTypeEnum: string
{
    case FIXED = 'fixed';
    case HOURLY = 'hourly';
      public static function getValues(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
