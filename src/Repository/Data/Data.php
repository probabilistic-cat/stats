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
        usort($this->monthDatas, static fn (MonthData $a, MonthData $b): int => $b->date <=> $a->date);

        $reference = $this->getSortVersionsReference($this->monthDatas[0]);

        foreach ($this->monthDatas as $monthIndex => $monthData) {
            if ($this->hasMinor()) {
                foreach ($monthData->versions as $versionIndex => $version) {
                    if (count($version->minorVersions) > 0) {
                        usort(
                            $this->monthDatas[$monthIndex]->versions[$versionIndex]->minorVersions,
                            static fn (Version $a, Version $b): int => $a->version <=> $b->version,
                        );
                    }
                }
            }

            usort(
                $this->monthDatas[$monthIndex]->versions,
                static fn (Version $a, Version $b): int => $reference[$a->version] <=> $reference[$b->version],
            );
        }
    }

    public function setColors(): void {
        $colorsByVersion = $this->getColorsByVersion();

        foreach ($this->monthDatas as $monthData) {
            foreach ($monthData->versions as $version) {
                $version->color = $colorsByVersion[$version->version];
                foreach ($version->minorVersions as $minorVersion) {
                    $minorVersion->color = $colorsByVersion[$minorVersion->version];
                }
            }
        }
    }

    /**
     * @return array{string: string}
     */
    private function getColorsByVersion(): array {
        $colorsByVersion = array_fill_keys($this->getAllVersionsSortedAsc(), null);
        $colorsByVersion = array_replace($colorsByVersion, $this->profile->customColorsByVersion);

        $colorIndex = 0;
        $lastMajorVersion = '';
        $minorColors = [];
        foreach ($colorsByVersion as $version => $_) {
            $version = (string)$version;

            if (in_array($version, BaseProfile::VERSIONS_OTHER, true)) {
                $colorsByVersion[$version] = BaseProfile::COLOR_OTHER;
                continue;
            }

            if ($this->isVersionNameMajor($version)) {
                if ($colorsByVersion[$version] === null) {
                    $colorsByVersion[$version] = $this->profile->colors[$colorIndex];
                    $colorIndex++;
                    if ($colorIndex >= count($this->profile->colors)) {
                        $colorIndex = 0;
                    }
                }
                $lastMajorVersion = $version;
            } else {
                $minorColors[$lastMajorVersion][] = $version;
            }
        }

        foreach ($minorColors as $majorVersion => $minorVersions) {
            $minorVersionsColors = ColorHelper::getGradient($colorsByVersion[$majorVersion], count($minorVersions));
            foreach ($minorVersionsColors as $index => $color) {
                $colorsByVersion[$minorVersions[$index]] = $color;
            }
        }

        return $colorsByVersion;
    }

    /**
     * @return array{int|string: null}
     */
    private function getAllVersionsSortedAsc(): array {
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

        return array_keys($allVersions);
    }

    private function isVersionNameMajor(string $versionName): bool {
        return mb_strpos($versionName, $this->profile->versionSeparator) === false;
    }

    /**
     * @return array{string: int}
     */
    private function getSortVersionsReference(MonthData $lastMontData): array {
        $reference = [];
        $allVersions = $this->getAllVersionsSortedAsc();
        $priority = 0;

        $versionsOther = BaseProfile::VERSIONS_OTHER;
        rsort($versionsOther);
        foreach (BaseProfile::VERSIONS_OTHER as $versionName) {
            $reference[$versionName] = $priority;
            $priority++;
        }

        if ($this->profile->sort === BaseProfile::SORT_PERCENT_ASC) {
            $lastMonthVersions = $lastMontData->versions;
            usort($lastMonthVersions, static fn (Version $a, Version $b): int => $b->percent <=> $a->percent);
            $percentPriority = count($allVersions) + count(BaseProfile::VERSIONS_OTHER);
            foreach ($lastMonthVersions as $version) {
                if (!in_array($version->version, BaseProfile::VERSIONS_OTHER, true)) {
                    $reference[$version->version] = $percentPriority;
                    $percentPriority--;
                }
            }
        }

        foreach ($allVersions as $versionName) {
            if (!array_key_exists($versionName, $reference)) {
                $reference[$versionName] = $priority;
                $priority++;
            }
        }

        return $reference;
    }
}
