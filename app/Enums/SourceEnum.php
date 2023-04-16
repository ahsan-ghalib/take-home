<?php

namespace App\Enums;

use App\Traits\ArrayableEnum;

enum SourceEnum: string
{
    use ArrayableEnum;
    case The_Guardian = 'The Guardian';
    case News_Api = 'News API';
    case New_York_Times = 'New York Times';

}
