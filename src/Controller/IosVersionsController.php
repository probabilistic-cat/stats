<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IosVersionsController extends AbstractController
{
    #[Route('/', name: 'app_ios_versions')]
    public function all(): Response
    {
        return $this->render('ios_versions.html.twig');
    }
}