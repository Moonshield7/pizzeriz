<?php

declare(strict_types=1);

namespace App\Controller\admin;

use App\Repository\CommandRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandController extends AbstractController
{
    #[Route('/admin/command', name: 'app_admin_command_list', methods: ['GET'])]
    public function list(CommandRepository $repository): Response{

        return $this->render('admin/command/list.html.twig',[
            'commands' => $repository->findAll()
        ]);
    }
}
