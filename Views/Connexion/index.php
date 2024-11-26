<link rel="stylesheet" href="/Asset/css/connexion.css">
<div>
    <div class="image-container">
        <img src="Asset/images/Pasted_Graphic_1.png" alt="Image" class="img-fluid">
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