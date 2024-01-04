<?php

namespace App\DataFixtures;

use App\Entity\Person;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

;

class PersonFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for($i = 0; $i < 100; $i++) {
         $person = new Person();
         $person->setName($faker->name);
         $person->setFirstname($faker->firstName);
         $person->setAge($faker->numberBetween(18,65));
         $manager->persist($person);
        }
        $manager->flush();
    }
}
