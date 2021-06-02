<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    /** @var UserRepository $userRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager)
    {
        $users = $this->userRepository->findAll();

        foreach ($users as $u) {
            for ($i = 0; $i < 3; $i++) {
                $task = new Task();

                $task->setUser($u)
                    ->setTitle('Tâche ' . $i)
                    ->setContent('Contenu de la tâche ' . $i)
                    ->setCreatedAt(new \DateTime())
                    ->setIsDone(false);

                $manager->persist($task);
            }

            if (in_array('ROLE_ADMIN', $u->getRoles())) {
                $task = new Task();

                $task
                    ->setTitle('Tâche anonyme')
                    ->setContent('Contenu de la tâche ')
                    ->setCreatedAt(new \DateTime())
                    ->setIsDone(false);

                $manager->persist($task);
            }
        }

        $manager->flush();
    }


    public function getDependencies()
    {
        return [UserFixtures::class];
    }
}
