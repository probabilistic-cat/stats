<?php

declare(strict_types=1);

namespace App\Controller;

use App\Consts;
use App\Data\Data;
use App\DTO\ContentViewDTO;
use App\Profile\BaseProfile;
use App\Service\DataFileDecoder;
use App\Service\DataFileManager;
use Psr\Cache\CacheItemInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Cache\CacheInterface;

class BaseController extends AbstractController
{
    private const int DATA_CACHE_EXPIRATION_TIME = Consts::SECONDS_IN_YEAR;

    public function __construct(
        private readonly DataFileDecoder $decoder,
        private readonly CacheInterface $cache,
    ) {}

    protected function getResponse(BaseProfile $profile, string $subcategory, ContentViewDTO $contentView): Response {
        $cacheKey = $profile->getDataCacheKey(subcategory: $subcategory);

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
            'hasMinor' => $data->hasMinor(),
            'source_url' => $profile->getSourceUrl($subcategory),
        ];

        return $this->render('content.html.twig', [...$context, ...(array)$contentView]);
    }
}
