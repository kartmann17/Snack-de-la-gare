<link rel="stylesheet" href="/Asset/css/contact.css">
<div>
    <div class="image-container">
        <img src="https://res.cloudinary.com/dr7jxgr70/image/upload/v1733222366/Pasted_Graphic_1_ecmuft.png" alt="Image" class="img-fluid">
        <div class="overlay-text">Nos Horaires</div>
    </div>
</div>

<div class="banner m-auto mt-5 w-75">
    <?php
    // Trier les horaires par `_id`
    usort($horaires, function ($a, $b) {
        return strcmp((string)$a['_id'], (string)$b['_id']);
    });
    ?>

    <?php foreach ($horaires as $horaire): ?>
        <p>
            <strong><?= htmlspecialchars($horaire['jour']) ?></strong><br>
            <?= htmlspecialchars($horaire['ouverture_M']) ?>
            <?php if (!empty($horaire['ouverture_M']) && !empty($horaire['ouverture_S'])): ?>
                et
            <?php endif; ?>
            <?= htmlspecialchars($horaire['ouverture_S']) ?>
        </p>
    <?php endforeach; ?>
</div>

<div class="mt-5 mb-5">
    <div class="image-container">
        <img src="https://res.cloudinary.com/dr7jxgr70/image/upload/v1733222366/Pasted_Graphic_1_ecmuft.png" alt="Image" class="img-fluid">
        <div class="overlay-text">Nous trouver</div>
    </div>
</div>

<iframe class="mt-5" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2322.9232966594304!2d5.241962956264683!3d45.070764443733424!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x478ab08b9fc18397%3A0x9e29ca2e8f35729e!2s95%20Rte%20de%20Saint-Lattier%2C%2038840%20Saint-Hilaire-du-Rosier!5e0!3m2!1sfr!2sfr!4v1730811417624!5m2!1sfr!2sfr"
width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"> Map Snack de la gare</iframe>

<div class="m-auto adresse text-center mt-5">
    <p>95 route de St Lattier <br> 38840 St Hilaire du Rosier</p>
</div>
