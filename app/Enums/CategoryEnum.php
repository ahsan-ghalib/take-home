<?php

namespace App\Enums;

use App\Traits\ArrayableEnum;

enum CategoryEnum: string
{
    use ArrayableEnum;
    case Business = 'Business';
    case Entertainment = 'Entertainment';
    case Health = 'Health';
    case Politics = 'Politics';
    case Science = 'Science';
    case Sports = 'Sports';
    case Technology = 'Technology';
    case World = 'World';
    case News = 'News';
    case Sport = 'Sport';
    case Culture = 'Culture';
    case Lifestyle = 'Lifestyle';
    case Opinion = 'Opinion';
    case Environment = 'Environment';
}
