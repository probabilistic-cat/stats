<?php

declare(strict_types=1);

namespace App\Controller;

use App\Data\DataFileDecoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IosVersionsController extends AbstractController
{
    #[Route('/', name: 'app_ios_versions')]
    public function ios_versions(DataFileDecoder $dataFileDecoder): Response {
        $result = $dataFileDecoder->decode('ios_version-ww-monthly-201706-202404.csv', 'iOS ');

        return $this->render('ios_versions.html.twig', [
            'data' => $result,
        ]);
    }
}
