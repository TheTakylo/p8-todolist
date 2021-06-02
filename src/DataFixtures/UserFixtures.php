<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /** @var UserPasswordEncoderInterface $encoder */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $users = [
            ['username' => 'user', 'email' => 'user@user.fr', 'password' => 'user', 'role' => 'ROLE_USER'],
            ['username' => 'admin', 'email' => 'admin@admin.fr', 'password' => 'admin', 'role' => 'ROLE_ADMIN'],
        ];

        foreach ($users as $u) {
            $user = new User();
            $user->setEmail($u['email']);
            $user->setUsername($u['username']);
            $user->setRole($u['role']);

            $password = $this->encoder->encodePassword($user, $u['password']);
            $user->setPassword($password);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
