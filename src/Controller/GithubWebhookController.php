<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GithubWebhookController extends AbstractController
{
    /**
     * @Route("/github/webhook", name="github_webhook")
     */
    public function index()
    {
        return $this->render('github_webhook/index.html.twig', [
            'controller_name' => 'GithubWebhookController',
        ]);
    }
}
