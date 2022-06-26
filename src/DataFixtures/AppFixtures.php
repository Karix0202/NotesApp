<?php

namespace App\DataFixtures;

use App\Entity\Note;
use DateTime;
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
        $colors = ['default', 'green', 'yellow', 'blue', 'red'];
        for ($i = 0; $i < 20; $i++) {
            $note = new Note();
            $note
                ->setTitle($this->faker->realText(20))
                ->setContent($this->faker->realText(120))
                ->setCreatedAt(new DateTime())
                ->setColor($colors[rand(0, count($colors) - 1)])
            ;

            $manager->persist($note);
        }

        $manager->flush();
    }
}
