<?php

require_once '../inc/init.php';

// Exercice :

/*

Vous créez la page de gestion des membres.
    1- seul un admin à accès a cette page. Les autres sont redirigés vers connexion.php
    2- affichez sous forme de <table> tous les membres inscrits, avec toutes les infos SAUF le mdp
    3- affichez le nombre de membres
    4- pour chaque membre, vous ajoutez un lien "supprimer" qui permet de supprimer le membre en BDD SAUF l'admin (vous même) qui est connecté.

*/

// 1- seul un admin à accès a cette page. Les autres sont redirigés vers connexion.php
if (!estAdmin()) {
    header('location:../connexion.php'); // on fait une redirection vers le profil pour éviter de se connecter plusieurs fois
    exit(); 
}

// 3- Suppression d'un membre :
if(isset($_GET['supprimer_membre']))
    {	// on ne peut pas supprimer son propre profil :
        if ($_GET['supprimer_membre'] != $_SESSION['membre']['id_membre']) {
          executeRequete("DELETE FROM membre WHERE id_membre=:id_membre", array(':id_membre' => $_GET['supprimer_membre']));
        } else {
          $contenu .= '<div class="alert alert-danger mt-4">Vous ne pouvez pas supprimer votre propre profil ! </div>';
        }
        
    }

// 2- affichez sous forme de <table> tous les membres inscrits, avec toutes les infos SAUF le mdp
$resultat = executeRequete("SELECT id_membre, pseudo, nom, prenom, email, civilite, ville, code_postal, adresse, statut FROM membre");
// 3- affichez le nombre de membres
$contenu .= '<h6> Nombre de membre inscrit : ' . $resultat->rowCount() . '</h6>';

$contenu .= '<div class="table-responsive"><table class="table table-striped">';
    // Affichage des entêtes :
    $contenu .='<thead class="thead-dark"><tr>';
      $contenu .=  '<th> id_membre </th>';
      $contenu .=  '<th> pseudo </th>';
      $contenu .=  '<th> nom </th>';
      $contenu .=  '<th> prénom </th>';
      $contenu .=  '<th> email </th>';
      $contenu .=  '<th> civilité </th>';
      $contenu .=  '<th> ville </th>';
      $contenu .=  '<th> CP </th>';
      $contenu .=  '<th> adresse </th>';
      $contenu .=  '<th> statut </th>';
      $contenu .=  '<th> Supprimer </th>';
    $contenu .='</tr></thead>';
    // Fin affichage des entêtes

  while ($membre = $resultat-> fetch(PDO::FETCH_ASSOC)) {
    $contenu .='<tbody><tr>';
      foreach ($membre as $information) {
        $contenu .=  '<td>' . $information . '</td>';
      }
      $contenu .=  '<td><a href="?supprimer_membre=' . $membre['id_membre'] . '" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer ce membre?\'));"> X </a></td>';
    $contenu .='</tr></tbody>'; 
  }
$contenu .= '</table></div>';

require_once '../inc/header.php';


?>

<h1 class="mt-4">Gestion membre</h1>

<div class="container mt-4">
    <div class="row">
        <div class="col">
        <ul class="nav nav-tabs">
            <li><a class="nav-link" href="gestion_boutique.php">Affichage des produits</a></li>
            <li><a class="nav-link" href="formulaire_produit.php">Ajout d'un produit</a></li>
            <li><a class="nav-link active" href="gestion_membre.php">Gérer les membres</a></li>
        </ul>
        </div>
    </div>
</div>

<?php 

echo $contenu;

require_once '../inc/footer.php';

?>

