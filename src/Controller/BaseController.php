<?php

declare(strict_types=1);

namespace App\Controller;

use App\Consts;
use App\Data\Data;
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

    /**
     * @param array<string, string> $extraContext
     */
    protected function getResponse(BaseProfile $profile, string $subcategory, array $extraContext): Response {
        $cacheKey = $profile->getDataCacheKey(subcategory: $subcategory);

        $data = $this->cache->get($cacheKey, function (CacheItemInterface $cacheItem) use ($profile, $subcategory) {
            $cacheItem->expiresAfter(self::DATA_CACHE_EXPIRATION_TIME);

            $filePath = DataFileManager::getLastAvailableFilePath(profile: $profile, subcategory: $subcategory);
            $data = $this->decoder->decode(profile: $profile, filepath: $filePath);
            $data->filterOutZeroPercentVersions();
            $data->sort();
            $data->setColors();
            return $data;
        });
        assert($data instanceof Data);

        $context = [
            'subcategoryCurrent' => $subcategory,
            'data' => $data,
            'hasMinor' => $data->hasMinor(),
        ];

        return $this->render('content.html.twig', [...$context, ...$extraContext]);
    }
}
