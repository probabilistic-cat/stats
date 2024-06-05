<?php

declare(strict_types=1);

namespace App\Repository;

class Consts
{
    public const string DIR = __DIR__;

    public const int SECONDS_IN_MINUTE = 60;
    public const int SECONDS_IN_HOUR = self::SECONDS_IN_MINUTE * 60;
    public const int SECONDS_IN_DAY = self::SECONDS_IN_HOUR * 24;
    public const int SECONDS_IN_WEEK = self::SECONDS_IN_DAY * 7;
    public const int SECONDS_IN_MONTH = self::SECONDS_IN_DAY * 31;
    public const int SECONDS_IN_YEAR = self::SECONDS_IN_DAY * 366;
}
