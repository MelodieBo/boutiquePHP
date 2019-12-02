<?php

require_once '../inc/init.php';

// 1- verification que le membre est admin :
    if(!estAdmin()) {
        header('location:../connexion.php'); // on redirige les membres classiques vers la page de connexion (not admin)
        exit();
    }

    // 7- suppression du produit : quand on clique sur un lien "supprimer un produit" vous supprimez le produit en BDD et laisser un message de réussite ou d'echec
    if(isset($_GET['id_produit'])) {
        $succes = executeRequete("DELETE FROM produit WHERE id_produit = :id_produit", array(':id_produit' => $_GET['id_produit']));

        if ($succes->rowCount() == 1) { // rowCount() compte le nombre de ligne dans l'objet PDOStatement retourné par la requête DELETE. Dans le cas où l'identifiant du produit n'existe pas, DELETE retourne 0 ligne, donc on va dans le else pour afficher "erruer de suppression...'
            $contenu .= '<div class="alert alert-success mt-4">Vous avez bien supprimé le produit</div>';
        } else  {
            $contenu .= '<div class="alert alert-danger mt-4">Vous n\'avez pas supprimé le produit</div>';
        }
    }

    // 6- affichage des articles
    $resultat = executeRequete("SELECT * FROM produit"); // on selection tout les produits
    $contenu .= '<h6> Nombre de produit dans la boutique : ' . $resultat->rowCount() . '</h6>';

    $contenu .= '<div class="table-responsive"><table class="table table-striped">';
        // Affichage des entêtes :
        $contenu .='<thead style="text-align:center;" class="thead-dark"><tr>';
            $contenu .= '<th scope="col">Id</th>';
            $contenu .= '<th scope="col">Reference</th>';
            $contenu .= '<th scope="col">Categorie</th>';
            $contenu .= '<th scope="col">Titre</th>';
            $contenu .= '<th scope="col">Description</th>';
            $contenu .= '<th scope="col">Couleur</th>';
            $contenu .= '<th scope="col">Taille</th>';
            $contenu .= '<th scope="col">Public</th>';
            $contenu .= '<th scope="col">Photo</th>';
            $contenu .= '<th scope="col">Prix</th>';
            $contenu .= '<th scope="col">Stock</th>';
            $contenu .= '<th scope="col">Action</th>';
        $contenu .='</tr></thead>';
        // Fin affichage des entêtes
        
        // afficher les produits par ligne. La photo doit apparaitre en largeur de 90px et la description doit etre coupée à 15 caractères.
        
        while ($produit = $resultat->fetch(PDO::FETCH_ASSOC)) {

            // debug($produit);

            $contenu .='<tbody><tr>';

            foreach ($produit as $indice => $information) {   
                if ($indice == 'photo') {
                    $contenu .=  '<td><img style="width:90px;" src="../'. $information .'" alt="'. $produit['titre'].'"></td>';
                } elseif ($indice == 'prix') {
                    $contenu .=  '<td>' . $information . '€ </td>';
                } elseif ($indice == 'description') {
                    $contenu .=  '<td>' . substr($information, 0, 15) . '...</td>';
                } elseif ($indice == 'reference' || $indice == 'taille' || $indice == 'public' || $indice == 'stock'){
                    $contenu .=  '<td style="text-align:center;">' . $information . '</td>';
                } else {
                    $contenu .=  '<td>' . $information . '</td>';
                }             
            }

            // Ajout des liens modifier et supprimer :
            $contenu .= '<td>
                            <a href="formulaire_produit.php?id_produit=' . $produit['id_produit'] .'">Modifier</a> |
                            <a href="?id_produit=' . $produit['id_produit'] .'">Supprimer</a>
                        </td>';

            $contenu .='</tr></tbody>';
        }
            
    $contenu .= '</table></div>'; 

require_once '../inc/header.php';

?>

<h1 class="mt-4">Gestion boutique</h1>

<div class="container mt-4">
    <div class="row">
        <div class="col">
        <ul class="nav nav-tabs">
            <li><a class="nav-link active" href="gestion_boutique.php">Affichage des produits</a></li>
            <li><a class="nav-link" href="formulaire_produit.php">Ajout d'un produit</a></li>
            <li><a class="nav-link" href="gestion_membre.php">Gérer les membres</a></li>
        </ul>
        </div>
    </div>
</div>

<?php

echo $contenu;

require_once '../inc/footer.php';

?>