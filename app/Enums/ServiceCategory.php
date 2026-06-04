<?php

namespace App\Enums;

enum ServiceCategory: string
{
    case HAIR = 'hair';
    case NAILS = 'nails';
    case SKIN = 'skin';
    case BROWS = 'brows';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::HAIR => 'Hair Styling & Treatments',
            self::NAILS => 'Nail Art & Care',
            self::SKIN => 'Skin & Facials',
            self::BROWS => 'Brows & Lashes',
            self::OTHER => 'Other Services',
        };
    }
}
