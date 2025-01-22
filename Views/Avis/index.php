<?php
$css = 'avis';
?>
<div>
    <div class="image-container">
        <img src="https://res.cloudinary.com/dr7jxgr70/image/upload/v1733222366/Pasted_Graphic_1_ecmuft.png" alt="Image" class="img-fluid">
        <div class="overlay-text">Vos Avis</div>
    </div>
</div>

<!-- formulaire avis  -->
<div class="review-form-container mt-5">
    <form class="review-form" id="avisForm" action="/Avis/ajoutAvis" method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <h2>Votre avis nous intéresse</h2>

        <!-- Étoiles -->
        <div class="form-group rating">
        <div class="stars">
                <input type="radio" id="star5" name="etoiles" value="5"><label for="star5" title="5 étoiles">&#9733;</label>
                <input type="radio" id="star4" name="etoiles" value="4"><label for="star4" title="4 étoiles">&#9733;</label>
                <input type="radio" id="star3" name="etoiles" value="3"><label for="star3" title="3 étoiles">&#9733;</label>
                <input type="radio" id="star2" name="etoiles" value="2"><label for="star2" title="2 étoiles">&#9733;</label>
                <input type="radio" id="star1" name="etoiles" value="1"><label for="star1" title="1 étoile">&#9733;</label>
            </div>
        </div>

        <!-- nom -->
        <div class="form-group">
            <input type="text" id="pseudo" name="nom" placeholder="Pseudo" required>
        </div>

        <!-- Commentaire -->
        <div class="form-group">
            <textarea id="commentaire" name="commentaire" rows="4" placeholder="Votre commentaire" required></textarea>
        </div>

        <!-- Bouton Soumettre -->
        <button type="submit">Envoyer</button>
    </form>
</div>
<!-- fin formulaire avis -->
<script src="/Asset/Js/asyncavis.js"></script>