<?php

namespace App\DataFixtures;

use App\Config\NoteColor;
use App\Entity\Folder;
use App\Entity\Note;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    private const FOLDER_NUM = 5;
    private const NOTE_NUM_PER_FOLDER = 5;

    public Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        $colors = ['default', 'green', 'yellow', 'blue', 'red'];

        for ($i = 0; $i < self::FOLDER_NUM; $i++) {
            $folder = new Folder();
            $folder
                ->setName($this->faker->realText(20))
                ->setCreatedAt(new DateTime())
            ;
            $manager->persist($folder);

            for ($j = 0; $j < self::NOTE_NUM_PER_FOLDER; $j++) {
                $note = new Note();
                $note
                    ->setTitle($this->faker->realText(20))
                    ->setContent($this->faker->realText(120))
                    ->setCreatedAt(new DateTime())
                    ->setColor(
                        NoteColor::cases()[rand(0, count(NoteColor::cases()) - 1)]
                    )
                    ->setFolder($folder)
                ;

                $manager->persist($note);
            }
        }

        $manager->flush();
    }
}
