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

        <h1 class="text-center">Connexion</h1>

        <div class="mx-auto col-md-5 p-3 bg-light shadow-lg">

            <hr>

            <form method="post" id="inscriptionForm">
                <?php 
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $result = login($db);
                
                    if (isset($result['errors'])) {
                        // Gérer les erreurs ici
                        // Afficher les messages d'erreur à l'utilisateur
                        foreach ($result['errors'] as $error) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    }
                }

                ?>
                <div class="form-group mb-3">
                    <input type="text" class="form-control pt-3 pb-3" id="email" name="email" placeholder="Email">
                    <div class="error" id="errorEmail"></div>
                </div>
                <div class="form-group mb-3">
                    <input type="password" class="form-control pt-3 pb-3" id="password" name="password" placeholder="Mot de passe">
                    <div class="error" id="errorPwd"></div>
                </div>
                <!-- Se souvenir de moi -->
                <div class="form-group mb-3">
                    <input type="checkbox" name="remember_me" id="remember_me" value="1">
                    <label for="remember">Se souvenir de moi</label>
                </div>
                
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Connexion</button>
                </div>
                <hr>
                <div class="text-center"></div>
                    <p class="text-center">Vous n'avez pas de compte ? <a href="inscription.php">Inscrivez-vous</a></p>
                    <p class="text-center">Vous avez oublié votre mot de passe? <a href="password-recovery.php">Récupérez-vous</a></p>
                </div>
            </form>
        </div>
    </div>

<?php include "includes/footer.php"; ?>