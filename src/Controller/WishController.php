<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/wish', name: 'app_wish_')]
class WishController extends AbstractController
{
    
    #[Route('/list', name: 'list')]
    
    public function list(WishRepository $wishRepository): Response
    {
        $wishes = $wishRepository->findPublishedWishesOrderedByDate();
        
        return $this->render('wish/list.html.twig', [
            'wishes' => $wishes,
        ]);
    }
    
    #[Route('/details/{id}', name: 'details')]
    public function details(int $id, EntityManagerInterface $entity_manager): Response
    {
        $wish = $entity_manager->getRepository(Wish::class)
            ->find($id);
        
        return $this->render('wish/details.html.twig', [
            'wish' => $wish,
        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(
        Request $request,
        EntityManagerInterface $entity_manager
    ):Response
    {
        $wish = new Wish();
        $form = $this->createForm(WishType::class, $wish);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $wish->setIsPublished(true);
            $wish->setDateCreated(new \DateTime());
            $entity_manager->persist($wish);
            $entity_manager->flush();
            
            $this->addFlash('success', 'Idea successfully added !');
            
            return $this->redirectToRoute('app_wish_details', ['id' => $wish->getId()]);
        }
        return $this->render('wish/add.html.twig', [
            'form' => $form->createView()]);
    }
}
