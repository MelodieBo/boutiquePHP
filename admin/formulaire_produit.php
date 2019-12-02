<?php

require_once '../inc/init.php';

// 1- verification que le membre est admin :
    if(!estAdmin()) {
        header('location:../connexion.php'); // on redirige les membres classiques vers la page de connexion (not admin)
        exit();
    }

    // 4 - enregistrement du produit en BDD :
    //debug ($_POST);

    if ($_POST) { // si le formulaire est envoyé

        // ici il faudrait mettre tous les contrôles sur le formulaire

        $photo_bdd = ''; // par défaut il n'y a pas de photo sur le produit


        // 9 - suite : modification de la photo
        if (isset($_POST['photo_actuelle'])) {
            $photo_bdd = $_POST['photo_actuelle']; // On prend la photo du formulaire et on la remet en BDD
        }


        // traitement de la photo a venir... 

        // 5- suite : upload de la photo :
        // debug($_FILES); // $_FILES est une superglobale donc un array. Ce tableau possède un indice "photo" qui provient du "name" de l'input type "file" du formulaire. A l'interieur, il y a un sous array avec des indices prédéfinis, dont "name" qui contient le nom diu fichier en cours d'upload.

        // Si $_FILES est rempli, on traite la photo : 
        if (!empty($_FILES['photo']['name'])) {
            $fichier_photo = 'ref_' . $_POST['reference'] . '_' . $_FILES['photo']['name'];
            // on définit le nom du fichier pour pouvoir l'enregistrer sur notre serveur

            $photo_bdd = 'photo/' . $fichier_photo; // on définit le chemin relatif de la photo enregistrée en BDD et utilisé par les attributs src des images

            copy($_FILES['photo']['tmp_name'], '../' . $photo_bdd); // on copie le fichier temporaire qui se trouve a l'adresse $_FILES['photo']['tmp_name'] vers notre chemin qui est dans $photo_bdd (note: on remonte vers le dossier parent pour aller vers le dossier "photo" car nous sommes ici dans "admin")
        }


        // insertion du produit en BDD :
        $requete = executeRequete("REPLACE INTO produit VALUES (:id_produit, :reference, :categorie, :titre, :description, :couleur, :taille, :public, :photo, :prix, :stock)", 
        array(
            ':id_produit'       => $_POST['id_produit'],
            ':reference'        => $_POST['reference'],
            ':categorie'        => $_POST['categorie'],
            ':titre'            => $_POST['titre'],
            ':description'      => $_POST['description'],
            ':couleur'          => $_POST['couleur'],
            ':taille'           => $_POST['taille'],
            ':public'           => $_POST['public'],
            ':photo'            => $photo_bdd,
            ':prix'             => $_POST['prix'],
            ':stock'            => $_POST['stock'],
        ));

        // REPLACE INTO fait un INSERT INTO quand l'id_produit n'existe pas et comme un UPDATE quand l'id_produit existe en BDD

        if ($requete) { // si la variable contient un objet PDOStatement, la condition est évalué à true
            $contenu .= '<div class="alert alert-success mt-4">Le produit a été enregistré avec succès</div>';
        } else { // sinon la variable contient false, la requete n'a pas fonctionné
            $contenu .= '<div class="alert alert-danger mt-4">Erreur lors de l\'enregistrement</div>';
        }

    } // fin du if ($_POST)


    // 8- Remplissage du formulaire de modification :
        if (isset($_GET['id_produit'])) { // si on a reçu "id_produit" dans l'url, c'est qu'on a cliqué sur "modifier". On selectionne en BDD toutes les infos de ce produit pour remplir le formulaire
            $resultat = executeRequete("SELECT * FROM produit WHERE id_produit = :id_produit", array(':id_produit' => $_GET['id_produit']));

            $produit_actuel = $resultat->fetch(PDO::FETCH_ASSOC); // pas de while car un seul produit par id
            //debug($produit_actuel);
        }

require_once '../inc/header.php';

?>

<h1 class="mt-4">Gestion boutique</h1>

<div class="container mt-4">
    <div class="row">
        <div class="col">
        <ul class="nav nav-tabs">
            <li><a class="nav-link" href="gestion_boutique.php">Affichage des produits</a></li>
            <li><a class="nav-link active" href="formulaire_produit.php">Ajout d'un produit</a></li>
            <li><a class="nav-link" href="gestion_membre.php">Gérer les membres</a></li>
        </ul>
        </div>
    </div>
</div>

<?php echo $contenu; ?>

<h2 class="mt-4">Ajouter un produit</h2>

