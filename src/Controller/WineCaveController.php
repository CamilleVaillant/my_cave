<?php

namespace App\Controller;

use App\Entity\Wine;
use App\Form\WineType;
use App\Repository\CaveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class WineCaveController extends AbstractController{
    #[Route('/wine/cave', name: 'app_wine_cave')]
    public function index(CaveRepository $repository): Response
    {
        $cave = $repository->findAll();
        return $this->render('wine_cave/index.html.twig', [
            'caves' => $cave,
        ]);
    }

    #[Route('/wine/{id}', name: 'modify_wine')]
    #[Route('/wine', name: 'add_wine')]
    public function change(Wine $wine = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Vérification si l'objet existe via l'injection de dependance
        // Si injection de dependance = On est en Modification
        // Sinon, on est un Creation et on créé l'objet
        if(!$wine){
            $wine = new Wine;
        }
        

        // Récupération du formulaire et association avec l'objet
        $form = $this->createForm(WineType::class,$wine);

        // Récupération des données POST du formulaire
        $form->handleRequest($request);
        // Vérification si le formulaire est soumis et Valide
        if($form->isSubmitted() && $form->isValid()){
            // Persistance des données
            $entityManager->persist($wine);
            // Envoi en BDD
            $entityManager->flush();

            // Redirection de l'utilisateur
            return $this->redirectToRoute('app_home');
        }

        return $this->render('wine/addupdate.html.twig', [
            'wineForm' => $form->createView(), //envoie du formulaire en VUE
            'isModification' => $wine->getId() !== null //Envoie d'un variable pour définir si on est en Modif ou Créa
        ]);
    }

    #[Route('/wine/remove/{id}', name: 'delete_wine')]
    public function remove(Wine $wine, Request $request, EntityManagerInterface $entityManager): Response
    {
        
        

        if($this->isCsrfTokenValid('SUP'.$wine->getId(),$request->get('_token'))){
            $entityManager->remove($wine);
            $entityManager->flush();
            $this->addFlash('success','La suppression à été effectuée');
            return $this->redirectToRoute('app_home');

        }
    }
}
