<?php

namespace App\Tests\Controller;

use App\Tests\AbstractWebTestCase;

class SecurityControllerTest extends AbstractWebTestCase
{
    public function testLoginPageIsUp()
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
    }

    public function testLoginFormWithBadCredentials()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->filter('form')->selectButton('Se connecter')->form([
            '_username'    => 'badusername',
            '_password' => 'badpassword'
        ]);

        $client->submit($form);
        $client->followRedirect();

        $this->assertSelectorTextSame('div.alert.alert-danger', 'Invalid credentials.');
        $this->assertResponseIsSuccessful();
    }

    public function testLoginForm()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->filter('form')->selectButton('Se connecter')->form([
            '_username'    => 'user',
            '_password' => 'user'
        ]);

        $client->submit($form);
        $this->assertResponseRedirects(); // TODO: check why relative path cannot be used
        $client->followRedirect();

        $this->assertSelectorTextSame('div.container > div.row > a.pull-right.btn.btn-danger', 'Se déconnecter');
        $this->assertResponseIsSuccessful();
    }
}
