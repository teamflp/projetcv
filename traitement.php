<?php include "includes/header.php"; ?>
<?php require_once "config/config.php"; ?>

    <!-- Logique pour traiter le formulaire -->
    <div class="container mt-5 mb-5">
        <?php 
            // On récupère les données du formulaire
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom']?? '';
            $email = $_POST['email']?? '';
            $password = $_POST['password']?? '';
            $confirm_pwd = $_POST['confirm_pwd']?? '';

            // On définit un tableau d'erreurs vide
            $errors = [];

            // On vérifie que les champs sont renseignés
            

        ?>
    </div>


<?php include "includes/footer.php"; ?>