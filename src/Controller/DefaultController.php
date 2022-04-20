<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\PizzaRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    #[Route("/", name: "app_default_show_home", methods: ["GET"])]
    public function showHome( Request $request, PizzaRepository $repository): Response
    {
      $pizzas =  $repository->findAll();

      return $this->render('default/home.html.twig', [
        'pizzas' => $pizzas,
      ]);

    }

    #[Route("/admin/dashboard", name: "app_admin_show_dashboard", methods: ["GET"])]
    public function showDashboard(): Response
    {
        return $this->render("/admin/dashboard.html.twig");
    }
}
