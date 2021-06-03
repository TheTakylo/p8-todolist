# Authentification

L'authentification est faite grâce au composant [security](https://symfony.com/doc/current/components/security.html) de Symfony

### Page d'authentification

L'URL est la page d'authentification est ```/login```

L'authentification se fait via un formulaire de connexion


```yaml
# config/packages/security.yml

firewalls:
    # ...
    main:
        anonymous: ~
        pattern: ^/
        form_login:
            login_path: login
            check_path: login_check
            always_use_default_target_path:  true
            default_target_path:  /
        logout: ~
```

L'authentification après la soumission du formulaire est ensuite gérée par le [SecurityController](src/Controller/SecurityController.php) et la méthode **login**

```php
// src/Controller/SecurityController.php
    
    // ...    
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $utils): Response
    {
        return $this->render('security/login.html.twig', array(
            'last_username' => $utils->getLastUsername(),
            'error'         => $utils->getLastAuthenticationError(),
        ));
    }
```
--- 

#### Les utilisateurs sont stockés en base de données

Voir l'entité [User](src/Entity/User.php)

Les utilisateurs sont chargés par le fichier [security.yml](config/packages/security.yaml)

```yaml
providers:
    app_user_provider:
        entity:
            class: App\Entity\User
            property: username
```