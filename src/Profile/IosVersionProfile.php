<?php

declare(strict_types=1);

namespace App\Profile;

use App\Enum\ProfileSort;

class IosVersionProfile extends BaseProfile
{
    public string $category = 'ios_version';
    public array $subcategories = [
        self::SUBCATEGORY_ALL,
        self::SUBCATEGORY_MOBILE,
        self::SUBCATEGORY_TABLET,
    ];

    protected string $marketShareUrlPart = 'ios-version-market-share';
    protected string $statType = 'iOS Version';
    protected array $fromYearBySubcategory = [
        self::SUBCATEGORY_ALL => 2017,
        self::SUBCATEGORY_MOBILE => 2017,
        self::SUBCATEGORY_TABLET => 2017,
    ];
    protected array $fromMonthBySubcategory = [
        self::SUBCATEGORY_ALL => 6,
        self::SUBCATEGORY_MOBILE => 6,
        self::SUBCATEGORY_TABLET => 6,
    ];

    public string $prefix = 'iOS ';

    public string $nameSeparator = '.';

    public ProfileSort $sort = ProfileSort::NameAsc;

    public function __construct() {
        $this->customColorsByName = self::getCustomColorsByNumberName();
    }

    #[\Override]
    public function preDecodeCsvData(string $data): string {
        return preg_replace(
            '~(' . $this->csvEnclosureKey . $this->prefix . ')(\d+)(' . $this->csvEnclosureKey . ')~',
            '$1$2' . $this->nameSeparator . static::MINOR_VERSION_UNKNOWN . ' $3',
            $data,
        );
    }
}
