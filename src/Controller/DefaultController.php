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
      $pizza =  $repository->findAll();

      return $this->render('default/home.html.twig');

    }
   
}
