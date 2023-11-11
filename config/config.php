<?php 
// Définition des variables contenant les infos de connexion

$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASSWORD = "Mardochee2008";
$DB_NAME = "projetcv";

// Connexion à la base de données

try {
    $db = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8", $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}