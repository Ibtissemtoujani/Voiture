<?php

namespace App\DataFixtures;

use App\Entity\Marque;
use App\Entity\Modele;
use App\Entity\Voiture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $marque1 = new Marque();
        $marque1 -> setlibelle("Toyota");
        $manager ->persist($marque1);

        $marque2 = new Marque();
        $marque2 -> setlibelle("Jeupo");
        $manager ->persist($marque2);

        $modele1 = new Modele();
        $modele1 -> setlibelle("Rayis")
                -> setImage("modele1.jpg")
                -> setPrixMoyen(15000)
                -> setMarque($marque1);
        $manager ->persist($modele1);

        $modele2 = new Modele();
        $modele2 -> setlibelle("Rayis")
                -> setImage("modele2.jpg")
                -> setPrixMoyen(17000)
                -> setMarque($marque2);
        $manager ->persist($modele2);

        $modele3 = new Modele();
        $modele3 -> setlibelle("007")
                -> setImage("modele3.jpg")
                -> setPrixMoyen(20000)
                -> setMarque($marque1);
        $manager ->persist($modele3);

        $modele4 = new Modele();
        $modele4 -> setlibelle("008")
                -> setImage("modele4.jpg")
                -> setPrixMoyen(25000)
                -> setMarque($marque1);
        $manager ->persist($modele4);

        $modele5 = new Modele();
        $modele5 -> setlibelle("009")
                -> setImage("modele5.jpg")
                -> setPrixMoyen(30000)
                -> setMarque($marque2);
        $manager ->persist($modele5);

        $modeles = [$modele1, $modele2, $modele3, $modele4, $modele5];
        $faker = \Faker\Factory::create("fr_FR");
        foreach($modeles as $m)
        {
            $rand = rand(3,5);
            for($i=1; $i <= $rand; $i++){
                $voiture = new Voiture();
                $voiture ->setImmatriculation($faker->regexify("[A-Z]{2}[0-9]{4}[A-Z]{2}"))
                            ->setNbPortes($faker->randomElement($array = array(3,5)))
                            ->setAnnee($faker->numberBetween($min = 1990, $max = 2020))
                            ->setModele($m);
                $manager ->persist($voiture);
            }
        }



        $manager->flush();
    }
}
