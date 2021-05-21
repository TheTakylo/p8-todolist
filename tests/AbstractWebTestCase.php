<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractWebTestCase extends WebTestCase
{
    public function getAuthenticatedClient(): KernelBrowser
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('a@a.fr');
        $client->loginUser($testUser);

        return $client;
    }
}
