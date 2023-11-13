<!-- Les fonctions en PHP -->
<?php

require_once 'config/config.php';

// Fonction pour nettoyer les données du formulaire
function cleanInput($data, $type = 'string') {
    switch ($type) {
        case 'email':
            return filter_var(trim($data), FILTER_SANITIZE_EMAIL);
        case 'string':
        default:
            return htmlspecialchars(stripslashes(trim($data))); 
    }
}

// Cette fonction permet de valider les données du formulaire et de les insérer dans la base de données
function addUser($db): array
{
    // Récupération des données du formulaire
    $nom = cleanInput($_POST['nom'] ?? '');
    $prenom = cleanInput($_POST['prenom'] ?? '');
    $email = cleanInput($_POST['email'] ?? '', 'email');
    $password = $_POST['password'] ?? '';
    $confirm_pwd = $_POST['confirm_pwd'] ?? '';

    // Tableau pour collecter les erreurs
    $errors = [];

    // Validation des champs
    if (empty($nom)) {
        $errors['nom'] = 'Le nom est requis.';
    } elseif (strlen($nom) < 2) {
        $errors['nom'] = "Le nom doit contenir au moins 2 caractères.";
    }

    if (empty($prenom)) {
        $errors['prenom'] = 'Le prénom est requis.';
    } elseif (strlen($prenom) < 2) {
        $errors['prenom'] = "Le prénom doit contenir au moins 2 caractères.";
    }

    if (empty($email)) {
        $errors['email'] = 'L\'email est requis.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'email n'est pas valide.";
    }

    if (empty($password)) {
        $errors['password'] = 'Le mot de passe est requis.';
    } elseif (strlen($password) < 8) {
        $errors['password'] = "Le mot de passe doit contenir au moins 8 caractères.";
    }

    if (empty($confirm_pwd)) {
        $errors['confirm_pwd'] = 'Veuillez retapper votre mot de passe.';
    }
    elseif ($password !== $confirm_pwd) {
        $errors['confirm_pwd'] = 'Les mots de passe ne correspondent pas.';
    }

    // Vérification de l'unicité de l'email
    $stmt = $db->prepare("SELECT COUNT(*) FROM etudiants WHERE email = :email");
    $stmt->bindParam(':email', $email); // Valeur de la colonne email
    $stmt->execute();

    if ($stmt->fetchColumn() > 0) {
        $errors['email'] = 'L\'adresse e-mail est déjà utilisée.';
    }

    // Si aucune erreur, procéder à l'insertion
    if (empty($errors)) {
        // Hashage du mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insertion dans la base de données
        try {
            // On utilise la requête préparée pour éviter les injections SQL
            $stmt = $db->prepare("INSERT INTO etudiants (nom, prenom, email, password) VALUES (:nom, :prenom, :email, :password)");

            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);

            $stmt->execute(); // Exécution de la requête

            // Retour d'un message de succès
            return ['success' => 'Utilisateur créé avec succès.'];
        } catch (PDOException $e) {
            // Gestion des erreurs liées à la base de données
            $errors['db'] = "Erreur de base de données : " . $e->getMessage();
            return ['errors' => $errors];
        }
    } else {
        // Retour des erreurs si le tableau n'est pas vide
        return ['errors' => $errors];
    }
}

// Fonction pour afficher la liste des utilisateurs
function listEtudiants(PDO $db, $page = 1, $etudiantsParPage = 10): array {
    $users = [];
    $start = ($page - 1) * $etudiantsParPage;
    
    try {
        $query = "SELECT * FROM etudiants LIMIT :start, :etudiantsParPage";
        $stmt = $db->prepare($query);
        // Liaison des paramètres
        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':etudiantsParPage', $etudiantsParPage, PDO::PARAM_INT);

        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur de base de données - listEtudiants: " . $e->getMessage());
    }
    return $users;
}

