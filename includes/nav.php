<?php
session_start();
?>

<!--<nav class="navbar navbar-expand-lg bg-dark shadow-2">
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
            <li class="nav-item">
                <a class="nav-link" href="etudiants.php">Étudiants</a>
            </li>
        </ul>


        <ul class="navbar-nav ml-auto">

            <?php /*if (isset($_SESSION['user_email'])): */?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-circle"></i> <?php /*= htmlspecialchars($_SESSION['user_email']) */?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="account.php">Compte</a>
                        <a class="dropdown-item" href="dump_db.php"><i class="fas fa-database"></i> Save Database</a>
                        <a class="dropdown-item" href="logout.php">Déconnexion</a>
                    </div>
                </li>
                
            <?php /*else: */?>
                <li class="nav-item">
                    <a class="nav-link" href="connexion.php"><i class="fas fa-user-circle"></i> Connexion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="inscription.php">Inscription</a>
                </li>
        
            <?php /*endif; */?>
        </ul>
    </div>
</nav>
-->


<nav class="custom-navbar">
    <!-- Bouton Hamburger pour les écrans mobiles -->
    <div class="custom-navbar-toggler">
        <span>&#9776; Menu</span>
    </div>
    <ul class="custom-nav">
        <li class="custom-nav-item"><a href="index.php">Accueil</a></li>
        <li class="custom-nav-item"><a href="competences.php">Compétences</a></li>
        <li class="custom-nav-item"><a href="experiences.php">Expériences</a></li>
        <li class="custom-nav-item"><a href="formation.php">Formation</a></li>
        <li class="custom-nav-item"><a href="etudiants.php">Étudiants</a></li>
    </ul>
    <ul class="custom-nav custom-nav-right">
        <?php if (isset($_SESSION['user_email'])): ?>
            <li class="custom-nav-item custom-dropdown">
                <a href="#" class="custom-dropdown-toggle"><?= htmlspecialchars($_SESSION['user_email']) ?></a>
                <div class="custom-dropdown-menu">
                    <a href="account.php">Compte</a>
                    <a href="dump_db.php"><i class="fas fa-database"></i> Save Database</a>
                    <a href="logout.php">Déconnexion</a>
                </div>
            </li>
        <?php else: ?>
            <li class="custom-nav-item"><a href="connexion.php">Connexion</a></li>
            <li class="custom-nav-item"><a href="inscription.php">Inscription</a></li>
        <?php endif; ?>
    </ul>
</nav>

<script>
    document.querySelector('.custom-navbar-toggler').addEventListener('click', function() {
        var navItems = document.querySelectorAll('.custom-nav, .custom-nav-right');
        navItems.forEach(function(nav) {
            nav.style.display = nav.style.display === 'block' ? 'none' : 'block';
        });
    });
</script>