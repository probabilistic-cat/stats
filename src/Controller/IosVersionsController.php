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
            'csv'
        );

        $result = [];
        foreach ($rawData as $rawMonthData) {
            $date = $rawMonthData['Date'];
            $monthPercentOther = $rawMonthData['Other'];
            unset($rawMonthData['Date'], $rawMonthData['Other']);
            foreach ($rawMonthData as $majorVersion => $dataByMinorVersion) {
                $majorVersion = mb_substr($majorVersion, mb_strrpos($majorVersion, ' ') + 1);
                $majorVersionPercent = 0;
                foreach ($dataByMinorVersion as $minorVersion => $percent) {
                    $version = $majorVersion.'.'.$minorVersion;
                    $percent = (float)$percent;
//                    $result[$date][$version] = $percent;
                    $majorVersionPercent += $percent;
                }
                $result[$date][$majorVersion] = $majorVersionPercent;
            }
            ksort($result[$date]);
            $result[$date] = ['other' => $monthPercentOther] + $result[$date];
        }
        krsort($result);

        return $this->render('ios_versions.html.twig', [
            'data' => $result,
        ]);
    }
}