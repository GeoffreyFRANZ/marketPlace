<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for($i = 0; $i < 100; $i++) {
            $product = new  Product();
            $product->setLabel($faker->word());
            $product->setPrice($faker->randomFloat(2,0, 5000 ));
            $product->setDescription($faker->text(1000));
            $manager->persist($product);
            $manager->flush();
        }
    }
}
