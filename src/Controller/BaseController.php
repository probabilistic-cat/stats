<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\Data\DataFileDecoder;
use App\Repository\Profile\BaseProfile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends AbstractController
{
    public function __construct(
        private readonly DataFileDecoder $decoder,
    ) {}

    protected function getResponse(BaseProfile $profile, string $subcategory, string $categoryLink): Response {
        $filepath = $profile->getFilePathBySubcategory($subcategory);
        $data = $this->decoder->decode(profile: $profile, filepath: $filepath);

        return $this->render('content.html.twig', [
            'category' => $profile->category,
            'categoryLink' => $categoryLink,
            'subcategories' => array_map(
                fn (string $pathName): string => $this->generateUrl($pathName),
                $profile->subcategoriesLinks,
            ),
            'subcategoryCurrent' => $subcategory,
            'data' => $data,
            'hasMinor' => $data->hasMinor,
        ]);
    }
}
