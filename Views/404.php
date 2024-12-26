<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Asset/css/404.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="apple-touch-icon" sizes="180x180" href="/Asset/icones/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/Asset/icones/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/Asset/icones/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/Asset/icones/favicon-32x32.png">
    <link rel="manifest" href="/Asset/icones/site.webmanifest">
    <title>404 - Page non trouvée</title>
</head>

<body>
<nav class="navbar navbar-expand-lg bg-body-transparent">
    <div class="container-fluid d-flex align-items-center justify-content-between">

        <a class="navbar-brand d-flex align-items-center logo" href="/">
            <img src="https://res.cloudinary.com/dr7jxgr70/image/upload/v1733222368/logoV2_xgml3q.png" alt="logo-accueil" height="60">
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
    <div class="game-container">
        <h1>404 - Page non trouvée</h1>
        <p>Oups ! Cette page n'existe pas. Amusez-vous avec ce jeu de Pong pendant que vous y êtes !</p>
        <div id="score-container">
            <p>Score : <span id="score">0</span></p>
        </div>
        <canvas id="gameCanvas" width="600" height="400"></canvas>
        <script src="/Asset/Js/pong.js"></script>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>

</html>