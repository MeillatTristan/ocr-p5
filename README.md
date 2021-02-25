# ocr-p5

## contexte (titre + rappel projet + lien codacy (badge) )
[![SymfonyInsight](https://insight.symfony.com/projects/298b5fcf-0828-4207-b5ca-5c4696451c88/mini.svg)](https://insight.symfony.com/projects/298b5fcf-0828-4207-b5ca-5c4696451c88)

Dans le cadre du projet 5 de la formation OpenClassrooms "Développeur d'application web" en spécialisation symfony, nous devions créer un blog personnel qui représentera notre portfolio.

### Compte administrateur 

email:password
jean.dupont@gmail.com:Azerty1234!

### Fonctionnalités 

Les principales fonctionnalités du blog peuvent être décomposer en trois parties en fonction des droits de l'utilisateur :

#### Visiteur :
* Accès à la page d'accueil
* Envoie formulaire de contact
* Voir les différents projets

#### Inscrits :
* Même accès que les visiteurs
* Possibilités de poster des commentaires

#### Administrateur : 
* Possibilité de modifier et supprimer un article
* Possibilité de supprimer et de donner les droits admin à un utilisateur
* Possibilité de supprimer et de valider les commentaires

## prérequis

PHP avec composer est requis pour pouvoir installer le projet ainsi que serveur fictif tel que wamp.

## installation

### Etape 1 : 

Cloner le projet sur votre serveur avec cette commande : 
```bash
git clone https://github.com/MeillatTristan/ocr-p5.git
```

### Etape 2 :

Créer une base donnée et importé le fichier portfolio.sql

### Etape 3 : 

Editer le fichier de configuration de la base de donnée qui se trouve ici : ```src\Database\ConfigDatabase.php```

### Etape 4 : 

Pour finaliser l'installation du projet il va juste falloir installer les différentes dépendances à l'aide de composer et de cette commande :
```bash
composer install
```

Le projet est maintenant fonctionnel, vous pouvez vous connecter en tant qu'administrateur à l'aide du compte d'exemple.


## paramétrage

## utilisation
