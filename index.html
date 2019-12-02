<?php
require_once 'inc/init.php';
// 1- affichage des catégories d'articles :
$resultat = executeRequete("SELECT DISTINCT categorie FROM produit");

$contenu_gauche .= '<div class="list-group mb-4">';
    // La catégorie "Tous les produits"
    $contenu_gauche .= '<a href="?categorie=all" class="list-group-item mt-4">Tous les produits</a>';

    while ($cat = $resultat->fetch(PDO::FETCH_ASSOC)) {
        //debug($cat); // on voit l'indice catégorie avec dedans les catégories de la BDD

        $contenu_gauche .= '<a href="?categorie=' . $cat['categorie'] . '" class="list-group-item mt-4"> ' . ucfirst($cat['categorie']) . ' </a>'; // on met la première lettre en majuscule 
    }

$contenu_gauche .= '</div>';

// 2- Affichage des articles selon la catégorie choisies :
if (isset($_GET['categorie']) && $_GET['categorie'] != 'all') { // si on a choisi une categorie qui n'est pas "Tous les produits" :
    $resultat = executeRequete("SELECT * FROM produit WHERE categorie = :categorie", array(':categorie' => $_GET['categorie']));
    //debug($resultat);

} else { // sinon dans les autres cas on selectionne tous les produits : 
    $resultat = executeRequete("SELECT * FROM produit");
}

while ($produit = $resultat->fetch(PDO::FETCH_ASSOC)) {
    // debug($produit);

    $contenu_droite .= '<div class="col-sm-4">';
         $contenu_droite .= '<div class="card mt-4">';
             // image cliquable
             $contenu_droite .= '<a href="fiche_produit.php?id_produit='. $produit['id_produit'] .'">
                                     <img src=" ' . $produit['photo'] . ' " alt=" ' . $produit['titre'] . ' " class="card-img-top"></a>';

             // Les infos du produit après l'image :
             $contenu_droite .= '<div class="card-body">';

             $contenu_droite .= '<h2>' . $produit['titre'] . '</h2>';
             $contenu_droite .= '<h3>' . number_format($produit['prix'], 2, ',', '') . ' €</h3>'; // fonction qui formate le prix : nombre de décimales, séparateur des décimales, séparateur des miliers
             $contenu_droite .= '<p>' . $produit['description'] . '</p>';

             $contenu_droite .= '</div>'; // .card-body
         $contenu_droite .= '</div>'; // .card
    $contenu_droite .= '</div>'; // .col-sm-4
 }

require_once 'inc/header.php';
?>

<h1 class="mt-4">Vêtement</h1>

<div class="row">
    <div class="col-md-3"><?php echo $contenu_gauche; // pour afficher les catégories de vêtements ? ?></div>
    <div class="col-md-9"><div class="row"><?php echo $contenu_droite; // pour afficher les articles ? ?></div></div>
</div>

<?php require_once 'inc/footer.php';?>