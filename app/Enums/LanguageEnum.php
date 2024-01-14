<?php

namespace App\Enums;

use App\Enums\Traits\EnumToArray;

enum LanguageEnum: string
{
    use EnumToArray;

    case EN = 'en';
    case SR_LATIN = 'sr_Latin';

}
