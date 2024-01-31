<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Cake;

class CakeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $chocolatIngredient = $this->getReference('Chocolat');
        $sucreIngredient = $this->getReference('Sucre');
        $oeufIngredient = $this->getReference('Œufs');

        for ($i = 0; $i < 5; $i++) {
            $cake = new Cake();
            $cake->setTitle('Cake Title' . $i);
            $cake->setPicture('cake_image_' . $i . '.jpg');
            $cake->addIngredient($chocolatIngredient);
            $cake->addIngredient($sucreIngredient);
            $cake->addIngredient($oeufIngredient);

            $manager->persist($cake);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            IngredientFixtures::class,
        ];
    }
}
