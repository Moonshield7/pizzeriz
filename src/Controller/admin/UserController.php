<?php

declare(strict_types=1);

namespace App\Controller\admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
  
    #[Route('/admin/user', name: 'app_admin_user_list', methods: ['GET'])]
    public function list( Request $request, UserRepository $repository): Response
    {
      $users =  $repository->findAll();

      return $this->render('admin/user/list.html.twig', [
          'users' => $users,
      ]);

    }

    #[Route('/admin/user/{id}/modifier', name: 'app_admin_user_update', methods: ['GET', 'POST'])]
	public function update(User $user, Request $request, UserRepository $repository): Response
	{
		// Création d'un formulaire :
		$form = $this->createForm(UserType::class, $user, [
			'handleDates' => true,
		]);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			
			$repository->add($form->getData());

			
			return $this->redirectToRoute('app_admin_user_list');
		}

		return $this->render('admin/user/update.html.twig', [
			'form' => $form->createView(),
		]);
	}

    #[Route('/admin/user/{id}/supprimer', name: 'app_admin_user_delete')]
	public function delete(User $user, UserRepository $repository): Response
	{
		$repository->remove($user);

		return $this->redirectToRoute('app_admin_user_list');
	}

	#[Route('/admin/user/par-nom/{name}', name: 'app_admin_user_listByName')]
	public function listByName(UserRepository $repository, string $name): Response
	{
		$users = $repository->findByName($name);

		return $this->render('admin/user/listByName.html.twig', [
			'users' => $users,
		]);
	}
}
