<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\QuizItem;
use Symfony\Component\Finder\Finder;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ImportCSVFixtures extends Fixture
{
    private $em;
    private string $dossierImport;
    // inject Entity Manager to manage DB
    // inject folder containing the file to import (services.yaml --> "bind")
    public function __construct ($dossierImport, EntityManagerInterface $em){
        $this->em = $em;
        $this->dossierImport = $dossierImport;
    }

    // method that makes to import, receives full file directory
    public function load(ObjectManager $manager): void
    {
        // str_getcsv est une fonction incluse dans PHP qui lit une ligne d'un fichier CSV et renvoie un array.
        // array_map il va lancer la fonction pour chaque ligne du fichier
        // La fonction str_getcsv utilise le "," comme separator et le "" comme enclosure.
        // $arrayCsv = array_map("str_getcsv", file($this->dossierImport . DIRECTORY_SEPARATOR . "History_Quiz_db.csv"));

        $delimiter = ";"; // Set the delimiter to a ; character
        $arrayCsv = array_map(function ($row) use ($delimiter) {
            return str_getcsv($row, $delimiter); // la valeur de retour du callback
        }, file($this->dossierImport . DIRECTORY_SEPARATOR . "History_Quiz_db.csv"));

        // Maintenant on doit traiter l'array et créer les entités
        // dd($arrayCsv); // debugger ici est intéressant, on voit le contenu du fichier et s'il y a des lignes "inutiles"  (ici il y en aura deux, titre et en-têtes)
        unset ($arrayCsv[0]);
        // unset ($arrayCsv[1]);

        // pour chaque autre ligne on crée une entité et on la stocke dans la BD
        foreach ($arrayCsv as $ligneCsv){
            $qi = new QuizItem ();
            // $qi->setProposedBy($ligneCsv[1]);
            $qi->setTitle($ligneCsv[2]);
            $qi->setYear((int)$ligneCsv[3]);
            // $qi->setDescription($ligneCsv[4]);
            $qi->setLink($ligneCsv[5]);
            $qi->setImage($ligneCsv[6]);
            // si la Date n'est pas vide on la prends. Autrement on met null 
            // À vous de choisir si vous voulez juste créer l'entrée avec la date actuelle
            $qi->setSubmissionDate(!empty($ligneCsv[7]) ? new DateTime($ligneCsv[7]) : null);

            $this->em->persist ($qi);
            // dd($qi); // pour debugger avant de stocker...
        }
        // flushhhhhhhhhhhhhhhhh :))
        $this->em->flush();
    }
}