<?php

namespace App\Controller;

use App\Entity\Wine;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class CaveController extends AbstractController{
    #[Route('/my-cave', name: 'my_cave')]
    public function myCave(Security $security): Response
    {
        // Récupère l'utilisateur connecté
        $user = $security->getUser();

        // Récupère la cave de l'utilisateur connecté
        $cave = $user->getCave();

        if (!$cave) {
            throw $this->createNotFoundException('Votre cave n\'existe pas.');
        }

        // Affiche la cave
        return $this->render('cave/show.html.twig', [
            'cave' => $cave,
        ]);
    }

    // Permet de supprimer un vin de la cave de l'utilisateur
    #[Route('/cave/remove/{id}', name: 'remove_wine_from_cave')]
    public function removeWine(Wine $wine, Security $security, EntityManagerInterface $entityManager): Response
    {
        // Récupère l'utilisateur connecté
        $user = $security->getUser();

        // Récupère la cave de l'utilisateur connecté
        $cave = $user->getCave();

        // Vérifie si la cave existe et si le vin appartient à la cave
        if (!$cave || !$cave->getWine()->contains($wine)) {
            throw $this->createAccessDeniedException("Vous ne pouvez pas supprimer ce vin.");
        }

        // Supprime le vin de la cave
        $cave->removeWine($wine);
        $entityManager->flush();

        // Redirection vers la page de la cave de l'utilisateur
        return $this->redirectToRoute('my_cave');
    }
}
