<?php

namespace App\DataFixtures;
use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use App\entity\PlaceName;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Doctrine\Migrations\Generator\Generator as GeneratorGenerator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private Generator $faker;
    private UserPasswordHasherInterface $passwordHasher;

   

    public function __construct(UserPasswordHasherInterface $passwordHasher){
        $this->faker = Factory::create('en_GB');
        $this ->userPasswordHasher =  $passwordHasher;
    }
    

     /**
         * class hasher is password
         *
         * @var UserPasswordHasherInterface
         */


    public function load(ObjectManager $manager): void
    { 
       
        for ($i=0;$i<3; $i++){
            $adminUser = new User();
            $password = $this->faker->password(2, 6);
            $adminUser->setUsername("user".$i)
                ->setRoles(["ROLE_USER"])
                ->setPassword($this->userPasswordHasher->hashPassword($adminUser, $password));
                $manager->persist($adminUser);
        }
       // $places = file_get_contents("./france.json");

       
        $userUser = new User();
        $password = 'password';
        $userUser->setUsername("admin")
            ->setRoles(["ADMIN"])
            ->setPassword($this->userPasswordHasher->hashPassword($userUser, $password));
            $manager->persist($userUser);

    
        for($i = 1; $i< 100; $i++) {
       
        // $product = new Product();
        // $manager->persist($product);
        $place = new PlaceName();

        $place->setPlaceType($this->faker->words(3, true));
        $place->setPlacePrice($this->faker->randomNumber(3, false));
        $place->setPlaceID($this->faker->randomNumber(3, false));
        $place->setStatusPlaceName(true);
        $manager->persist($place);
     }
        $manager->flush();
    }
}
