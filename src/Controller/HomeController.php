<?php

namespace App\Controller;

use App\Entity\QuizItem;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $allItems = $doctrine->getRepository(QuizItem::class);
        $allItemsArray = $allItems->findAll();

        $quizPropositionIndex = mt_rand(0, count($allItemsArray)-1);
        $quizProposition = $allItemsArray[$quizPropositionIndex];

        $var = ['quizProposition' => $quizProposition];

        return $this->render('home/index.html.twig', $var);
    }

    #[Route('/vue1', name: 'vue 1')]
    public function vue1(): Response
    {
        return $this->render('home/vue1.html.twig');
    }

    #[Route('/vue2', name: 'vue 2')]
    public function vue2(): Response
    {
        return $this->render('home/vue2.html.twig');
    }
}
