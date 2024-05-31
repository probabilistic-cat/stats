<?php

declare(strict_types=1);

namespace App\Repository\Data;

use App\Repository\Helper\ColorHelper;
use App\Repository\Profile\BaseProfile;

class Data
{
    private bool $hasMinor = false;

    public function __construct(
        public BaseProfile $profile,
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

    public function hasMinor(): bool {
        return $this->hasMinor;
    }

    public function sort(): void {
        foreach ($this->monthDatas as $monthIndex => $monthData) {
            if ($this->hasMinor()) {
                foreach ($monthData->versions as $versionIndex => $version) {
                    if (count($version->minorVersions) > 0) {
                        usort(
                            $this->monthDatas[$monthIndex]->versions[$versionIndex]->minorVersions,
                            fn (Version $a, Version $b): int => $this->sortVersions($a, $b),
                        );
                    }
                }
            }
            usort(
                $this->monthDatas[$monthIndex]->versions,
                fn (Version $a, Version $b): int => $this->sortVersions($a, $b),
            );
        }

        usort($this->monthDatas, static fn (MonthData $a, MonthData $b): int => $b->date <=> $a->date);
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
            $minorVersionsColors = ColorHelper::getGradient($colorsByVersions[$majorVersion], count($minorVersions));
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
        ksort($allVersions, SORT_NATURAL);

        return $allVersions;
    }

    private function isVersionNameMajor(string $versionName): bool {
        return mb_strpos($versionName, $this->profile->versionSeparator) === false;
    }

    private function sortVersions(Version $a, Version $b): int {
        if ($a->version === BaseProfile::VERSION_OTHER) {
            return -1;
        }
        if ($b->version === BaseProfile::VERSION_OTHER) {
            return 1;
        }

        if ($this->profile->sort === BaseProfile::SORT_PERCENT_ASC) {
            return $a->percent <=> $b->percent;
        }

        if ($this->profile->sort === BaseProfile::SORT_VERSION_ASC) {
            return $a->version <=> $b->version;
        }

        return $a->version <=> $b->version;
    }
}
