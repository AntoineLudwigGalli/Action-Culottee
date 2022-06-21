<?php

namespace App\DataFixtures;

use App\Entity\FutureEvent;
use App\Entity\User;
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

//        Fixtures user
        for($i = 1; $i <= 50; $i++){

            $newUser = new User();

            $newUser
                ->setEmail($faker->email)
                ->setRoles(["ROLE_USER"])
                ->setPassword($faker->password(60,60))
                ->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setMemberIdNumber('2022/123')
                ->setPhoneNumber($faker->numberBetween(10,10))
                ->setNewsletterOption($faker->numberBetween(0,1))
                ->setMembershipPaid($faker->numberBetween(0,1))
                ->setIsVerified($faker->numberBetween(0,1))
            ;

            $manager->persist($newUser);

        }
        $manager->flush();
    }
}
