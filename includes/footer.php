    <footer class="bg-light text-center text-lg-start border-top">
        <div class="text-center p-3">
            © 2023 Toto - Tous droits réservés
            <a class="text-dark" href="https://votresite.com/">votresite.com</a>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        // Recherche d'un étudiant
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let searchQuery = this.value.toLowerCase();
            let tableRows = document.querySelectorAll('table tbody tr');

            tableRows.forEach(function(row) {
                let nom = row.querySelector('td:first-child').textContent.toLowerCase();
                let prenom = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                let email = row.querySelector('td:nth-child(3)').textContent.toLowerCase();

                if (nom.includes(searchQuery) || prenom.includes(searchQuery) || email.includes(searchQuery)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

    </script>

</body>
</html>



