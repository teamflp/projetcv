<?php
session_start();
session_destroy(); // Détruit toutes les données de session
header('Location: connexion.php'); // Redirection vers la page de connexion
exit;
?>
