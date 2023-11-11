<?php include "includes/header.php"; ?>
<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "functions/functions.php"; 
require_once "config/config.php";

autoLogin($db); // Vérifie si l'utilisateur est connecté en cochant le cookie "remember_me

$totalEtudiants = getTotalEtudiants($db);

// On interdit l'accès à la page si l'utilisateur n'est pas connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

// Pagination
$page = $_GET['page'] ?? 1;
$etudiantsParPage = 12;
$stmt = $db->query("SELECT COUNT(*) FROM etudiants");
$totalEtudiants = $stmt->fetchColumn();
$nombrePages = ceil($totalEtudiants / $etudiantsParPage);
$etudiants = listEtudiants($db, $page, $etudiantsParPage);

?>

<div class="container mt-5 mb-5">
    <h1 class="text-center">Liste des étudiants</h1>
    <hr>

    <div class="d-flex align-items-center justify-content-between mt-5">
        <!-- Bouton pour ajouter un étudiant -->
        <a href="inscription.php" class="btn btn-primary">Ajouter un étudiant</a>

        <!-- On compte le nombre des étudiants inscrits -->
        <?php if (!empty($etudiants)):?>
            <button type="button" class="btn btn-primary">
                Étudiants inscrits <span class="badge text-bg-dark"><?= $totalEtudiants ?></span>
            </button>
        <?php endif;?>

    </div>

    <!-- Affichage de la liste des étudiants -->
    <div class="col-md-12 mt-5 mx-auto">
        <?php if (!empty($etudiants)): ?>
            <div class="row">
                <?php foreach ($etudiants as $etudiant): ?>
                    <div class="col-md-3 mb-2">
                        <div class="card"> 
                            <div class="card-body">
                                <h5 class="card-title">Nom &nbsp;&nbsp;&nbsp;: <?= htmlspecialchars($etudiant['nom']) ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted">Prénom : <?= htmlspecialchars($etudiant['prenom']) ?></h6>
                                <p class="card-text">Email &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= htmlspecialchars($etudiant['email']) ?></p>
                            </div>
                            <div class="card-footer bg-light d-flex align-items-center justify-content-between">
                                <a href="edit.php?id=<?= $etudiant['id'] ?>" class="btn btn-dark btn-sm">Éditer</a>
                                <a href="mailto:<?= htmlspecialchars($etudiant['email']) ?>" class="btn btn-dark btn-sm"><i class="fas fa-envelope-fly"></i>Enoyer un email</a>
                                <a href="delete.php?id=<?= $etudiant['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirmDelete();">Supprimer</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $nombrePages; $i++): ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
                    <?php endfor; ?>
                </ul>
            </nav>

        <?php else: ?>
            <p>Aucun étudiant trouvé.</p>
        <?php endif; ?>
    </div>
</div>

<script src="assets/js/scripts.js"></script>

<?php include "includes/footer.php"; ?>
