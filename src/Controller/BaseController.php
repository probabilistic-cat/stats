<?php

declare(strict_types=1);

namespace App\Controller;

use App\Consts;
use App\Data\Data;
use App\Profile\BaseProfile;
use App\Service\DataFileDecoder;
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
     * @param array $extraContext<string, string>
     */
    protected function getResponse(BaseProfile $profile, string $subcategory, array $extraContext): Response {
        $cacheKey = self::getDataCacheKey(profile: $profile, subcategory: $subcategory);

        $data = $this->cache->get($cacheKey, function (CacheItemInterface $cacheItem) use ($profile, $subcategory) {
            $cacheItem->expiresAfter(self::DATA_CACHE_EXPIRATION_TIME);

            $filepath = $profile->getFilePathBySubcategory($subcategory);
            $data = $this->decoder->decode(profile: $profile, filepath: $filepath);
            $data->filterOutZeroPercentVersions();
            $data->sort();
            $data->setColors();
            return $data;
        });
        assert($data instanceof Data);

        $context = [
            'subcategories' => array_map(
                fn (string $pathName): string => $this->generateUrl($pathName),
                $profile->subcategoriesLinks,
            ),
            'subcategoryCurrent' => $subcategory,
            'data' => $data,
            'hasMinor' => $data->hasMinor(),
        ];

        return $this->render('content.html.twig', [...$context, ...$extraContext]);
    }

    private static function getDataCacheKey(BaseProfile $profile, string $subcategory): string {
        return mb_strtolower(str_replace(' ', '_', 'data_'.$profile->category.'_'.$subcategory));
    }
}
