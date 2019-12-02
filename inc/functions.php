<?php 

function debug($param) {
    echo "<pre>";
        var_dump($param);
    echo "</pre>";
}

// Fonctions relatives au membres :

    // 1 - Fonction qui vérifie si le membre est connecté :
        function estConnecte() {

            if (isset($_SESSION['membre'])) { // si l'indice "membre" existe dans la session, c'est que le membre est passé par la page de connexion et qu'il s'est correctement identifié (voir connexion.php)
                return true; // il est connecté 
            } else {
                return false; // il n'est pas connecté
            }
        }

    // 2 -  Fonction qui vérifie si le membre est administrateur :
        function estAdmin () {

            if ( estConnecte() && $_SESSION['membre']['statut'] == 1) { // si le memebre est connecté ET que son statut vaut 1, il est donc admin connecté
                return true;
            } else {
                return false;
            }
        }

    // 3 - Fonction qui réalise les requêtes préparées pour nous :
    // $membre = executeRequete("SELECT * FROM membre WHERE pseudo = :pseudo", array(':pseudo' => $_POST['pseudo']));

    function executeRequete($requete, $param = array()) { // $requete attend une requete SQL sous forme de string. $param attend un array qui associe les marqueurs à leur valeur, sinon prend un array vide par défaut si on ne lui donne rien.

        if(!empty($param)) { // si on a  bien un tableau, on peut faire la boucle dessus
            foreach ($param as $indice => $valeur) {
                $param[$indice] = htmlspecialchars($valeur); // pour transformer les chevrons en entité HTML
            } 
        }

        global $pdo; // pour accéder à cette variable définie dans l'espace global du fichier init.php

        $resultat = $pdo->prepare($requete); // on prépare la requête reçue
        $succes = $resultat->execute($param); // on éxécute la requête avec le tableau qui associe les marqueurs aux valeurs

        if ($succes) {
            return $resultat; // retourne l'objet PDOStatement en cas de succès de la requete
        } else {
            return false; // retourne false en cas d'échec
        }
    }

?>