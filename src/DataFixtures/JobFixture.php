<?php

namespace App\DataFixtures;

use App\Entity\Job;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

;

class JobFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for($i=0;$i<30;$i++) {
            $job = new Job();
            $job->setDesignation($faker->jobTitle);
            $manager->persist($job);
        }
        $manager->flush();
        $manager->flush();
    }
}
