<?php
session_start();
?>

<nav class="navbar navbar-expand-lg bg-dark shadow-2">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="container collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="index.php"><i class="fas fa-home"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="competences.php">Compétences</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="experiences.php">Expériences</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="formation.php">Formation</a>
            </li>
        </ul>

        <!-- Liens à droite -->

        <ul class="navbar-nav ml-auto"> <!-- Assurez-vous d'utiliser ml-auto pour aligner les éléments à droite -->
            <li class="nav-item">
                <a class="nav-link" href="etudiants.php">Étudiants</a>
            </li>

            <!-- Utilisateur connecté -->
            <?php if (isset($_SESSION['user_email'])): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-circle"></i> <?= htmlspecialchars($_SESSION['user_email']) ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="account.php">Compte</a>
                        <a class="dropdown-item" href="logout.php">Déconnexion</a>
                    </div>
                </li>
            <?php else: ?>
                <!-- Utilisateur non connecté -->
                <li class="nav-item">
                    <a class="nav-link" href="connexion.php"><i class="fas fa-user-circle"></i> Connexion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="inscription.php">Inscription</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

