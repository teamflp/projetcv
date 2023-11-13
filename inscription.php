<style>
    .error {
        color: red;
        font-size: 1rem;
    }
</style>

<?php
include "includes/header.php";
include 'config/config.php'; // Assurez-vous que cette inclusion active les erreurs PDO comme suggéré
include 'functions/functions.php';

global $db;
?>
    <!-- On met ici -->
    <div class="container mt-5 mb-5">

        <h1 class="text-center">Ajouter un étudiant</h1>
        <p class="text-center mb-5">Veuillez renseigner les informations du nouvel étudiant</p>

        <div class="mx-auto col-md-5 p-3 bg-light shadow-lg">

            <hr>

            <form method="post" id="inscriptionForm">
                <?php
                // Initialisation des messages
                $errors = [];
                $success = '';

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $result = addUser($db);

                    // Vérifier si des erreurs existent
                    if (isset($result['errors'])) {
                        $errors = $result['errors'];
                    }

                    // Vérifier si le message de succès existe
                    if (isset($result['success'])) {
                        $success = $result['success'];
                    }
                }

                // Plus tard, dans votre HTML :
                if (!empty($errors)) {
                    echo "<div class='alert alert-danger'>";
                    foreach ($errors as $error) {
                        echo $error;
                    }
                    echo "</div>";
                }

                // Afficher le message de succès si l'utilisateur a été créé
                if ($success !== '') {
                    echo "<div class='alert alert-success'>$success</div>";
                }

                ?>
                <div class="form-group mb-3">
                    <input type="text" class="form-control pt-3 pb-3" id="nom" name="nom" placeholder="Nom">
                    <div class="error" id="errorNom"></div>
                </div>
                <div class="form-group mb-3">
                    <input type="text" class="form-control pt-3 pb-3" id="prenom" name="prenom" placeholder="Prénom">
                    <div class="error" id="errorPrenom"></div>
                </div>
                <div class="form-group mb-3">
                    <input type="email" class="form-control pt-3 pb-3" id="email" name="email" placeholder="Email">
                    <div class="error" id="errorEmail"></div>
                </div>
                <div class="form-group mb-3">
                    <input type="password" class="form-control pt-3 pb-3" id="password" name="password" placeholder="Mot de passe">
                    <div class="error" id="errorPwd"></div>
                </div>
                <div class="form-group mb-3">
                    <input type="password" class="form-control pt-3 pb-3" id="confirm_pwd" name="confirm_pwd" placeholder="Confirmer de mot passe">
                    <div class="error" id="errorConfirmPwd"></div>
                </div>
                <div class="form-group mb-3">
                    <label class="control-label">Ajouter un avatar</label>
                    <input type="file" class="form-control pt-3 pb-3" id="image" name="image" placeholder="Ajouter un avatar">
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Inscription</button>
                    <button type="reset" class="btn btn-secondary">Réinitialiser</button>
                </div>
                <hr>
                <div class="text-center"></div>
                    <p class="text-center">Vous avez un compte ? <a href="connexion.php">Connectez-vous</a></p>
                </div>
            </form>
        </div>
    </div>


<script src="assets/js/scripts.js"></script>

<?php include "includes/footer.php"; ?>