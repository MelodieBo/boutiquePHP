<?php 

require_once 'inc/init.php' ;
$message = ''; // pour le message de déconnexion

// 2 - quand l'internaute demande la déconnexion :
// debug($_GET);

if(isset($_GET['action']) && $_GET['action'] == 'deconnexion') { // si existe l'indice action dans $_GET et que sa valeur est égale à 'deconnexion', on déconnecte l'internaute

    unset($_SESSION['membre']); // on supprime les infos du membre de la session
    $message = '<div class="alert alert-info">Vous êtes déconnecté</div>';

}

// 3 - si l'internaute est déja connecté, on le revoit dans son profil :
if (estConnecte()) {
    header('location:profil.php'); // on fait une redirection vers le profil pour éviter de se connecter plusieurs fois
    exit(); 
}

// debug($_POST);

if ($_POST) { // si le formulaire est envoyé

    if (empty($_POST['pseudo']) || empty($_POST['mdp'])) {

        $contenu .= '<div class="alert alert-danger"> Les identifiants sont obligatoires</div>';

    }
    // si pas d'erreur affichées, on peut vérifier le pseudo et le mdp en BDD :

        if (empty($contenu)) {

            $resultat = executeRequete("SELECT * FROM membre WHERE pseudo = :pseudo", array(':pseudo' => $_POST['pseudo'])); // on selectionne le membre avec le pseudo fourni pour vérifier qu'il existe.

            if ($resultat->rowCount() == 1) { // si il y a une ligne, c'est que le pseudo existe en BDD 
                $membre = $resultat-> fetch(PDO::FETCH_ASSOC); // on transforme l'objet pdostatement en tableau pour en extraire le mdp
                // debug($membre);
                // On vérifie le mdp :

                if (password_verify($_POST['mdp'], $membre['mdp'])) { // retourne true si le hash du mdp en BDD correspond au mdp de connexion

                    $_SESSION['membre'] = $membre; // on rempli la session avec un indice membre et toute les infos du membre provenant de la BDD en valeurs

                    header('location:profil.php'); // une fois les identifiants corrects, et la session remplie, on redirige l'internaute vers la page profil.php 
                    exit(); // pour qutter le script

                } else {
                    $contenu .= '<div class="alert alert-danger"> Erreur sur les identifiants</div>';
                }
             
            } else { // sinon le pseudo n'existe pas
                $contenu .= '<div class="alert alert-danger"> Erreur sur les identifiants</div>';
            }
            
        } // fin du if (empty($contenu))


} // fin du if ($_POST)

//--------- AFFICHAGE ---------------
require_once 'inc/header.php' ;
?>

<h1 class="mt-4">Connexion</h1>


<div class="container">
    <div class="row">
        <div class="order-2 col-md-6 col-sm-12 mt-3"">
            <?php
            echo $message; // pour le message de déconnexion
            echo $contenu; // pour les autres messages
            ?>
        </div>


        <form action="" method="post" class="order-1 col-md-6 col-sm-12 mt-3 p-5">
            <label for="pseudo">Pseudo</label><br>
            <input type="text" name="pseudo" id="pseudo"><br>

            <label for="mdp">Mot de passe</label><br>
            <input type="password" name="mdp" id="mdp"><br>

            <button type="submit" class="btn btn-primary mt-3">Se connecter</button>
        </form>
    </div>
</div>

<?php require_once 'inc/footer.php' ;?>