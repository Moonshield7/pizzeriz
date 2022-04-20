<?php

declare(strict_types=1);

namespace App\Controller\admin;

use DateTime;
use App\Entity\Pizza;
use App\Form\PizzaType;
use App\Repository\PizzaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class PizzaController extends AbstractController
{
    #[Route('/admin/pizza', name: 'app_admin_pizza_list', methods: ['GET'])]
    public function list( Request $request, PizzaRepository $repository): Response
    {
      $pizzas =  $repository->findAll();

      return $this->render('admin/home.html.twig', [
          'pizzas' => $pizzas,
      ]);

    }

    #[Route('/admin/pizza/create', name:'app_admin_pizza_create', methods: ['POST','GET'])]
    public function create(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $pizza = new Pizza();

        $form = $this->createForm(PizzaType::class, $pizza)
            ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $pizza->setCreatedAt(new DateTime());
            $pizza->setUpdatedAt(new DateTime());

            /** @var UploadedFile $photo */
            $photo = $form->get('picture')->getData();

            if($photo) {
                
                $this->handleFile($pizza, $photo, $slugger);
            }

            $entityManager->persist($pizza);
            $entityManager->flush();

            $this->addFlash('success', 'Le nouveau produit est en ligne avec succès !');
            return $this->redirectToRoute('app_admin_pizza_list');
        }// end if($form)

        return $this->render('admin/pizza/create.html.twig', [
            'form' => $form->createView()
        ]);

    }

    #[Route('/admin/pizza/{id}/modifier', name: 'app_admin_pizza_update', methods: ['GET', 'POST'])]
    public function updateProduit(Pizza $pizza, EntityManagerInterface $entityManager, Request $request, SluggerInterface $slugger): Response
    {
        $originalPhoto = $pizza->getPicture();

        $form = $this->createForm(PizzaType::class, $pizza, [
            'picture' => $originalPhoto
        ])->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $pizza->setUpdatedAt(new DateTime());

            $photo = $form->get('picture')->getData();

            if($photo) {
                // Méthode créée par nous-même pour réutiliser cette partie de code
                $this->handleFile($pizza, $photo, $slugger);
            }
            else {
                $pizza->setPicture($originalPhoto);
            }

            $entityManager->persist($pizza);
            $entityManager->flush();

            $this->addFlash('success', 'Vous avez modifié le produit avec succès !');
            return $this->redirectToRoute('app_admin_pizza_list');
        }

        return $this->render('admin/pizza/update.html.twig', [
            'form' => $form->createView(),
            'pizza' => $pizza,
        ]);
    }

    #[Route('/admin/pizza/{id}/supprimer', name: 'app_admin_pizza_delete')]
	public function delete(Pizza $pizza, PizzaRepository $repository): Response
	{
		$repository->remove($pizza);

		return $this->redirectToRoute('app_admin_pizza_list');
	}

    #[Route('/admin/pizza/par-nom/{name}', name: 'app_admin_pizza_listByName')]
	public function listByName(PizzaRepository $repository, string $name ): Response
	{
		$pizzas = $repository->findByName($name);

		return $this->render('admin/pizza/listName.html.twig', [
			'pizzas' =>  $pizzas,
		]);
	}

     
    private function handleFile(Pizza $pizza, UploadedFile $photo, SluggerInterface $slugger): void
    {
        
        $extension = '.' . $photo->guessExtension();

        $safeFilename = $slugger->slug($pizza->getName());

        $newFilename = $safeFilename . '_' . uniqid() . $extension;

        try {
            $photo->move($this->getParameter('uploads_dir'), $newFilename);
            $pizza->setPicture($newFilename);
        } catch (FileException $exception) {
            $this->addFlash('warning', 'La photo du produit ne s\'est pas importée avec succès. Veuillez réessayer en modifiant le produit.');
        } // end catch()
    }


    
    
}
