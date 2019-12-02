<?php

// Ce fichier sera inclus dans tous les scipts (hors inclusions) pour initialiser les éléments suivants :

    // 1 - La connexion à la BDD :
    $pdo = new PDO("mysql:host=localhost;dbname=boutique", 
    "root",
    "root", 
    array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, 
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    ));

    // 2 - La création ou l'ouverture des sesssions :
    session_start();
    
    // 3 - Une constante contenant le chemin du site :
    define('RACINE_SITE', '/php/08-site/'); // indique le ou les dossiers dans lesquels se situe le site sans "localhost". Permet de créer des chemins absolus utilisés noramment dans le header.php du site.

    // 4 - Les variables d'affichage :
    $contenu = '';
    $contenu_gauche = '';
    $contenu_droite = '';

    // 5 - Inclusion des fonctions :
    require_once 'functions.php'; // le fichier function.php est dans le même dossier que ce fichier init.php

    ?>