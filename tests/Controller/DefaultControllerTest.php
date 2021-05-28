<?php

namespace App\Tests\Controller;

use App\Tests\AbstractWebTestCase;

class DefaultControllerTest extends AbstractWebTestCase
{
    public function testHomepageIsUp()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
    }

    public function testHomepageUnauthenticated()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertSelectorTextSame('.container > .row > a.btn.btn-success', 'Se connecter');
        $this->assertResponseIsSuccessful();
    }

    public function testHomepageAuthenticatedForUser()
    {
        $client = $this->getAuthenticatedClient();
        $client->request('GET', '/');

        $this->assertSelectorTextSame('.container > .row > a.pull-right.btn.btn-danger', 'Se déconnecter');
        $this->assertSelectorNotExists('.container > .row > a.btn.btn-primary');
        $this->assertResponseIsSuccessful();
    }

    public function testHomepageAuthenticatedForAdmin()
    {
        $client = $this->getAuthenticatedAdminClient();
        $client->request('GET', '/');

        $this->assertSelectorTextContains('.container > .row > a.btn.btn-primary', 'Créer un utilisateur');
        $this->assertResponseIsSuccessful();
    }
}
