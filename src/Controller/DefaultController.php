<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    #[Route("/", name: "app_default_show_home", methods: ["GET"])]
    public function showHome(): Response
    {
        return $this->render("/default/home.html.twig");
    }

    #[Route("/admin/dashboard", name: "app_admin_show_dashboard", methods: ["GET"])]
    public function showDashboard(): Response
    {
        return $this->render("/admin/dashboard.html.twig");
    }
}
