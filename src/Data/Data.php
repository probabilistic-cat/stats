<?php

declare(strict_types=1);

namespace App\Data;

use App\Enum\ProfileSort;
use App\Helper\ColorHelper;
use App\Profile\BaseProfile;

class Data
{
    private bool $hasMinor = false;
    /** @var array<MonthData> */
    public array $monthDatas = [];

    public function __construct(
        public readonly BaseProfile $profile,
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
        usort(
            $this->monthDatas,
            static fn (MonthData $a, MonthData $b): int => $b->getDateString() <=> $a->getDateString(),
        );

        $reference = $this->getSortVersionsReference($this->monthDatas[0]);

        foreach ($this->monthDatas as $monthData) {
            if ($this->hasMinor()) {
                foreach ($monthData->versions as $version) {
                    if (count($version->minorVersions) > 0) {
                        usort(
                            $version->minorVersions,
                            static fn (Version $a, Version $b): int => strnatcmp($a->name, $b->name),
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
        $allNames = $this->getAllMajorNamesSortedAsc();
        $priority = 0;

        $versionsOther = BaseProfile::NAMES_OTHER;
        rsort($versionsOther);
        foreach (BaseProfile::NAMES_OTHER as $name) {
            $reference[$name] = $priority;
            $priority++;
        }

        $customPriority = count($allNames) + count(BaseProfile::NAMES_OTHER);
        if ($this->profile->sort === ProfileSort::PERCENT_ASC) {
            $lastMonthVersions = $lastMontData->versions;
            usort($lastMonthVersions, static fn (Version $a, Version $b): int => $b->percent <=> $a->percent);
            foreach ($lastMonthVersions as $version) {
                if (!in_array($version->name, BaseProfile::NAMES_OTHER, true)) {
                    $reference[$version->name] = $customPriority;
                    $customPriority--;
                }
            }
        } elseif ($this->profile->sort === ProfileSort::CUSTOM) {
            $sortCustom = $this->profile->customSortedNames;
            krsort($sortCustom);
            foreach ($sortCustom as $name) {
                $reference[$name] = $customPriority;
                $customPriority--;
            }
        }

        foreach ($allNames as $name) {
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
        $minorNamesByName = [];
        foreach ($this->monthDatas as $monthData) {
            $versions = $monthData->versions;
            krsort($versions);
            foreach ($versions as $version) {
                if (!array_key_exists($version->name, $minorNamesByName)) {
                    $minorNamesByName[$version->name] = [];
                }

                foreach ($version->minorVersions as $minorVersion) {
                    $minorNamesByName[$version->name][$minorVersion->name] = null;
                }
            }
        }

        $colorsByName = array_fill_keys(array_keys($minorNamesByName), null);
        $colorsByName = array_replace($colorsByName, $this->profile->customColorsByName);

        foreach (BaseProfile::NAMES_OTHER as $nameOther) {
            $colorsByName[$nameOther] = ColorHelper::OTHER;
        }

        $colorIndex = 0;
        foreach ($colorsByName as $name => $_) {
            $name = (string)$name;

            if ($colorsByName[$name] === null) {
                $colorsByName[$name] = $this->profile->colors[$colorIndex];
                $colorIndex++;
                if ($colorIndex >= count($this->profile->colors)) {
                    $colorIndex = 0;
                }
            }

            if (array_key_exists($name, $minorNamesByName)) {
                $minorNames = array_keys($minorNamesByName[$name]);
                sort($minorNames, SORT_NATURAL);
                $minorNamesColors = ColorHelper::getGradient($colorsByName[$name], count($minorNames));
                foreach ($minorNamesColors as $index => $color) {
                    $colorsByName[$minorNames[$index]] = $color;
                }
            }
        }

        return $colorsByName;
    }

    /**
     * @return array<string, null>
     */
    private function getAllMajorNamesSortedAsc(): array {
        $allNames = [];
        foreach ($this->monthDatas as $monthData) {
            foreach ($monthData->versions as $version) {
                $allNames[$version->name] = null;
            }
        }
        ksort($allNames, SORT_NATURAL);

        return array_keys($allNames);
    }
}
