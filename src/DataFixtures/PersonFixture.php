<?php

namespace App\DataFixtures;

use App\Entity\Hobby;
use App\Entity\Job;
use App\Entity\Person;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
#[HasLifecycleCallbacks()]
class PersonFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $jobs = $manager->getRepository(Job::class)->findAll();
        $hobbies = $manager->getRepository(Hobby::class)->findAll();

        $faker = Factory::create('fr_FR');
        for($i = 0; $i < 100; $i++) {
         $person = new Person();
         $person->setName($faker->name);
         $person->setFirstname($faker->firstName);
         $person->setAge($faker->numberBetween(18,65));
//         Ajoute un job à cette personne
         $person->setJob($jobs[$i % count($jobs)]);
//         Ajoute un job à cette personne
         for ($j=$i; $j < $i+3; $j++) {
             $person->addHobby($hobbies[$j % count($hobbies)]);
         }
         $person->setJob($jobs[$i % count($jobs)]);
         $manager->persist($person);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            JobFixture::class,
            HobbyFixture::class
        ];
    }
}
