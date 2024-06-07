<?php

declare(strict_types=1);

namespace App\Data;

use App\Helper\ColorHelper;
use App\Profile\BaseProfile;

class Data
{
    private bool $hasMinor = false;
    /** @var array<MonthData> */
    public array $monthDatas = [];

    public function __construct(
        public BaseProfile $profile,
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

    public function filterOutZeroPercentVersions(): void {
        foreach ($this->monthDatas as $monthData) {
            foreach ($monthData->versions as $versionIndex => $version) {
                if ($version->percent === 0.0) {
                    unset($monthData->versions[$versionIndex]);
                } else {
                    foreach ($version->minorVersions as $minorVersionIndex => $minorVersion) {
                        if ($minorVersion->percent === 0.0) {
                            unset($version->minorVersions[$minorVersionIndex]);
                        }
                    }
                }
            }
        }
    }

    public function sort(): void {
        usort($this->monthDatas, static fn (MonthData $a, MonthData $b): int => $b->date <=> $a->date);

        $reference = $this->getSortVersionsReference($this->monthDatas[0]);

        foreach ($this->monthDatas as $monthData) {
            if ($this->hasMinor()) {
                foreach ($monthData->versions as $version) {
                    if (count($version->minorVersions) > 0) {
                        usort(
                            $version->minorVersions,
                            static fn (Version $a, Version $b): int => $a->name <=> $b->name,
                        );
                    }
                }
            }

            usort(
                $monthData->versions,
                static fn (Version $a, Version $b): int => $reference[$a->name] <=> $reference[$b->name],
            );
        }
    }

    /**
     * @return array<string, int>
     */
    private function getSortVersionsReference(MonthData $lastMontData): array {
        $reference = [];
        $allVersions = $this->getAllNamesSortedAsc();
        $priority = 0;

        $versionsOther = BaseProfile::NAMES_OTHER;
        rsort($versionsOther);
        foreach (BaseProfile::NAMES_OTHER as $name) {
            $reference[$name] = $priority;
            $priority++;
        }

        if ($this->profile->sort === BaseProfile::SORT_PERCENT_ASC) {
            $lastMonthVersions = $lastMontData->versions;
            usort($lastMonthVersions, static fn (Version $a, Version $b): int => $b->percent <=> $a->percent);
            $percentPriority = count($allVersions) + count(BaseProfile::NAMES_OTHER);
            foreach ($lastMonthVersions as $version) {
                if (!in_array($version->name, BaseProfile::NAMES_OTHER, true)) {
                    $reference[$version->name] = $percentPriority;
                    $percentPriority--;
                }
            }
        }

        foreach ($allVersions as $name) {
            if (!array_key_exists($name, $reference)) {
                $reference[$name] = $priority;
                $priority++;
            }
        }

        return $reference;
    }

    public function setColors(): void {
        $colorsByVersion = $this->getColorsByName();

        foreach ($this->monthDatas as $monthData) {
            foreach ($monthData->versions as $version) {
                $version->color = $colorsByVersion[$version->name];
                foreach ($version->minorVersions as $minorVersion) {
                    $minorVersion->color = $colorsByVersion[$minorVersion->name];
                }
            }
        }
    }

    /**
     * @return array<string, string>
     */
    private function getColorsByName(): array {
        $colorsByName = array_fill_keys($this->getAllNamesSortedAsc(), null);
        $colorsByName = array_replace($colorsByName, $this->profile->customColorsByName);

        $colorIndex = 0;
        $lastMajorName = '';
        $minorColors = [];
        foreach ($colorsByName as $name => $_) {
            $name = (string)$name;

            if (in_array($name, BaseProfile::NAMES_OTHER, true)) {
                $colorsByName[$name] = BaseProfile::COLOR_OTHER;
                continue;
            }

            if ($this->isNameMajor($name)) {
                if ($colorsByName[$name] === null) {
                    $colorsByName[$name] = $this->profile->colors[$colorIndex];
                    $colorIndex++;
                    if ($colorIndex >= count($this->profile->colors)) {
                        $colorIndex = 0;
                    }
                }
                $lastMajorName = $name;
            } else {
                $minorColors[$lastMajorName][] = $name;
            }
        }

        foreach ($minorColors as $majorName => $minorNames) {
            $minorNamesColors = ColorHelper::getGradient($colorsByName[$majorName], count($minorNames));
            foreach ($minorNamesColors as $index => $color) {
                $colorsByName[$minorNames[$index]] = $color;
            }
        }

        return $colorsByName;
    }

    /**
     * @return array<string, null>
     */
    private function getAllNamesSortedAsc(): array {
        $allNames = [];
        foreach ($this->monthDatas as $monthData) {
            foreach ($monthData->versions as $version) {
                $allNames[$version->name] = null;
                foreach ($version->minorVersions as $minorVersion) {
                    $allNames[$minorVersion->name] = null;
                }
            }
        }
        ksort($allNames, SORT_NATURAL);

        return array_keys($allNames);
    }

    private function isNameMajor(string $name): bool {
        return mb_strpos($name, $this->profile->nameSeparator) === false;
    }
}
