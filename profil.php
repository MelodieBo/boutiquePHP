<?php 
require_once 'inc/init.php' ;
require_once 'inc/header.php' ;


//----------------------- Exercice : créer la page profil

// 1 - Si le visiteur n'est pas connecté, vous le redirigez vers la page de connexion (il ne doit pas accéder au profil).

if (!estConnecte()) {
    header('location:connexion.php'); // on fait une redirection vers le profil pour éviter de se connecter plusieurs fois
    exit(); 
} 


// 2 - Vous affichez son profil selon le shéma du tableau

// Methode 1 : plus facile - Tous les éléments sont dans la SESSION :

//debug($_SESSION);
extract($_SESSION['membre']); // extrait tous les indices de l'array sous forme de variables auxquelles on affecte la valeur. Exemple $_SESSION['membre']['pseudo'] devient $pseudo


// Méthode 2 : plus compliqué - En allant chercher les infos dans la BDD :

// $resultat = executeRequete("SELECT * FROM membre WHERE pseudo = :pseudo", array(':pseudo' => $_SESSION['membre']['pseudo']));
// debug($resultat);
// $coordonnees = $resultat-> fetch(PDO::FETCH_ASSOC);
// debug($coordonnees);
// extract($coordonnees); // possible de faire un extract de tous les array sauf numérique 
?>

<h1 class="mt-4">Profil</h1>

<div class="container profil p-5">
    <div class="row">
        <div class="col">
            <h2>Bonjour <?php echo $prenom . ' ' . $nom ?></h2>
            <?php
            if (estAdmin()){
                echo '<p>Vous êtes un administrateur</p>';
            } else {
                echo '<p>Vous n\'êtes pas un administrateur</p>';
            }
            ?>
            <h2>Vos coordonées :</h2>
            <div class="coordonees">Votre email :</div><p> <?php echo $email ?></p>
            <div class="coordonees">Votre adresse :</div><p> <?php echo $adresse ?></p>
            <div class="coordonees">Votre code postal :</div><p> <?php echo $code_postal ?></p>
            <div class="coordonees">Votre ville :</div><p> <?php echo $ville ?></p>
        </div>
    </div>
</div>

<?php require_once 'inc/footer.php' ;?>
