<?php

namespace App\Service;

use App\Entity\QuizItem;
use Doctrine\Persistence\ManagerRegistry;

class GenerateOptions
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function genOptions(QuizItem $quizItem)
    {
        // 0. Function to determine year margin
        function getMargin($quizItem)
        {
            $itemYear = $quizItem->getYear();

            switch ($itemYear) {
                case ($itemYear < 0):
                    $margin = 150;
                    break;
                case ($itemYear < 500):
                    $margin = 125;
                    break;
                case ($itemYear < 1000):
                    $margin = 100;
                    break;
                case ($itemYear < 1250):
                    $margin = 50;
                    break;
                case ($itemYear < 1500):
                    $margin = 35;
                    break;
                case ($itemYear < 1750):
                    $margin = 25;
                    break;
                case ($itemYear < 1900):
                    $margin = 10;
                    break;
                case ($itemYear < 1950):
                    $margin = 5;
                    break;
                case ($itemYear < 2000):
                    $margin = 2;
                    break;
                default:
                    $margin = 1;
                }

            return $margin;
        }

        // 1. Select correct answer/option

        // 1.1. Get the entity manager from the ManagerRegistry
        $em = $this->doctrine->getManager();

        // 1.2. Define two named parameters in the DQL query
        $dql = "SELECT qi FROM App\Entity\QuizItem qi 
                WHERE qi.year >= :minLimit AND qi.year <= :maxLimit";

        // 1.3. Create a query object
        $query = $em->createQuery($dql);

        // 1.4. Bind values to parameters
        $minLimit = $quizItem->getYear() - getMargin($quizItem);
        $query->setParameter('minLimit', $minLimit);

        $maxLimit =  $quizItem->getYear() + getMargin($quizItem);
        $query->setParameter('maxLimit', $maxLimit);
        
        // 1.5. Execute query
        $results = $query->getResult();
        // dd($results);

        // 1.6. Pick random result (object) from results (objects array)
        $correctOption = $results[mt_rand(0, count($results) - 1)];
        // dd($correctOption);

        // 2. Select two erroneous answers

        $dql = "SELECT qi FROM App\Entity\QuizItem qi 
                WHERE qi.year < :minLimit OR qi.year > :maxLimit";
        $query = $em->createQuery($dql);
        $query->setParameter('minLimit', $minLimit);
        $query->setParameter('maxLimit', $maxLimit);
        $results = $query->getResult();
        // dd($results);

        for ($i=0; $i<2; $i++) {
            $twoErrOptions[] = $results[mt_rand(0, count($results) - 1)];
        }
        // dd($twoErrOptions);

        // 3. Put together correct and erroneus answers
        $twoErrOptions[] = $correctOption;
        $allOptions = $twoErrOptions;
        dd($allOptions);

        return $allOptions;
    }
}
