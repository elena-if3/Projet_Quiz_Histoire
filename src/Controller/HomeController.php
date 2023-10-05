<?php

namespace App\Controller;

use App\Entity\QuizItem;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// own service
use App\Service\GenerateOptions;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine, GenerateOptions $generator): Response
    {
        // Get array containing all the quiz items
        $allItems = $doctrine->getRepository(QuizItem::class);
        $allItemsArray = $allItems->findAll();

        // Pick random item from array
        $quizPropositionIndex = mt_rand(0, count($allItemsArray) - 1);
        $quizProposition = $allItemsArray[$quizPropositionIndex];

        // Find 3 coherent options by using own GenerateOptions service
        $threeOptions = $generator->genOptions($quizProposition);

        // Shuffle the array to randomize the order
        shuffle($threeOptions);

        $vars = [
            'quizProposition' => $quizProposition,
            'threeOptions' => $threeOptions
        ];

        return $this->render('home/index.html.twig', $vars);
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
