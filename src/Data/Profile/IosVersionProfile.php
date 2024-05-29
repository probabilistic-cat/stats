<?php

declare(strict_types=1);

namespace App\Data\Profile;

class IosVersionProfile extends BaseProfile
{
    protected string $filename = 'ios_version-ww-monthly-201706-202404.csv';
    public string $versionPrefix = 'iOS ';
    public string $versionSeparator = '.';
}
