<?php

namespace App\Enums;
enum AvailabilityStatusEnum: string
{
    case AVAILABLE = 'available';
    case BUSY = 'busy';
    case UNAVAILABLE = 'unavailable';
      public static function getValues(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}






