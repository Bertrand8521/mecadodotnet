Site internet créé par
- BISELX Charles
- ESCAMILLA Valentin
- MEDJMADJ Issam
- PENGUILLY Bertrand

```
$ Le Boilerplate de base https://github.com/zhiephie/boilerplate-slim3
```

##CONDITIONS

    PHP 5.5 or newer
    PDO PHP Extension

###FONCTIONNALITÉS

    PHP View
    Twig Template Engine
    Eloquent Laravel
    Sentinel Authentication provider
    Include SDK Facebook
    Logger Monolog
    AdminLTE soon

##INSTALLATION

Téléchargez le dossier du dépot git dans le dossier racine de votre serveur
```
git clone git@github.com:Bertrand8521/mecadodotnet.git
```

Tapez la commande :
```
composer install
```

Configurez le fichier database.php dans le dossier config en fonction de la base de donnée.

```
'driver'    => 'mysql',
'host'      => 'localhost',
'database'  => 'mecadodotnet',
'username'  => '',
'password'  => '',
'charset'   => 'utf8',
'collation' => 'utf8_unicode_ci',
'prefix'    => 'mecado',
```
dans le terminal entrez les commandes ci-dessous pour changer les permissions:
```
chmod -R 777 storage
chmod 666 config/database.php
```

puis dans le terminal, migrez les tables de la base de données avec :
```
php migrate
```

##Lancement du serveur

ouvrez le terminal à la base du projet et tapez la commande suivante :
```
$ php -S localhost:8000
```

le site est maintenant accessible via le port 8000.
