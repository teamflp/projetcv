<?php
session_start();

if (isset($_SESSION['user_id'])) {
    require_once 'config/config.php';

    // Suppression du token dans la base de données pour plus de sécurité
    $stmt = $db->prepare("UPDATE etudiants SET remember_token = NULL WHERE id = :id");
    $stmt->execute([':id' => $_SESSION['user_id']]);

    // Suppression du cookie "remember_me"
    setcookie('remember_me', '', time() - 3600, '/');
}

session_destroy(); // Détruit toutes les données de session
header('Location: connexion.php'); // Redirection vers la page de connexion
exit;
?>
