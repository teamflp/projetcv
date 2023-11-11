<?php global $db;
include "includes/header.php"; ?>
<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "functions/functions.php"; 
require_once "config/config.php"; // On s'assure d'inclure notre fichier de configuration de base de données

autoLogin($db); // Vérifie si l'utilisateur est connecté en cochant le cookie "remember_me

$paginationData = pagination($db); // Pagination

$totalEtudiants = getTotalEtudiants($db);

// On interdit l'accès à cette page si l'utilisateur n'est pas connecté.
if (!isset($_SESSION['user_id'])) {
    // On redirige vers la page de connexion si l'utilisateur n'est pas connecté
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
    <div class="mt-5 mx-auto">
        <div class="mb-3 col-4">
            <input type="text" id="searchInput" class="form-control" placeholder="Rechercher un étudiant...">
        </div>
        
        <?php if (!empty($etudiants)): ?>
            <table class="table table-bordered table-striped bg-dark">
                <thead class="bg-dark">
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Email</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($etudiants as $etudiant): ?>
                        <tr>
                            <td><?= htmlspecialchars($etudiant['nom']) ?></td>
                            <td><?= htmlspecialchars($etudiant['prenom']) ?></td>
                            <td><?= htmlspecialchars($etudiant['email']) ?></td>
                            <td>
                                <!-- Actions -->
                                <a class="btn btn-primary btn-sm left-button" href="edit.php?id=<?= $etudiant['id'] ?>"><i class="fa fa-pencil-alt"></i></a>
                                <a class="btn btn-danger btn-sm end" href="delete.php?id=<?= $etudiant['id'] ?>" onclick="return confirmDelete();"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

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
