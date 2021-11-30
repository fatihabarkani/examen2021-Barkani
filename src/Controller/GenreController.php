<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Form\GenreType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GenreController extends AbstractController
{
   
    //liste de tous les genres
      /**
     * @Route("/genre", name="genre")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $repository=$entityManager->getRepository(Genre::class);
        $genres=$repository->findAll();

        return $this->render('genre/index.html.twig', [
            'controller_name' => 'GenreController',
            'genres'=>$genres
        ]);
    }

    //Genre par id
    /**
     * @Route("/genre/detail/{id}", name="genre_det")
     */
    public function detail($id, EntityManagerInterface $entityManager): Response
    {
        $repository=$entityManager->getRepository(Genre::class);
        $genre=$repository->find($id);
        return $this->render('genre/detail.html.twig', [
            'controller_name' => 'GenreController',
            'genre'=>$genre
        ]);
    }

    //formulaire pour l'ajout de genre
    /**
     * @Route("/genre/form", name="genre_form")
     */
    
     public function add(Request $request){

        $genre=new Genre();
        $form=$this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                $genre=$form->getData();
                $entityManager=$this->getDoctrine()->getManager();
                $entityManager->persist($genre);
                $entityManager->flush();

         return $this->redirectToRoute('genre_det', [
            'id'=>$genre->getId()
        ]);
        }

     return $this->render('genre/add.html.twig', [
         'form' => $form->createView(),
     ]);
    }
}