// Fonction pour gérer la pagination des utilisateurs
function pagination($db) {
    $page = $_GET['page'] ?? 1;
    $etudiantsParPage = 3;
    $stmt = $db->query("SELECT COUNT(*) FROM etudiants");
    $totalEtudiants = $stmt->fetchColumn();
    $nombrePages = ceil($totalEtudiants / $etudiantsParPage);

    // Création des liens de pagination
    $links = '';
    for ($i = 1; $i <= $nombrePages; $i++) {
        $activeClass = ($i == $page) ? 'active' : '';
        $links .= "<li class='page-item $activeClass'><a class='page-link' href='?page=$i'>$i</a></li>";
    }

    return $links;
}

// Fonction pour récupérer le nombre total d'étudiants
function getTotalEtudiants($db) {
    $stmt = $db->query("SELECT COUNT(*) FROM etudiants");
    return $stmt->fetchColumn();
}

// Fonction pour modifier un utilisateur
function editUser($db)
{
    // Récupération et nettoyage des données du formulaire
    $id = $_POST['id'] ?? '';
    $nom = cleanInput($_POST['nom'] ?? '');
    $prenom = cleanInput($_POST['prenom'] ?? '');
    $email = cleanInput($_POST['email'] ?? '', 'email');

    // Tableau pour collecter les erreurs
    $errors = [];

    // Validation des champs
    if (empty($nom)) {
        $errors['nom'] = 'Le nom est requis.';
    } elseif (strlen($nom) < 2) {
        $errors['nom'] = "Le nom doit contenir au moins 2 caractères.";
    }

    if (empty($prenom)) {
        $errors['prenom'] = 'Le prénom est requis.';
    } elseif (strlen($prenom) < 2) {
        $errors['prenom'] = "Le prénom doit contenir au moins 2 caractères.";
    }

    if (empty($email)) {
        $errors['email'] = 'L\'email est requis.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'email n'est pas valide.";
    }

    // Validation de l'ID
    if (empty($id) || !is_numeric($id)) {
        $errors['id'] = "L'ID de l'utilisateur est invalide.";
    }

    // Vérification de l'existence de l'email dans la base de données
    if (empty($errors)) {
        $stmt = $db->prepare("SELECT id FROM etudiants WHERE email = :email AND id != :id");
        $stmt->execute([':email' => $email, ':id' => $id]);
        if ($stmt->fetch()) {
            $errors['email'] = "L'email est déjà utilisé par un autre utilisateur.";
        }
    }

    // Si aucune erreur, procéder à la mise à jour
    if (empty($errors)) {
        try {
            $stmt = $db->prepare("UPDATE etudiants SET nom = :nom, prenom = :prenom, email = :email WHERE id = :id");
            $stmt->execute([':nom' => $nom, ':prenom' => $prenom, ':email' => $email, ':id' => $id]);

            return ['success' => "Utilisateur (ID: $id) modifié avec succès."];
        } catch (PDOException $e) {
            logError($e); // Fonction hypothétique pour logger les erreurs
            $errors['db'] = "Erreur de base de données : " . $e->getMessage();
            return ['errors' => $errors];
        }
    } else {
        return ['errors' => $errors];
    }
}

