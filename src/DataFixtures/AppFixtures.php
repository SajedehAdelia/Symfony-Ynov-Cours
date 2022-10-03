<?php

namespace App\DataFixtures;
use App\entity\PlaceName;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Migrations\Generator\Generator as GeneratorGenerator;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;


class AppFixtures extends Fixture
{

    private Generator $faker;

    public function __construct(){
        $this->faker = Factory::create('en_GB');
    }
    
    public function load(ObjectManager $manager): void
    { 
       // $places = file_get_contents("./france.json");

        for($i = 1; $i< 100; $i++) {
       
        // $product = new Product();
        // $manager->persist($product);
        $place = new PlaceName();

        $place->setPlaceType($this->faker->words(3, true));
        $place->setPlacePrice($this->faker->randomNumber(3, false));
        $place->setPlaceID($this->faker->randomNumber(3, false));

    

        $manager->persist($place);
     }
        $manager->flush();
    }
}
