<?php include "includes/header.php"; ?>
<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "functions/functions.php"; 
require_once "config/config.php";

// On s'assure que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // On redirige vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: connexion.php');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Traitement du formulaire de modification du mot de passe
    $result = modifyPassword($db, $_SESSION['user_id']);
    if (isset($result['success'])) {
        $message = $result['success'];
        // Vous pouvez aussi ajouter une déconnexion ici si nécessaire
        unset($_SESSION['user_id']); 
        unset($_SESSION['user_email']);
        header('Location: connexion.php');
    } else {
        $message = implode('<br>', $result['errors']);
    }
}
?>

<div class="container mt-5 mb-5">
    <h1 class="text-center">Modifier le mot de passe</h1>
    <hr>

    <!-- Formulaire de modification du mot de passe -->
    <div class="col-md-5 mt-5 mx-auto">
        <?php if ($message): ?>
            <div class="alert <?= isset($result['success']) ? 'alert-success' : 'alert-danger' ?>"><?= $message ?></div>
        <?php endif; ?>
        
        <form action="password_modify.php" method="post">
            <div class="form-group mb-2">
                <label for="oldPassword">Ancien mot de passe :</label>
                <input type="password" class="form-control pt-2 pb-3" name="oldPassword" id="oldPassword">
            </div>
            <div class="form-group mb-2">
                <label for="password">Nouveau mot de passe :</label>
                <input type="password" class="form-control pt-2 pb-3" id="newPassword" name="newPassword">
            </div>
            <div class="form-group mb-2">
                <label for="confirm_pwd">Confirmer le mot de passe :</label>
                <input type="password" class="form-control pt-2 pb-3" id="confirm_pwd" name="confirm_pwd">
            </div>
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary">Modifier</button>
            </div>
        </form>
    </div>
</div>

<script src="assets/js/scripts.js"></script>

<?php include "includes/footer.php"; ?>
