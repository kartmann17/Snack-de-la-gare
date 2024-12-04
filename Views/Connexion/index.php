<link rel="stylesheet" href="/Asset/css/connexion.css">
<div>
    <div class="image-container">
        <img src="https://res.cloudinary.com/dr7jxgr70/image/upload/v1733222366/Pasted_Graphic_1_ecmuft.png" alt="Image" class="img-fluid">
        <div class="overlay-text">Connexion</div>
    </div>
</div>

<div class="login-container mt-5">
    <h2>Connexion</h2>
    <form action="/Connexion/connexion" method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <label for="username">e-mail</label>
        <input type="text" id="username" name="email" required>

        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="pass" required>

        <button type="submit">Se connecter</button>
    </form>
</div>