<?php include "includes/header.php"; ?>
<?php 
/*ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
*/
require_once "functions/functions.php"; 

// On interdit l'accès à la page si l'utilisateur n'est pas connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

?>

<div class="container mt-5 mb-5">
    <h1 class="text-center">Sauvegarde de base de données</h1>
    <hr>

    <div class="col-md-12 mt-5 mx-auto text-center">
        <?php  
            // Utilisation de la fonction
            $backupPath = 'backup/';
            $resultat = sauvegarderBaseDeDonnees($backupPath);

            echo $resultat;
        ?>

        <hr>
        <a href="index.php" class="btn btn-primary">Retour à la page d'accueil</a>
    </div>
</div>

<?php include "includes/footer.php"; ?>

