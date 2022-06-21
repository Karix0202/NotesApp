<?php

namespace App\DataFixtures;

use App\Entity\Note;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    public Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadNotes($manager);
    }

    public function loadNotes(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++)
        {
            $note = new Note();
            $note
                ->setTitle($this->faker->realText(20))
                ->setContent($this->faker->realText(120))
                ->setCreatedAt(new \DateTime())
            ;

            $manager->persist($note);
        }

        $manager->flush();
    }
}
