<?php

namespace App\Enums;

use App\Traits\ArrayableEnum;

enum NewsApiCategoryEnum: string
{
    use ArrayableEnum;
    case Business = 'business';
    case Entertainment = 'entertainment';
    case Health = 'health';

    case Science = 'science';
    case Sports = 'sports';
    case Technology = 'technology';
    case World = 'general';
}
