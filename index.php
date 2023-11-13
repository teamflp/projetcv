<style>
    .draggable {
    transition: transform 0.3s ease;
}

.drag-over {
    background-color: #f0f0f0; /* Changement de couleur de fond pour les conteneurs pendant le drag */
    padding: 10px;
    margin-bottom: 10px;
}

.dragging {
    transform: scale(1.05); /* Agrandissement légèrement l'élément en cours de déplacement */
    box-shadow: 0 0 10px rgba(0,0,0,0.2); /* Ajout d'une ombre pour le mettre en évidence */
}

</style>
<?php 

include "includes/header.php";

ini_set('output_buffering', 'off');
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
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
$etudiantsParPage = 10;
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
                <div class="col-md-3 mb-2 draggable" draggable="true" id="etudiant-<?= $etudiant['id'] ?>">
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

<script>
document.addEventListener('DOMContentLoaded', () => {
    const draggables = document.querySelectorAll('.draggable');
    const containers = document.querySelectorAll('.row');

    draggables.forEach(draggable => {
        draggable.addEventListener('dragstart', () => {
            draggable.classList.add('dragging');
            draggable.style.opacity = '0.5';
        });

        draggable.addEventListener('dragend', () => {
            draggable.classList.remove('dragging');
            draggable.style.opacity = '1';
        });
    });

    containers.forEach(container => {
        container.addEventListener('dragover', e => {
            e.preventDefault();
            const draggable = document.querySelector('.dragging');
            container.appendChild(draggable); // Déplace la carte dans le conteneur actuel

            const afterElement = getDragAfterElement(container, e.clientY);
            if (afterElement) {
                container.insertBefore(draggable, afterElement);
            } else {
                container.appendChild(draggable); // Déplace la carte à la fin du conteneur si aucun élément n'est trouvé
            }
        });

        container.addEventListener('dragenter', () => {
            container.classList.add('drag-over');
        });

        container.addEventListener('dragleave', () => {
            container.classList.remove('drag-over');
        });
    });

    function getDragAfterElement(container, y) {
        const draggableElements = [...container.querySelectorAll('.draggable:not(.dragging)')];

        return draggableElements.reduce((closest, child) => {
            const box = child.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;
            if (offset < 0 && offset > closest.offset) {
                return { offset: offset, element: child };
            } else {
                return closest;
            }
        }, { offset: Number.NEGATIVE_INFINITY }).element;
    }
});

// Confirmation de suppression d'un étudiant
function confirmDelete() {
    return confirm("Êtes-vous sûr de vouloir supprimer cet étudiant ?");
}

</script>

<script src="assets/js/scripts.js"></script>

<?php include "includes/footer.php"; ?>
