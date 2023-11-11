<?php 
include "includes/header.php"; 

require_once "functions/functions.php"; 
require_once "config/config.php";

autoLogin($db); // Vérifie si l'utilisateur est connecté en cochant le cookie "remember_me

/**
 * On interdit l'accès à cette page si l'utilisateur n'est pas connecté.
 */
if (!isset($_SESSION['user_id'])) {
    // On redirige vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: connexion.php');
    exit;
}
?>

<div class="container mt-5 mb-5">
    <p class="text-center">
        <?php if (isset($_SESSION['user_email'])): ?>
            Bienvenue <?= htmlspecialchars($_SESSION['user_email']) ?>
        <?php endif; ?> dans votre espace personnel. Vous pouvez modifier vos informations personnelles ici. 
        
    </p>
    <hr>

    - <a href="password_modify.php">Modifier mon mot de passe</a><br>

 <br>

    
</div>

<script src="assets/js/scripts.js"></script>

<script>
    document.getElementById('deleteAccount').addEventListener('click', function(e) {
    e.preventDefault();

    if (confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.')) {
        fetch('delete_account.php', {
            method: 'POST',
            body: JSON.stringify({ user_id: <?= json_encode($_SESSION['user_id']); ?> }),
            headers: { 'Content-Type': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            // Gérer la réponse ici
            window.location.href = 'index.php'; // Par exemple, rediriger vers l'accueil
        })
        .catch(error => console.error('Erreur:', error));
    }
});

</script>

<?php include "includes/footer.php"; ?>
