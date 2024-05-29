<?php

declare(strict_types=1);

namespace App\Controller;

use App\Data\Decoder\DataFileDecoder;
use App\Data\Profile\IosVersionProfile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IosVersionsController extends AbstractController
{
    #[Route('/', name: 'app_ios_versions')]
    public function ios_versions(DataFileDecoder $dataFileDecoder): Response {
        $profile = new IosVersionProfile();
        $result = $dataFileDecoder->decode($profile);

        return $this->render('ios_versions.html.twig', [
            'data' => $result,
        ]);
    }
}