// Fonction pour récupérer les données d'un utilisateur
function getUserData($db, $id) {
    try {
        $stmt = $db->prepare("SELECT * FROM etudiants WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Gestion des erreurs
        logError($e); // Fonction hypothétique pour logger les erreurs
        return null;
    }
}

// Fonction pour supprimer un utilisateur
function deleteUser($db, $id) {
    try {
        // Préparation de la requête de suppression
        $stmt = $db->prepare("DELETE FROM etudiants WHERE id = :id");

        // Liaison du paramètre ID
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Exécution de la requête
        $stmt->execute();

        // Vérification de la suppression
        if ($stmt->rowCount() > 0) {
            return ['success' => "Utilisateur supprimé avec succès."];
        } else {
            return ['error' => "Aucun utilisateur trouvé avec cet ID."];
        }
    } catch (PDOException $e) {
        // Gestion des erreurs
        logError($e); // Utilisez votre fonction de log d'erreur
        return ['error' => "Erreur lors de la suppression : " . $e->getMessage()];
    }
}

// Système d'authentification
function login($db) {
    // Récupération et nettoyage des données du formulaire
    $email = cleanInput($_POST['email'] ?? '', 'email');
    $password = $_POST['password'] ?? '';

    // Tableau pour collecter les erreurs
    $errors = [];

    // Validation des champs
    if (empty($email) || empty($password)) {
        $errors[] = 'Veuillez remplir les champs.';
    } 
    elseif ((!filter_var($email, FILTER_VALIDATE_EMAIL)) || strlen($password) < 8) {
        $errors[] = 'Adresse email ou mot de passe incorrect. Veuillez réessayer.';
    }

    // Si aucune erreur, procéder à la vérification
    if (empty($errors)) {
        try {
            $stmt = $db->prepare("SELECT id, password FROM etudiants WHERE email = :email");
            $stmt->execute([':email' => $email]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Vérification du mot de passe
                if (password_verify($password, $user['password'])) {
                    // Ouverture de la session
                    session_start();

                    // Enregistrement des données de l'utilisateur dans la session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $email; // Stocker l'email dans la session

                    // Gérer "Se souvenir de moi"
                    if (isset($_POST['remember_me']) && $_POST['remember_me'] == '1') {
                        // Créer un jeton unique pour l'utilisateur
                        $token = bin2hex(random_bytes(50)); // exemple de jeton: 12345678901234567890123456789012345678901234567890

                        // Stocker le jeton dans un cookie
                        setcookie('remember_me', $token, time() + 86400 * 30, '/'); // Le cookie expire dans 30 jours

                        // Enregistrer ce jeton dans la base de données avec une association à l'utilisateur
                        $stmt = $db->prepare("UPDATE etudiants SET remember_token = :token WHERE id = :id");
                        $stmt->execute([':token' => $token, ':id' => $user['id']]);
                    }

                    echo "Redirection en cours..."; 
                    exit;

                    // Redirection vers la page d'accueil
                    header('Location: index.php');
                    exit;
                } else {
                    $errors['password'] = "Le mot de passe est incorrect.";
                }
            } else {
                $errors['email'] = "Aucun utilisateur trouvé avec cet email.";
            }
        } catch (PDOException $e) {
            // Gestion des erreurs
            logError($e); // Fonction hypothétique pour logger les erreurs
            $errors['db'] = "Erreur de base de données : " . $e->getMessage();
        }
    }

    return ['errors' => $errors];
}

// Fonction pour vérifier si un utilisateur veut rester connecté en cochant le cookie "remember_me"
function autoLogin(PDO $db) {

    if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_me'])) {
        $token = $_COOKIE['remember_me'];
        $stmt = $db->prepare("SELECT id, email FROM etudiants WHERE remember_token = :token");
        $stmt->execute([':token' => $token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // L'utilisateur est reconnu.
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email']; // Stocker l'email dans la session
        }
    }
}

// Fonction pour filtrer les données de l'utilisateur
function filterData($db) {
    $search = $_GET['search'] ?? '';
    $users = [];

    try {
        $stmt = $db->prepare("SELECT * FROM etudiants WHERE nom LIKE :search OR prenom LIKE :search OR email LIKE :search");
        $stmt->execute([':search' => "%$search%"]);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur de base de données - filterData: " . $e->getMessage());
    }
    return $users;
}

// Fonction pour modifier le mot de passe d'un utilisateur
function modifyPassword($db, $userId) {
    // Récupération et nettoyage des données du formulaire
    $oldPassword = $_POST['oldPassword'] ?? '';
    $newPassword = $_POST['newPassword'] ?? '';
    $confirm_pwd = $_POST['confirm_pwd'] ?? '';

    // Tableau pour collecter les erreurs
    $errors = [];

    if (empty($oldPassword)) {
        $errors['oldPassword'] = 'L\'ancien mot de passe est requis.';
    }

    if (empty($newPassword)) {
        $errors['newPassword'] = 'Le nouveau mot de passe est requis.';
    } elseif (strlen($newPassword) < 8) {
        $errors['newPassword'] = "Le mot de passe doit contenir au moins 8 caractères.";
    }

    if ($newPassword !== $confirm_pwd) {
        $errors['confirm_pwd'] = 'Les mots de passe ne correspondent pas.';
    }

    // Si aucune erreur, vérifier l'ancien mot de passe puis procéder à la mise à jour
    if (empty($errors)) {
        try {
            // Vérification de l'ancien mot de passe
            $stmt = $db->prepare("SELECT password FROM etudiants WHERE id = :id");
            $stmt->execute([':id' => $userId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($oldPassword, $user['password'])) {
                // Hashage du nouveau mot de passe
                $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);

                // Mise à jour du mot de passe pour l'utilisateur connecté
                $stmt = $db->prepare("UPDATE etudiants SET password = :password WHERE id = :id");
                $stmt->execute([':password' => $hashed_password, ':id' => $userId]);

                return ['success' => "Mot de passe modifié avec succès. Veuillez vous reconnecter."];
            } else {
                $errors['oldPassword'] = "L'ancien mot de passe est incorrect.";
            }
        } catch (PDOException $e) {
            logError($e); // Fonction hypothétique pour logger les erreurs
            $errors['db'] = "Erreur de base de données : " . $e->getMessage();
            return ['errors' => $errors];
        }
    }

    return ['errors' => $errors];
}

/**
 * Sauvegarde la base de données dans un fichier SQL.
 *
 * Cette fonction crée un dump de la base de données et le sauvegarde dans un fichier
 * dans le répertoire spécifié. Le nom du fichier contient la date et l'heure actuelles
 * ainsi qu'une chaîne aléatoire pour éviter les doublons.
 *
 * @param string $backupPath Chemin du répertoire où le fichier de sauvegarde sera enregistré.
 *
 * @return string Message HTML indiquant le résultat de l'opération. En cas de succès, un message
 * de confirmation est retourné. En cas d'échec, un message d'erreur est retourné avec les détails.
 *
 * @throws Exception Si la date et l'heure ne peuvent pas être déterminées.
 *
 * Usage:
 *   echo sauvegarderBaseDeDonnees('/path/to/backup/dir/');
 */
function sauvegarderBaseDeDonnees($backupPath): string
{
    global $DB_USER, $DB_PASSWORD, $DB_HOST, $DB_NAME;

    $date = new DateTime();
    $date->setTimezone(new DateTimeZone('Europe/Paris'));
    
    $randomStr = substr(md5(rand()), 0, 10);
    $filename = $backupPath . $date->format('Y-m-d-H-i') . '-' . $randomStr . '.sql';

    $command = "mysqldump --user=" . $DB_USER . " --password=" . $DB_PASSWORD . " --host=" . $DB_HOST . " " . $DB_NAME . " --result-file={$filename} 2>&1";

    $output = null;
    $returnVar = null;
    exec($command, $output, $returnVar);

    if ($returnVar === 0) {
        return '<p class="text-success text-lg">La sauvegarde de la base de données <b>'. $DB_NAME . '</b> a été réalisée avec succès.</p>';
    } else {
        return '<p class="text-success">Erreur lors de la sauvegarde de la base de données. ' . implode("\n", $output). '</p>';
    }
}

// Fonction pour logger les erreurs
function logError($exception) {
    // Chemin du fichier de log
    $logFile = 'log/logfile.log'; // Modifiez le chemin selon votre structure de fichiers

    // Message à logger
    $logMessage = '[' . date('d-m-Y H:i:s') . '] Erreur: ' . $exception->getMessage();
    $logMessage .= ' dans ' . $exception->getFile();
    $logMessage .= ' à la ligne ' . $exception->getLine() . PHP_EOL;

    // Écriture dans le fichier de log
    file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
}

