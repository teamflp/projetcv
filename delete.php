<?php
include 'config/config.php'; // Connexion à la base de données
include 'functions/functions.php';

// On érifie si l'ID est défini et est un nombre
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    
    /**
     * On appelle la fonction deleteUser(). 
     * On passe en paramètre l'ID de l'utilisateur à supprimer ainsi  
     * que la connexion à la base de données contenu dans la variable $db.
     */
    $result = deleteUser($db, $id);

    if (isset($result['success'])) {
        // On redirige vers la liste des étudiants avec un message de succès
        header("Location: index.php?success=" . urlencode($result['success']));
        exit;
    } else {
        // On rediriger vers la liste des étudiants avec un message d'erreur
        header("Location: index.php?error=" . urlencode($result['error']));
        exit;
    }
} else {
    // On redirige vers la liste des étudiants si l'ID n'est pas valide
    header("Location: index.php?error=ID invalide");
    exit;
}
?>
