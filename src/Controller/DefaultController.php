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

    #[Route("/redirectRole", name: "app_admin_redirect_role", methods: ["GET"])]
    public function redirectRole(): Response
    {
      if ( in_array( 'ROLE_ADMIN', $this->getUser()->getRoles(), true) ){
        return $this->redirectToRoute("app_admin_show_dashboard");

      }else{
        return $this->redirectToRoute("app_default_show_home");
      }
    }
}
