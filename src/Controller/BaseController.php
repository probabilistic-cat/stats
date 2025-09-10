<?php

declare(strict_types=1);

namespace App\Controller;

use App\Consts;
use App\Data\Data;
use App\DTO\SubcategoryViewDTO;
use App\Profile\BaseProfile;
use App\Service\DataFileDecoder;
use App\Service\DataFileManager;
use Psr\Cache\CacheItemInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Cache\CacheInterface;

abstract class BaseController extends AbstractController
{
    private const int DATA_CACHE_EXPIRATION_TIME = Consts::SECONDS_IN_YEAR;

    protected string $categoryName = 'Stats';

    public function __construct(
        private readonly DataFileDecoder $decoder,
        private readonly CacheInterface $cache,
    ) {}

    abstract protected function getCategoryRoute(): string;

    abstract protected function getProfile(): BaseProfile;

    /**
     * @return array<string, string>
     */
    abstract protected function getRoutesByName(): array;

    protected function getResponse(string $subcategory): Response {
        $profile = $this->getProfile();
        $cacheKey = $profile->getDataCacheKey(subcategory: $subcategory);

        /** @var Data $data */
        $data = $this->cache->get(
            $cacheKey,
            function (CacheItemInterface $cacheItem) use ($profile, $subcategory): Data {
                $cacheItem->expiresAfter(self::DATA_CACHE_EXPIRATION_TIME);

                $filePath = DataFileManager::getLastAvailableFilePath(profile: $profile, subcategory: $subcategory);
                $data = $this->decoder->decode(profile: $profile, filepath: $filePath);
                $data->filterOutZeroPercentVersions();
                $data->sort();
                $data->setColors();
                return $data;
            },
        );

        $context = [
            'data' => $data,
            'categoryName' => $this->categoryName,
            'categoryRoute' => $this->getCategoryRoute(),
            'subcategories' => $this->getSubcategories(subcategory: $subcategory),
            'sourceUrl' => $profile->getSourceUrl($subcategory),
        ];

        return $this->render('content.html.twig', $context /*[...$context, ...(array)$contentView]*/);
    }

    /**
     * @return array<SubcategoryViewDTO>
     */
    protected function getSubcategories(string $subcategory): array {
        $subcategories = [];
        foreach ($this->getRoutesByName() as $name => $route) {
            $subcategories[] = new SubcategoryViewDTO(
                name: ucfirst($name),
                route: $this->generateUrl($route),
                isCurrent: $subcategory === $name,
            );
        }

        return $subcategories;
    }
}
