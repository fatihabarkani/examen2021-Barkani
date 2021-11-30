<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Livres;
use App\Form\LivresType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LivresController extends AbstractController
{

    //liste de tous les livres
      /**
     * @Route("/livres", name="livres")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $repository=$entityManager->getRepository(Livres::class);
        $livres=$repository->findAll();

        return $this->render('livres/index.html.twig', [
            'controller_name' => 'LivresController',
            'livres'=>$livres
        ]);
    }

    //livre par id
    /**
     * @Route("/livres/detail/{id}", name="livres_det")
     */
    public function detail($id, EntityManagerInterface $entityManager): Response
    {
        $repository=$entityManager->getRepository(Livres::class);
        $livre=$repository->find($id);
        return $this->render('livres/detail.html.twig', [
            'controller_name' => 'LivresController',
            'livres'=>$livre
        ]);
    }

    //formulaire pour l'ajout de livre
    /**
     * @Route("/livres/form", name="livres_form")
     */
    
     public function add(Request $request){

        $livre=new Livres();
        $form=$this->createForm(LivresType::class, $livre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                $livre=$form->getData();
                $entityManager=$this->getDoctrine()->getManager();
                $entityManager->persist($livre);
                $entityManager->flush();

         return $this->redirectToRoute('livres_det', [
             'id'=>$livre->getId()
         ]);
        }

     return $this->render('livres/add.html.twig', [
         'form' => $form->createView(),
     ]);
    }

    /**
  * @Route("/livre/delete/{id}", name="livre_del")
  */
   public function delete(Livres $livre,EntityManagerInterface $entityManager)
   {
       $entityManager->remove($livre);
       $entityManager->flush();
       return $this->redirectToRoute('home');
   }

}
