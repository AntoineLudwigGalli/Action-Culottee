<?php

namespace App\DataFixtures;

use App\Entity\FutureEvent;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {

        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {

        $faker = Faker\Factory::create("fr_FR");



        $admin = new User();

        $admin
            ->setEmail('admin@a.a')
            ->setFirstname($faker->firstName)
            ->setLastname($faker->lastName)
            ->setRoles(["ROLE_ADMIN"])
            ->setMemberIdNumber('2022/1')
            ->setPhoneNumber('0385110001')
            ->setNewsletterOption(1)
            ->setMembershipPaid(1)
            ->setIsVerified(1)

            ->setPassword( $this->encoder->hashPassword($admin, '/Admin1/'))
        ;

        $manager->persist($admin);


        $member = new User();

        $member
            ->setEmail('member@a.a')
            ->setFirstname($faker->firstName)
            ->setLastname($faker->lastName)
            ->setRoles(["ROLE_MEMBER"])
            ->setMemberIdNumber('2022/2')
            ->setPhoneNumber('0385110002')
            ->setNewsletterOption(1)
            ->setMembershipPaid(1)
            ->setIsVerified(1)

            ->setPassword( $this->encoder->hashPassword($member, '/Member1/'))
        ;

        $manager->persist($member);


        for($i = 1; $i <= 50; $i++){

            $newFutureEvent = new FutureEvent();

            $newFutureEvent
                ->setEventDescription($faker->sentence(10))
                ->setEventDate( $faker->dateTimeBetween("now", "+10 years"))
            ;

            $manager->persist($newFutureEvent);

        }

//        Fixtures user
        for($i = 3; $i <= 50; $i++){

            $newUser = new User();

            $newUser
                ->setEmail($faker->email)
                ->setRoles(["ROLE_USER"])
                ->setPassword($faker->password(60,60))
                ->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setMemberIdNumber('2022/'.$i)
                ->setPhoneNumber('03851162'.$faker->numberBetween(10,99))
                ->setNewsletterOption($faker->numberBetween(0,1))
                ->setMembershipPaid($faker->numberBetween(0,1))
                ->setIsVerified($faker->numberBetween(0,1))
            ;

            $manager->persist($newUser);

        }
        $manager->flush();
    }
}
