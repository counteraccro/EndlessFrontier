# EndlessFrontier
Ce projet est un simulateur d'invasion de guilde disponible dans le jeu mobile EndlessFrontier

Information  
------------

Le projet fonctionne avec les versions suivantes :

Projet optimisé pour le navigateur Google Chrome

Version de PHP : 7.3.1  
Mysql : 5.7.24   
Apache : 2.4.3   
Javascript/Jquery 3.3.1  
Bootstrap 4.3.1  

Icônes 'Iconic' 
(https://useiconic.com/)


Données
------------

Attention, ce projet est fourni avec des jeux de données (Data-fixtures) dont certaines sont essentielles lors de la bascule en Production :
- Conserver le User 'admin'


Installation
------------

Étape 1 : cloner le dépôt GIT

`https://github.com/counteraccro/TLMC.git`

Étape 2 : Installer Symfony

`composer update`

Étape 3 : installer la base de données

`php bin/console doctrine:database:create`

Étape 4 : récupération des tables de la base de données

`php bin/console doctrine:schema:update --force`

Étape 5: installation des fixtures

`php bin/console doctrine:fixture:load`

Étape 6: accès au projet via l'url

`http://localhost:8000`


Dépendances
------------

Production  
sensio/framework-extra-bundle : ^5.1      
symfony/asset : 4.2.*      
symfony/console : 4.2.*      
symfony/dom-crawler : 4.2.*      
symfony/dotenv : 4.2.*      
symfony/expression-language : 4.2.*      
symfony/flex : ^1.1      
symfony/form : 4.2.*      
symfony/framework-bundle : 4.2.*      
symfony/monolog-bundle : ^3.1      
symfony/orm-pack : *      
symfony/process : 4.2.*      
symfony/security-bundle : 4.2.*      
symfony/serializer-pack : *      
symfony/swiftmailer-bundle : ^3.1      
symfony/translation : 4.2.*      
symfony/twig-bundle : 4.2.*      
symfony/validator : 4.2.*      
symfony/web-link : 4.2.*      
symfony/yaml : 4.2.*

Développement

doctrine/doctrine-fixtures-bundle : ^3.1      
symfony/debug-pack : *      
symfony/maker-bundle : ^1.0      
symfony/profiler-pack : *      
symfony/test-pack : *      
symfony/web-server-bundle : 4.2.*
