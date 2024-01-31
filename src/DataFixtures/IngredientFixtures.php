<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class IngredientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $donneesIngredient = [
            [
                'product' => 'Farine',
                'weight' => 500,
                'mass' => 'g',
            ],
            [
                'product' => 'Sucre',
                'weight' => 300,
                'mass' => 'g',
            ],
            [
                'product' => 'Œufs',
                'weight' => 6,
                'mass' => 'g',
            ],
            [
                'product' => 'Lait',
                'weight' => 30,
                'mass' => 'ml',
            ],
            [
                'product' => 'Eau',
                'weight' => 10,
                'mass' => 'ml',
            ],
            [
                'product' => 'Chocolat',
                'weight' => 150,
                'mass' => 'g',
            ],
            [
                'product' => 'Beure',
                'weight' => 90,
                'mass' => 'g',
            ],
            [
                'product' => 'Levure',
                'weight' => 70,
                'mass' => 'g',
            ],
            [
                'product' => 'Huile',
                'weight' => 10,
                'mass' => 'ml',
            ],
        ];

        foreach ($donneesIngredient as $donnees) {
            $ingredient = new Ingredient();
            $ingredient
                ->setProduct($donnees['product'])
                ->setWeight($donnees['weight'])
                ->setMass($donnees['mass']);

            $this->addReference($donnees['product'], $ingredient);

            $manager->persist($ingredient);

        }

        $manager->flush();
    }
}
