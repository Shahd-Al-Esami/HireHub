<?php
namespace App\Enums;

enum OfferStatusEnum: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';

     public static function getValues(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