<form action="" method="post" enctype="multipart/form-data" class="order-1 col-md-6 col-sm-12 mt-3 p-5"><!-- multipart/form-data spécifie que ce formulaire envoie des données binaire (fichier) et du texte (champs de formulaire) : permet d'uplaoder un fichier (photo) -->

    <input type="hidden" name="id_produit" id="id_produit" value="<?php echo $produit_actuel['id_produit'] ?? 0; ?>"> <!-- Le type hidden permet de cacher le champs mais de l'avoir dans le $_POST. Nécessaire pour la modification d'un produit par son id. -->

    <label class="mt-4 mb-2" for="reference">Référence</label><br>
    <input type="text" name="reference" id="reference" value="<?php echo $produit_actuel['reference'] ?? ''; ?>"><br>

    <label class="mt-4 mb-2" for="categorie">Catégorie</label><br>
    <input type="text" name="categorie" id=categorie" value="<?php echo $produit_actuel['categorie'] ?? ''; ?>"><br>

    <label class="mt-4 mb-2" for="titre">Titre</label><br>
    <input type="text" name="titre" id=titre" value="<?php echo $produit_actuel['titre'] ?? ''; ?>"><br>

    <label class="mt-4 mb-2" for="description">Description</label><br>
    <textarea name="description" id="description" cols="30" rows="10"><?php echo $produit_actuel['description'] ?? ''; ?></textarea><br>

    <label class="mt-4 mb-2" for="couleur">Couleur</label><br>
    <input type="text" name="couleur" id="couleur" value="<?php echo $produit_actuel['couleur'] ?? ''; ?>"><br>

    <label class="mt-4 mb-2">Taille</label><br>
    <select name="taille">
        <option>S</option>
        <option <?php if(isset($produit_actuel['taille']) && $produit_actuel['taille'] == 'M') echo 'selected';?>>M</option>
        <option <?php if(isset($produit_actuel['taille']) && $produit_actuel['taille'] == 'L') echo 'selected';?>>L</option>
        <option <?php if(isset($produit_actuel['taille']) && $produit_actuel['taille'] == 'XL') echo 'selected';?>>XL</option>
    </select><br>

    <label class="mt-4 mb-2">Public</label><br>
    <div class="btn-radio">
        <input class="radio" type="radio" name="public" id="m" value="m" checked><label class="radio" for="m">masculin</label><br>
        <input class="radio" type="radio" name="public" id="f" value="f" <?php if(isset($produit_actuel['public']) && $produit_actuel['public'] == 'f') echo 'checked';?>><label class="radio" for="m">feminin</label><br>
        <input class="radio" type="radio" name="public" id="mixte" value="mixte" <?php if(isset($produit_actuel['public']) && $produit_actuel['public'] == 'mixte') echo 'checked';?>><label class="radio" for="mixte">mixte</label><br>
    </div>
    

    <label class="mt-4 mb-2" for="photo">Photos</label><br>
    <!-- 5 - Upload de la photo -->
    <input type="file" name="photo" id="photo"><br>
    <!-- Ne pas oublier de mettre enctype="multipart/form-data" sur le form pour pouvoir envoyer des fichiers -->
    <?php

    // Chapitre 9 - modification de la photo
    // On remet le chemin de la photo dans notre formulaire pour remplir $_POST. Sinon la photo reçue en modification n'étant pas précisée, elle disparait de la BDD

    if (isset($produit_actuel)) { // si on est en modification, on affiche la photo actuelle :
        echo '<p class="mt-4">Photo actuelle : </p>';
        echo '<img src="../' . $produit_actuel['photo'] . '" style="width:90px;"></img><br>';
        echo '<p class="mt-4"><input type="hidden" name="photo_actuelle" value="' . $produit_actuel['photo'] . '"></p>'; // on renseigne $_POST['photo_actuelle'] avec la valeur de notre photo pour la remettre en BDD
    }
    ?>


    <label class="mt-4 mb-2" for="prix">Prix</label><br>
    <input type="text" name="prix" id="prix" value="<?php echo $produit_actuel['prix'] ?? ''; ?>"><br>

    <label class="mt-4 mb-2" for="stock">Stock</label><br>
    <input type="text" name="stock" id="stock" value="<?php echo $produit_actuel['stock'] ?? ''; ?>"><br>

    <!-- Button Submit-->
    <div class="form-group row mt-4 mb-2" id="ajouter">
        <div class="col">
            <button type="submit" class="btn btn-primary"><?php if(isset($produit_actuel)) {
                        echo 'Modifier';
                    } else {
                        echo 'Ajouter';
                    } ?>
            </button>
        </div>
    </div>
</form>

<?php require_once '../inc/footer.php'; 



?>
