<?php

namespace App\Controller;

use App\Entity\Cave;
use App\Entity\Wine;
use App\Repository\CaveRepository;
use App\Repository\WineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/cave')]
class CaveController extends AbstractController
{
    #[Route('/', name: 'app_cave')]
    public function index(CaveRepository $caveRepository): Response
    {
        // Récupère l'utilisateur connecté
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté.');
        }

        // Récupère la cave de l'utilisateur
        $cave = $caveRepository->findOneBy(['user' => $user]);

        return $this->render('cave/index.html.twig', [
            'cave' => $cave,
        ]);
    }

    #[Route('/add/{id}', name: 'add_wine_to_cave')]
    #[IsGranted('ROLE_USER')]
    public function addWine(Wine $wine, EntityManagerInterface $entityManager, CaveRepository $caveRepository): Response
    {
        // Récupère l'utilisateur connecté et sa cave
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté.');
        }

        $cave = $caveRepository->findOneBy(['user' => $user]);
        if (!$cave) {
            throw $this->createNotFoundException('Votre cave n\'existe pas.');
        }

        // Ajoute le vin à la cave si ce n'est pas déjà fait
        if (!$cave->getWine()->contains($wine)) {
            $cave->addWine($wine);
            $entityManager->persist($cave);
            $entityManager->flush();

            $this->addFlash('success', 'Vin ajouté à votre cave.');
        } else {
            $this->addFlash('info', 'Ce vin est déjà dans votre cave.');
        }

        return $this->redirectToRoute('app_cave');
    }

    #[Route('/remove/{id}', name: 'remove_wine_from_cave')]
    #[IsGranted('ROLE_USER')]
    public function removeWine(Wine $wine, EntityManagerInterface $entityManager, CaveRepository $caveRepository): Response
    {
        // Récupère l'utilisateur connecté et sa cave
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté.');
        }

        $cave = $caveRepository->findOneBy(['user' => $user]);
        if (!$cave) {
            throw $this->createNotFoundException('Votre cave n\'existe pas.');
        }

        // Supprime le vin de la cave si présent
        if ($cave->getWine()->contains($wine)) {
            $cave->removeWine($wine);
            $entityManager->persist($cave);
            $entityManager->flush();

            $this->addFlash('success', 'Vin retiré de votre cave.');
        } else {
            $this->addFlash('info', 'Ce vin n\'est pas dans votre cave.');
        }

        return $this->redirectToRoute('app_cave');
    }

    
}
