<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class IosVersionsController extends AbstractController
{
    #[Route('/', name: 'app_ios_versions')]
    public function ios_versions(SerializerInterface $serializer): Response
    {
        $rawData = $serializer->decode(file_get_contents(
            __DIR__.'/../Data/ios_version-ww-monthly-201706-202404.csv'),
            'csv',
            ['csv_key_separator' => '^'], // disable grouping
        );

        $result = [];
        foreach ($rawData as $rawMonthData) {
            $date = $rawMonthData['Date'];
            $monthData = [];
            $monthPercentOther = array_key_exists('Other', $rawMonthData) ? $rawMonthData['Other'] : 0;
            unset($rawMonthData['Date'], $rawMonthData['Other']);
            foreach ($rawMonthData as $version => $percent) {
                $version = mb_substr($version, mb_strrpos($version, ' ') + 1);
                $majorVersion = mb_substr($version, 0, mb_strrpos($version, '.'));
//                $minorVersion = mb_substr($version, mb_strrpos($version, '.') + 1);
                $percent = (float)$percent;

                if (!array_key_exists($majorVersion, $monthData)) {
                    $monthData[$majorVersion] = 0;
                }
                $monthData[$majorVersion] += $percent;
            }
            ksort($monthData);
            $result[$date] = ['other' => $monthPercentOther] + $monthData;
        }
        krsort($result);

        return $this->render('ios_versions.html.twig', [
            'data' => $result,
        ]);
    }
}