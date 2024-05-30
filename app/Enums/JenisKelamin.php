<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum JenisKelamin: string implements HasColor, HasLabel
{
    case L = 'L';

    case P = 'P';

    public function getLabel(): string
    {
        return match ($this) {
            self::L => 'Laki-Laki',
            self::P => 'Perempuan',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::L => 'info',
            self::P => 'primary',
        };
    }
}