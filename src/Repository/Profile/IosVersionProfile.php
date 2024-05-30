<?php

declare(strict_types=1);

namespace App\Repository\Profile;

class IosVersionProfile extends BaseProfile
{
    protected string $filename = 'ios_version-ww-monthly-201706-202404.csv';
    public string $versionPrefix = 'iOS ';
    public string $versionSeparator = '.';
}
