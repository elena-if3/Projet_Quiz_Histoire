<?php

namespace App\DataFixtures;

use App\Entity\QuizItem;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class QuizItemFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 50; $i++){

            $item = new QuizItem();
            $item->setTitle('Quiz item #'.$i);
            $item->setYear(mt_rand(-800, 1980));
            $item->setDescription('This happened in '.$item->getYear());
            $item->setLink('Link #'.$i);
            $item->setImage('Image #'.$i);

            $manager->persist($item);
        }

        $manager->flush();
    }
}
