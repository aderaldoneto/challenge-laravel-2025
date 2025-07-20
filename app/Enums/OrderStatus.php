<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Initiated = 'initiated';
    case Confirmed = 'confirmed';
    case Sent = 'sent';
    case Delivered = 'delivered';

    public function label(): string
    {
        return match ($this) {
            self::Initiated => 'Initiated',
            self::Confirmed => 'Confirmado',
            self::Sent => 'Sent',
            self::Delivered => 'Delivered',
        };
    }

    public static function next(OrderStatus $current): ?OrderStatus
    {
        return match ($current) {
            self::Initiated => self::Confirmed,
            self::Confirmed => self::Sent,
            self::Sent => self::Delivered,
            self::Delivered => null,
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Initiated => 'gray',
            self::Confirmed => 'blue',
            self::Sent => 'Sent',
            self::Delivered => 'green',
        };
    }
}
