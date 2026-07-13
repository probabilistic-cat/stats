<?php

declare(strict_types=1);

namespace App\Enum;

enum Color: string
{
    case SYSTEM_BLUE = '#70d7ff';
    case SYSTEM_GRAY = '#aeaeb2';
    case SYSTEM_GREEN = '#30db5b';
    case SYSTEM_INDIGO = '#7d7aff';
    case SYSTEM_MINT = '#67d4cf';
    case SYSTEM_ORANGE = '#ffb33f';
    case SYSTEM_PINK = '#ff6482';
    case SYSTEM_PURPLE = '#da8fff';
    case SYSTEM_RED = '#ff6861';
    case SYSTEM_TEAL = '#2fbacd';
    case SYSTEM_YELLOW = '#ffd426';

    // dark mode
    //case SYSTEM_GRAY = '#aeaeb2';
    //case SYSTEM_RED = '#ff4245';
    //case SYSTEM_ORANGE = '#ff9230';
    //case SYSTEM_BLUE = '#0091ff';
    //case SYSTEM_GREEN = '#30d158';
    //case SYSTEM_PURPLE = '#db34f2';
    //case SYSTEM_YELLOW = '#ffd600';
    //case SYSTEM_PINK = '#ff375f';
    //case SYSTEM_MINT = '#00dac3';
    //case SYSTEM_INDIGO = '#6b5dff';

    case MAC_OS = '#2dd4bf';
    case OTHER = '#d8d8dc';
    case WINDOWS_XP = '#7dabf7';
}
