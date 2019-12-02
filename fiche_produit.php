<?php

require_once 'inc/init.php';

$suggestion = ''; // pour afficher les suggestions de produits (exercice)
//debug($_GET);

// 1 - Contrôle de l'existence du produit demandé :
if (isset($_GET['id_produit'])) { // si le détail d'un produit est demandé

    $resultat = executeRequete("SELECT * FROM produit WHERE id_produit = :id_produit", array(':id_produit' => $_GET['id_produit'])); // on met un marqueur dans la requête quand la variable contient des données qui proviennent de l'internaute ($_POST, $_GET, $_COOKIE, $_FILES...)

    if ($resultat->rowCount() == 0) { // si le select ne retourne pas de ligne c'est que le produit n'existe pas ou plus
        header('location:index.php'); // on le redirige vers la boutique
        exit();
    }
    // 2 - préparation des données du produit sélectionné
    $produit = $resultat->fetch(PDO::FETCH_ASSOC); // pas de boucle car on est certain de n'avoir qu'un seul produit par id
    // debug($produit);
    extract($produit); // crée des variables au nom des indices avec dedans la valeur correspondante
    } else { // si l'internaute accède directement à la page ou que l'url est altérée
            header('location:index.php'); // on le redirige vers la boutique
            exit();
    }

    // Exercice "Suggestions de produits" :
    // Afficher 2 produits (photo et titre) aléatoirement et appartenant a la catégorie du produit affiché. Ces produits doivent être différents du produit actuellement affiché. La photo est cliquable et amène a la fiche produit. Vous utilisez la variable $suggestion pour l'affichage. 

    $resultat = executeRequete("SELECT id_produit, public, photo, titre FROM produit WHERE categorie = :categorie AND id_produit != :id_produit ORDER BY RAND() LIMIT 2", array(':categorie' => $categorie, ':id_produit' => $id_produit));
    
    while ($crossSell = $resultat->fetch(PDO::FETCH_ASSOC)) {
        //debug($crossSell);
        $suggestion .= '<div class="col-sm-4">';
            $suggestion .= '<div class="card mt-4">';
                // image cliquable
                $suggestion .= '<a href="fiche_produit.php?id_produit='. $crossSell['id_produit'].'"><img src=" ' . $crossSell['photo'] . ' " alt=" ' . $crossSell['titre'] . ' " class="card-img-top"></a>';

                if ($crossSell['public'] == 'm') {
                    $suggestion .= '<h5 class="m-3 man">' . $crossSell['titre'] . '</h5>';
                } elseif ($crossSell['public'] == 'f') {
                    $suggestion .= '<h5 class="m-3 woman">' . $crossSell['titre'] . '</h5>';
                } else {
                    $suggestion .= '<h5 class="m-3 mixte">' . $crossSell['titre'] . '</h5>';
                }
                
            $suggestion .= '</div>'; // .card
    $suggestion .= '</div>'; // .col-sm-4
    }
    

// affichage
require_once 'inc/header.php';?>

<div class="row">
    <div class="col-12 titre mt-4">
        <h1><?php echo ucfirst($titre); ?></h1>
    </div>
    <div class="col-md-6 mt-4">
        <img src="<?php echo $photo; ?>" alt="<?php echo $titre; ?>" class="img-fluid">
    </div>
    <div class="col-md-6 mt-4">
        <h2>Description</h2>
        <p><?php echo $description; ?></p>
        <hr><h5>Détails</h5><hr>
        <ul>
            <li>Catégorie : <?php echo $categorie; ?></li>
            <li>Couleur : <?php echo $couleur; ?></li>
            <li>Taille : <?php echo $taille; ?></li>
        </ul>
        <label class="mt-4 mb-2">Taille</label><br>
        <select name="taille">
            <option>S</option>
            <option>M</option>
            <option>L</option>
            <option>XL</option>
        </select><br>

        <form id="btn" action="panier.php?taille=<?php echo $taille ?>" method="post" class="mt-4">
            <button class="btn btn-primary mt-4" type="submit">Ajouter au panier</button>
        </form>
        
        <h6>Prix : <?php echo number_format($prix, 2, ',', ''); ?> €</h6>
        <a href="index.php?categorie=<?php echo $categorie ?>">Voir toute la catégorie <?php echo ucfirst($categorie) ?></a>
    </div>
</div>
<!-- Exercice -->
<hr>
<div class="row">
    <div class="col-12">
        <h3>Vous pourriez aimer</h3>
    </div>
    <?php echo $suggestion?>
</div>

<?php require_once 'inc/footer.php';?>