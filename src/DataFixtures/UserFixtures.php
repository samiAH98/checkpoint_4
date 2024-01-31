<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Données de la fixture
        $donneesUtilisateur = [
            [
                'email' => 'doug.doe@example.com',
                'roles' => ['ROLE_ADMIN'],
                'password' => 'tototata',
                'lastname' => 'Doe',
                'firstname' => 'Doug',
            ],
            [
                'email' => 'chanel.doe@example.com',
                'roles' => ['ROLE_USER'],
                'password' => 'taratata',
                'lastname' => 'Doe',
                'firstname' => 'Chanel',
            ],
            [
                'email' => 'mike.doe@example.com',
                'roles' => ['ROLE_USER'],
                'password' => 'azertyui',
                'lastname' => 'Doe',
                'firstname' => 'Mike',
            ],
        ];

        foreach ($donneesUtilisateur as $donnees) {
            $utilisateur = new User();
            $utilisateur
                ->setEmail($donnees['email'])
                ->setPassword($donnees['password'])
                ->setLastname($donnees['lastname'])
                ->setFirstname($donnees['firstname']);

            $hashedPassword = $this->passwordHasher->hashPassword($utilisateur, $donnees['password']);
            $utilisateur->setPassword($hashedPassword);

            $manager->persist($utilisateur);
        }

        $manager->flush();
    }
}
