<style>
    .error {
        color: red;
        font-size: 0.8rem;
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

        <div class="mx-auto col-md-5">
            <h1 class="text-center">Modification des données</h1>

            <hr>
            <form method="post" id="inscriptionForm">
                <?php

                // Récupération de l'ID de l'utilisateur à modifier
                $userId = $_GET['id'] ?? null;

                // On récupère les données de l'utilisateur à modifier
                $userData = $userId ? getUserData($db, $userId) : null;

                // Initialisation des messages
                $errors = [];
                $success = '';

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $result = editUser($db);

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
                <!-- 
                Le champ caché pour l'ID dans un formulaire de modification est utilisé pour passer l'identifiant unique 
                de l'entité (dans votre cas, un utilisateur) à modifier. Cela a plusieurs utilités importantes :

                1. Identifier l'entité à modifier : Lorsque vous envoyez un formulaire pour mettre à jour des données dans une base de données,
                vous devez spécifier quel enregistrement précis doit être modifié. Le champ caché contenant l'ID de l'utilisateur
                permet de transmettre cette information au serveur de manière discrète, sans l'afficher à l'utilisateur.

                2. Sécurité : Bien que les champs cachés ne soient pas visibles dans l'interface utilisateur, ils peuvent être vus
                en inspectant le code source de la page. C'est pourquoi il est important de toujours valider et vérifier l'ID
                côté serveur avant de procéder à des opérations de base de données, pour prévenir des manipulations malveillantes.

                3. Simplicité et intégration transparente : Utiliser un champ caché est un moyen simple et efficace de s'assurer
                que l'ID nécessaire pour la mise à jour des données est transmis avec la requête POST, sans nécessiter
                d'interactions supplémentaires ou de traitement complexe.
                -->

                <input type="hidden" name="id" value="<?php echo $userData['id'] ?? ''; ?>"> <!-- Champ caché pour l'ID -->


                <div class="form-group mb-3">
                    <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" value="<?php echo $userData['nom'] ?? ''; ?>">
                    <div class="error" id="errorNom"></div>
                </div>
                <div class="form-group mb-3">
                    <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom" value="<?php echo $userData['prenom'] ?? ''; ?>">
                    <div class="error" id="errorPrenom"></div>
                </div>
                <div class="form-group mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $userData['email'] ?? ''; ?>">
                    <div class="error" id="errorEmail"></div>
                </div>

                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
            </form>
        </div>
    </div>


<script src="assets/js/scripts.js"></script>

<?php include "includes/footer.php"; ?>