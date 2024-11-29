<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snack de la Gare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/Asset/css/navbar.css">
    <link rel="stylesheet" href="/Asset/css/footer.css">
    <link rel="apple-touch-icon" sizes="180x180" href="/Asset/icones/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/Asset/icones/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/Asset/icones/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/Asset/icones/favicon-32x32.png">
    <link rel="manifest" href="/Asset/icones/site.webmanifest">
</head>

<body>
<nav class="navbar navbar-expand-lg bg-body-transparent">
    <div class="container-fluid d-flex align-items-center justify-content-between">

        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="/Asset/images/logoV2.png" alt="logo-accueil" height="60">
        </a>
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Liens de navigation -->
        <div class="collapse navbar-collapse justify-content-center" id="navbarNavAltMarkup">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Contact">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Menu">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Avis">Avis</a>
                </li>
                <?php if (isset($_SESSION['id_User'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/Connexion/deconnexion" onclick="return confirm('Voulez vous vous déconnecter ?');">Déconnexion</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/Connexion">Connexion</a>
                    </li>
                <?php endif; ?>
                <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'employe')): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/Dashboard">Dashboard</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

    <div class="burger">
        <img class="burgeur" src="/Asset/images/burger_page_acceuil.jpeg" width="600" height="400" loading="lazy" alt="un burgeur délicieux">
    </div>
    <div class="bloc_num d-flex align-items-center justify-content-center mt-5">
        <div class="text-center">
            <h1>Commander</h1>
            <div class="d-flex align-items-center">
                <a class="numero align-middle" href="tel:0476385922">04 76 38 59 22</a>
            </div>
        </div>
    </div>

    <main>
        <?= $contenu ?><!--raccourci de echo en php-->
    </main>


    <div class="footer-wrapper">
        <footer class="footer-container">
            <ul class="wrapper">
                <li class="icon facebook">
                    <span class="tooltip">Facebook</span>
                    <svg
                        viewBox="0 0 320 512"
                        height="1.2em"
                        fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path>
                    </svg>
                </li>
                <li class="icon instagram">
                    <span class="tooltip">Instagram</span>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        height="1.2em"
                        fill="currentColor"
                        class="bi bi-instagram"
                        viewBox="0 0 16 16">
                        <path
                            d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"></path>
                    </svg>
                </li>
            </ul>
            <div class="address text-center">
                <p>95 route de St Lattier</p>
                <p>38840 St Hilaire du Rosier</p>
                <p>04 76 38 59 22</p>
            </div>
            <div class="copyright">
                <p>&copy; 2024 - Snack de la gare</p>
            </div>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>

</html>