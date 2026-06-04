<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case STYLIST = 'stylist';
    case CLIENT = 'client';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrator',
            self::STYLIST => 'Stylist / Professional',
            self::CLIENT => 'Client',
        };
    }
}
