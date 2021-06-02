<?php

namespace App\Tests\Controller;

use App\Tests\AbstractWebTestCase;

class UserControllerTest extends AbstractWebTestCase
{
    public function testUsersPageForUserMustFail()
    {
        $client = $this->getAuthenticatedClient();

        $client->request('GET', '/users');

        $this->assertResponseStatusCodeSame(403);
    }

    public function testUsersPageForAdmin()
    {
        $client = $this->getAuthenticatedAdminClient();

        $crawler = $client->request('GET', '/users');

        $this->assertSelectorTextSame('h1', 'Liste des utilisateurs');
        $this->assertEquals(2, $crawler->filter('table tbody tr')->count());
        $this->assertResponseIsSuccessful();
    }

    public function testCreateUser()
    {
        $client = $this->getAuthenticatedAdminClient();

        $crawler = $client->request('GET', '/users/create');

        $form = $crawler->filter('form[name="user"]')->selectButton('Ajouter')->form([
            'user[username]'   => 'newuser',
            'user[password][first]' => 'password',
            'user[password][second]' => 'password',
            'user[email]' => 'newuser@user.fr',
        ]);

        $client->submit($form);
        $this->assertResponseRedirects();
        $client->followRedirect();

        $this->assertSelectorTextSame('div.alert.alert-success', 'Superbe ! L\'utilisateur a bien été ajouté.');
        $this->assertResponseIsSuccessful();
    }

    public function testEditUser()
    {
        $client = $this->getAuthenticatedAdminClient();

        $crawler = $client->request('GET', '/users/7/edit');

        $form = $crawler->filter('form[name="user"]')->selectButton('Modifier')->form([
            'user[username]'   => 'modifiedusername',
            'user[password][first]' => 'modifiedpassword',
            'user[password][second]' => 'modifiedpassword',
            'user[role]' => 'ROLE_ADMIN',
        ]);

        $client->submit($form);
        $this->assertResponseRedirects();
        $client->followRedirect();

        $this->assertSelectorTextSame('div.alert.alert-success', 'Superbe ! L\'utilisateur a bien été modifié');
        $this->assertResponseIsSuccessful();
    }
}
