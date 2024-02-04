<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ServerTimeController extends AbstractController
{
    #[Route('/server/time', name: 'app_server_time')]
    public function index(): JsonResponse
    {
        $now = new \DateTime();
        $isoTime = $now->format(\DateTime::ISO8601);
        return new JsonResponse(['serverTime:' => $isoTime]);
    }
}
