<?php

declare(strict_types=1);

namespace App\Controller\admin;

use App\Entity\Pizza;
use App\Entity\Panier;
use App\Entity\Article;
use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{   

    #[Route('/account/panier', name:'app_account_panier_list', methods:['GET'])]
    public function list(UserRepository $repository): Response 
    {
        $user = $repository->find($this->getUser());

        $panier = $user->getPanier();
        if($panier==NULL){
            $user->setPanier(new Panier);
            $panier = $user->getPanier();
        }
       $articles = $panier->getArticles();

       return $this->render('account/panier/list.html.twig', [
           'articles'=> $articles
       ]);
    }

    #[Route('/account/panier/add/{id}', name:'app_account_panier_add', methods:['GET', 'POST'])]
    public function add(UserRepository $repository, Pizza $pizza, EntityManagerInterface $entityManager): Response 
    {
        $user = $repository->find($this->getUser());

        $panier = $user->getPanier();
        if($panier==NULL){
            $user->setPanier(new Panier);
            $panier = $user->getPanier();
        }
        $article = new Article();
        $article->setPizza($pizza);
        $article->setQuantity('1');
        $article->setPanier($panier);
        $entityManager->persist($article);
        $entityManager->flush();
       return $this->redirectToRoute('app_account_panier_list');
    }


    #[Route('/account/panier/addQuantity/{id}', name:'app_account_panier_addQuantity', methods:['GET','POST'])]
    public function addQuantity(ArticleRepository $repository, Article $article ): Response
    {
       $article->setQuantity(strval($article->getQuantity()+1));
       $repository->add($article);

       return $this->redirectToRoute('app_account_panier_list');

    }

    #[Route('/account/panier/subtractQuantity/{id}', name:'app_account_panier_subtractQuantity', methods:['GET','POST'])]
    public function subtractQuantity(ArticleRepository $repository, Article $article ): Response
    {
        if($article->getQuantity()>1){
            $article->setQuantity(strval($article->getQuantity()-1));
            $repository->add($article);
        }

       return $this->redirectToRoute('app_account_panier_list');

    }

    #[Route('/account/panier/remove/{id}', name:'app_account_panier_remove', methods:['GET'])]
    public function remove(Article $article, ArticleRepository $repository, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($this->getUser());

        $panier = $user->getPanier();
       
        
        $panier->removeArticle($article);
        $repository->remove($article);

        return $this->redirectToRoute('app_account_panier_list');

    }
    

}
