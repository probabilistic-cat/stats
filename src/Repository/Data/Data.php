<?php

declare(strict_types=1);

namespace App\Repository\Data;

use App\Repository\Helper\ColorHelper;
use App\Repository\Profile\BaseProfile;

class Data
{
    public function __construct(
        public BaseProfile $profile,
        public bool $hasMinor = false,
        /** @var MonthData[] $monthDatas */
        public array $monthDatas = [],
    ) {}

    public function setMinor(): void {
        foreach ($this->monthDatas as $monthData) {
            foreach ($monthData->versions as $version) {
                if (count($version->minorVersions) > 0) {
                    $this->hasMinor = true;
                    return;
                }
            }
        }

        $this->hasMinor = false;
    }

    public function setColors(): void {
        $colorsByVersions = $this->getAllVersions();
        $colorIndex = 0;
        $lastMajorVersion = '';
        $minorColors = [];
        foreach ($colorsByVersions as $version => $_) {
            if ($version === BaseProfile::VERSION_OTHER) {
                $colorsByVersions[$version] = BaseProfile::COLOR_OTHER;
                continue;
            }

            if ($this->isVersionNameMajor((string)$version)) {
                $colorsByVersions[$version] = $this->profile->colors[$colorIndex];
                $colorIndex++;
                if ($colorIndex >= count($this->profile->colors)) {
                    $colorIndex = 0;
                }
                $lastMajorVersion = $version;
            } else {
                $minorColors[$lastMajorVersion][] = $version;
            }
        }

        foreach ($minorColors as $majorVersion => $minorVersions) {
            $minorVersionsColors = ColorHelper::getPalette($colorsByVersions[$majorVersion], count($minorVersions));
            foreach ($minorVersionsColors as $index => $color) {
                $colorsByVersions[$minorVersions[$index]] = $color;
            }
        }

        foreach ($this->monthDatas as $monthData) {
            foreach ($monthData->versions as $version) {
                $version->color = $colorsByVersions[$version->version];
                foreach ($version->minorVersions as $minorVersion) {
                    $minorVersion->color = $colorsByVersions[$minorVersion->version];
                }
            }
        }
    }

    /**
     * @return array{int|string: null}
     */
    private function getAllVersions(): array {
        $allVersions = [];
        foreach ($this->monthDatas as $monthData) {
            foreach ($monthData->versions as $version) {
                $allVersions[$version->version] = null;
                foreach ($version->minorVersions as $minorVersion) {
                    $allVersions[$minorVersion->version] = null;
                }
            }
        }
        ksort($allVersions);

        return $allVersions;
    }

    private function isVersionNameMajor(string $versionName): bool {
        return mb_strpos($versionName, $this->profile->versionSeparator) === false;
    }
}
