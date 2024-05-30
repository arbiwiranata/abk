<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum StatusPegawai: string implements HasColor, HasLabel
{
    case Cpns = 'cpns';

    case Pns = 'pns';

    case Pppk = 'pppk';

    case NonAsn = 'non asn';

    public function getLabel(): string
    {
        return match ($this) {
            self::Cpns => 'CPNS',
            self::Pns => 'PNS',
            self::Pppk => 'PPPK',
            self::NonAsn => 'Non ASN',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Cpns => 'info',
            self::Pns => 'success',
            self::Pppk => 'warning',
            self::NonAsn => 'danger',
        };
    }
}