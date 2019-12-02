<?php 
require_once 'inc/init.php';
$affiche_formulaire = true; // pour notre condition qui affiche le formulaire tant que le membre n'est pas inscrit


// Traitement du $_POST
// debug($_POST); // pour voir ce que renvoi $_POST

if ($_POST) { // si le formulaire a été envoyé

    // validation du formulaire
    if (!isset($_POST['pseudo']) || strlen($_POST['pseudo']) < 4 || strlen($_POST['pseudo']) > 20) {
        $contenu .= '<div class="alert alert-warning"> Le pseudo doit contenir entre 4 et 20 caractères. </div>';
    }
    if (!isset($_POST['mdp']) || strlen($_POST['mdp']) < 4 || strlen($_POST['mdp']) > 20) {
        $contenu .= '<div class="alert alert-warning"> Le mot de passe doit contenir entre 4 et 20 caractères. </div>';
    }
    if (!isset($_POST['nom']) || strlen($_POST['nom']) < 2 || strlen($_POST['nom']) > 20) {
        $contenu .= '<div class="alert alert-warning"> Le nom doit contenir entre 4 et 20 caractères. </div>';
    }
    if (!isset($_POST['prenom']) || strlen($_POST['prenom']) < 2 || strlen($_POST['prenom']) > 20) {
        $contenu .= '<div class="alert alert-warning"> Le prénom doit contenir entre 2 et 20 caractères. </div>';
    }
    if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) { // filter_var avec la constante FILTER_VALIDATE_EMAIL retourne true si c'est bien un format email, sinon false.
        $contenu .= '<div class="alert alert-warning"> L\'email est invalide. </div>';
    }
    if (!isset($_POST['civilite']) || ($_POST['civilite'] != 'm' && $_POST['civilite'] != 'f')) { 
        $contenu .= '<div class="alert alert-warning"> La civilite est invalide. </div>';
    }
    if (!isset($_POST['ville']) || strlen($_POST['ville']) < 2 || strlen($_POST['ville']) > 20) {
        $contenu .= '<div class="alert alert-warning"> La ville doit contenir entre 2 et 20 caractères. </div>';
    }
    if (!isset($_POST['adresse']) || strlen($_POST['adresse']) < 2 || strlen($_POST['adresse']) > 20) {
        $contenu .= '<div class="alert alert-warning"> L\'adresse doit contenir entre 2 et 20 caractères. </div>';
    }
    if (!isset($_POST['code_postal']) || !preg_match('#^[0-9]{5}$#', $_POST['code_postal'])) {
        $contenu .= '<div class="alert alert-warning"> Le code postal est invalide. </div>';
    }

    // Si pas d'erreur sur le formulaire, on vérifie l'unicité du pseudo
    if (empty($contenu)) {
        $membre = executeRequete("SELECT * FROM membre WHERE pseudo = :pseudo", array(':pseudo' => $_POST['pseudo']));

        if (!empty($membre) && $membre->rowCount() > 0) { // si $membre contient des lignes, c'est que le pseudo est déja en BDD
            $contenu .= '<div class="alert alert-warning"> Le pseudo est indisponible. </div>';
        } else { // dans le cas contraire, on peut inscrire le membre
            $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT); // si nous hashons le mdp, il faudra sur la page de connexion comparer le hash de la BDD avec celui du mdp de l'internaute. PASSWORD_DEFAULT utilise l'algorythme mbcrypt à l'heure actuelle. 

            $succes = executeRequete("INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse, statut) VALUES (:pseudo, :mdp, :nom, :prenom, :email, :civilite, :ville, :code_postal, :adresse, 0)", 
            array(

            ':pseudo'       => $_POST['pseudo'],
            ':mdp'          => $mdp,
            ':nom'          => $_POST['nom'],
            ':prenom'       => $_POST['prenom'],
            ':email'        => $_POST['email'],
            ':civilite'     => $_POST['civilite'],
            ':ville'        => $_POST['ville'],
            ':code_postal'  => $_POST['code_postal'],
            ':adresse'      => $_POST['adresse'],

            ));

            if ($succes) {
                $contenu .= '<div class="alert alert-success" role="alert"> Vous êtes inscrit. <a href="connexion.php">Cliquez ici pour vous connecter</a> </div>';
            } else {
                $contenu .= '<div class="alert alert-danger"> Erreur lors de l\'inscription </div>';
            }
        }
    }        
} // fin de if($_POST)

//------------------------------- AFFICHAGE --------------------------------
require_once 'inc/header.php';
?>

<h1 class="mt-4">Inscription</h1>
<?php 
if ($affiche_formulaire) : 
?>

<!-- Mon formulaire -->
<div class="container">
    <div class="row">

        <div class="order-2 col-md-6 col-sm-12 mt-3"">
            <?php echo $contenu; ?>
        </div>

        <form method="post" action="" class="order-1 col-md-6 col-sm-12 mt-3 p-5">

            <div class="form-group">
                <label for="pseudo">Pseudo</label><br>
                <input type="text" name="pseudo" id="pseudo" value="<?php echo $_POST['pseudo'] ?? '';?>">
            </div>

            <div class="form-group">
                <label for="mdp">Mot de passe</label><br>
                <input type="password" name="mdp" id="mdp" value="<?php echo $_POST['mdp'] ?? '';?>">
            </div>

            <div class="form-group">
                <label for="nom">Nom</label><br>
                <input type="text" name="nom" id="nom" value="<?php echo $_POST['nom'] ?? '';?>">
            </div>

            <div class="form-group">
                <label for="prenom">Prénom</label><br>
                <input type="text" name="prenom" id="prenom" value="<?php echo $_POST['prenom'] ?? '';?>">
            </div>

            <div class="form-group">
                <label for="prenom">Email</label><br>
                <input type="email" name="email" id="email" value="<?php echo $_POST['email'] ?? '';?>">
            </div>

            <label>Civilité</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="civilite" id="m" value="m" checked>
                <label class="form-check-label" for="m">Homme</label>
            </div>
            <div class="form-check form-check-inline mb-3">
                <input class="form-check-input" type="radio" name="civilite" id="f" value="f" <?php if(isset($_POST['civilite']) && $_POST['civilite'] == "f") echo'checked'; ?> >
                <label class="form-check-label" for="f">Femme</label>
            </div>

            <div class="form-group">
                <label for="ville">Ville</label><br>
                <input type="text" name="ville" id="ville" value="<?php echo $_POST['ville'] ?? '';?>">
            </div>

            <div class="form-group">
                <label for="code_postal">Code postal</label><br>
                <input type="text" name="code_postal" id="code_postal" value="<?php echo $_POST['code_postal'] ?? '';?>" placeholder="75009">
            </div>

            <div class="form-group">
                <label for="adresse">Adresse</label><br>
                <input type="text" name="adresse" id="adresse" value="<?php echo $_POST['adresse'] ?? '';?>">
            </div>

            <!-- Button Submit-->
            <div class="form-group row">
                <div class="col">
                <button type="submit" class="btn btn-primary">S'inscrire</button>
                </div>
            </div>
        </form>       
    </div> <!-- Fin row -->
</div> <!-- Fin container -->


<?php
endif;
require_once 'inc/footer.php';
?>