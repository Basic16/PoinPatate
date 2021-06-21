<?php

namespace App\DataFixtures;

use App\Entity\Calibre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class CalibresFixtures extends Fixture
{
    


    public function __construct(){
        $this->faker=Factory::create("fr_FR");
        
    }


        
    
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
      
        
        
        
        $calibres = [
            1 => [
                'calibre' => '35/55'
            ],
            2 => [
                'calibre' => '40/75'
            ],
            3 => [
                'calibre' => '50/75'
            ]
            ];

            foreach($calibres as $key => $value){
                $calibre = new Calibre();
                $calibre->setType($value['calibre']);
                $manager->persist($calibre);

                
                
            }

            $manager->flush();
        
    }



}
