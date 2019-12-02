<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ma boutique</title>

    <!-- CDN Bootstrap -->
    <!-- CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab&display=swap" rel="stylesheet">

    <style>

        .height {
            min-height: 80vh;
        }

        body {
            font-family: 'Roboto Slab', serif;
        }

        h1 {
            color: #3A3B3F;
        }

        h2 {
            color: orange;
        }

        form, .profil{
            -webkit-box-shadow: 0px 0px 10px 0px rgba(179,179,179,0.6);
            -moz-box-shadow: 0px 0px 10px 0px rgba(179,179,179,0.6);
            box-shadow: 0px 0px 10px 0px rgba(179,179,179,0.6);
        }

        #btn {
            box-shadow: none;
        }

        ::placeholder {
            text-align: center;
        }

        .coordonees {
            font-weight : 700;
            text-transform : uppercase;
            background-color : #f5f5f5;
            width: 20%;
        }

        .btn-radio {
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }

        .radio {
            padding: 1rem;
        }

        label {
            margin-bottom: 0rem;
        }

        h6 {
            margin-top: 3rem;
        }

        th {
            border-right: 3px solid #f5F5F5;
        }

        p {
            font-size : 0.7rem;
        }
        .man {
            color: #3DBCAA;
        }

        .woman {
            color: #DAB139;
        }

        .mixte {
            color: #895072;
        }
    
    </style>

</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <!-- Marque -->
            <a class="navbar-brand" href="<?php echo RACINE_SITE; ?>index.php">Ma boutique</a>
            <!-- Menu -->
            <div class="collapse navbar-collapse" id="nav1">
                <ul class="navbar-nav ml-auto">
                <?php
                echo '<li><a class="nav-link" href="'. RACINE_SITE .'index.php">Boutique</a></li>';
                if(estConnecte()) { // menu du membre connecté
                    echo '<li><a class="nav-link" href="'. RACINE_SITE .'profil.php">Profil</a></li>';
                    echo '<li><a class="nav-link" href="'. RACINE_SITE .'connexion.php?action=deconnexion">Se déconnecter</a></li>';
                } else { // menu du membre non connecté
                    echo '<li><a class="nav-link" href="'. RACINE_SITE .'inscription.php">Inscription</a></li>';
                    echo '<li><a class="nav-link" href="'. RACINE_SITE .'connexion.php">Connexion</a></li>';
                }
                if (estAdmin()) { // menu de l'admin
                    echo '<li><a class="nav-link" href="'. RACINE_SITE .'admin/gestion_boutique.php">Gestion de la boutique</a></li>';
                }  
                ?>
                </ul>
            </div><!-- fin menu -->
        </div> <!-- .container -->
    </nav>
    
    <!-- Ouverture du contenu de la page -->

    <div class="container height">
        <div class="row">
            <div class="col-12">
            
