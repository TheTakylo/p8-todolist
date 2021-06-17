[![SymfonyInsight](https://insight.symfony.com/projects/17890c2c-074a-4d38-a269-95fc4e22ad0a/mini.svg)](https://insight.symfony.com/projects/17890c2c-074a-4d38-a269-95fc4e22ad0a)

ToDo & Co - Projet 8 du parcours DA - PHP / Symfony

========

- lien du projet : https://openclassrooms.com/projects/ameliorer-un-projet-existant-1
- lien du Github : https://github.com/TheTakylo/p8-todolist

========

## Sommaire

1. [Prérequis](#Prérequis)
2. [Installation](#Installation)
3. [Compte de test](#Compte-de-test)
4. [Tests](#Tests)
5. [Authentification](#Authentification)
6. [Audit de qualité & performance](#Audit_de_qualité_&_performance)

## Prérequis

PHP (>= 7.1)

## Installation

#### Cloner le projet et installer les dépendances

- ```git clone https://github.com/TheTakylo/p8-todolist.git```
- ```composer install```


#### Configuration du fichier .env

- ``` APP_ENV=dev # mettre "prod" pour la mise ne production``` 
- ``` APP_SECRET=92fcc46d55ffda903d0f1f67494bd14b # a modifier```
- ``` DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7" # a configurer```

#### Créer la base de données et charger les fixtures

- ```php bin/console doctrine:database:create```
- ```php bin/console doctrine:schema:create```
- ```php bin/console doctrine:fixtures:load```

### Démarer d'application

- ```symfony serve```

## Compte de test

#### identifiants / mot de passe

- ```user``` / ```user``` (utilisateur)
- ```admin``` / ```admin``` (administrateur)

## Tests

#### Installation - Créer la base de données et charger les fixtures

- ```php bin/console doctrine:database:create --env=test```
- ```php bin/console doctrine:schema:create --env=test```
- ```php bin/console doctrine:fixtures:load --env=test```

#### Lancer les tests

- ```./bin/phpunit```

## Authentification

> Voir en détail [l'authentification](AUTHENTICATION.md)

## Audit de qualité & performance

> Voir en détail [l'audit de qualité & performance](AUDIT_PERFORMANCE_QUALITE.pdf)