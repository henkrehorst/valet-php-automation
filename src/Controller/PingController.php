<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PingController extends AbstractController
{
    /**
     * @Route("/ping", name="ping")
     */
    public function index()
    {
        return JsonResponse::create(["status" => [
            "message" => "valet-php-automation is online!",
            "online" => true
        ]]);
    }
}
