document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("inscriptionForm").addEventListener("submit", function(e) {
        let isValid = true;

        // Réinitialiser les messages d'erreur
        document.querySelectorAll('.error').forEach(function(errorDiv) {
            errorDiv.textContent = '';
        });

        // Récupérer les valeurs du formulaire
        let nom = document.getElementById('nom').value;
        let prenom = document.getElementById('prenom').value;
        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;
        let confirm_pwd = document.getElementById('confirm_pwd').value;

        // Vérification du nom
        if (!nom) {
            document.getElementById('errorNom').textContent = 'Le nom est requis.';
            document.getElementById('nom').style.border = '1px solid red';
            isValid = false;
        }
        else if (nom.length < 2) {
            document.getElementById('errorNom').textContent = 'Le nom doit faire au moins 2 caractères.';
            document.getElementById('nom').style.border = '1px solid red';
            isValid = false;
        }

        // Vérification du prénom
        if (!prenom) {
            document.getElementById('errorPrenom').textContent = 'Le prénom est requis.';
            document.getElementById('prenom').style.border = '1px solid red';
            isValid = false;
        }
        else if (prenom.length < 2) {
            document.getElementById('errorPrenom').textContent = 'Le prénom doit faire au moins 2 caractères.';
            document.getElementById('prenom').style.border = '1px solid red';
            isValid = false;
        }

        if (!email) {
            document.getElementById('errorEmail').textContent = 'L\'email est requis.';
            document.getElementById('email').style.border = '1px solid red';
            isValid = false;
        }
        else if (!/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i.test(email)) {
            document.getElementById('errorEmail').textContent = 'L\'email est invalide.';
            document.getElementById('email').style.border = '1px solid red';
            isValid = false;
        }

        // Vérification du mot de passe
        if (!password) {
            document.getElementById('errorPwd').textContent = 'Le mot de passe est requis.';
            document.getElementById('password').style.border = '1px solid red';
            isValid = false;
        }
        else if (password.length < 8) {
            document.getElementById('errorPwd').textContent = 'Le mot de passe doit faire au moins 8 caractères.';
            document.getElementById('password').style.border = '1px solid red';
            isValid = false;
        }

        // Vérification du mot de passe de confirmation
        if (!confirm_pwd) {
            document.getElementById('errorConfirmPwd').textContent = 'Le mot de passe de confirmation est requis.';
            document.getElementById('confirm_pwd').style.border = '1px solid red';
            isValid = false;
        }
        else if (password!== confirm_pwd) {
            document.getElementById('errorConfirmPwd').textContent = 'Les mots de passe ne correspondent pas.';
            document.getElementById('confirm_pwd').style.border = '1px solid red';
            isValid = false;
        }

        // Si le formulaire n'est pas valide, empêcher sa soumission
        if (!isValid) {
            e.preventDefault();
        }
    });
    
});

// Confirmation de suppression d'un étudiant
function confirmDelete() {
    return confirm("Êtes-vous sûr de vouloir supprimer cet étudiant ?");
}


