<?php

namespace App\DataFixtures;

use App\Entity\FutureEvent;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création de 50 faux évènements avec Fixtures et Faker
        $faker = Faker\Factory::create("fr_FR");

        for($i = 1; $i <= 50; $i++){

            $newFutureEvent = new FutureEvent();

            $newFutureEvent
                ->setEventDescription($faker->sentence(10))
                ->setEventDate( $faker->dateTimeBetween("now", "+10 years"))
            ;

            $manager->persist($newFutureEvent);

        }
        $manager->flush();
    }
}
