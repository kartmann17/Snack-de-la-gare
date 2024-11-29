<link rel="stylesheet" href="/Asset/css/accueil.css">
<section class="container-fluid ">
    <h2 class=" produit text-center mt-5">Produits de qualité</h2>
    <div class="pres text-center m-auto mt-5 w-75">
        <p>Bienvenue dans le snack de la gare, où la qualité des produits est notre
            priorité.
            Nous mettons un point d'honneur à utiliser des ingrédients frais et soigneusement sélectionnés pour
            préparer nos kebabs, burgers et tacos.
            Tous nos plats sont préparés avec des produits locaux, et chaque recette est réalisée de manière
            artisanale pour garantir une saveur authentique.
            Chez nous, manger sur le pouce ne signifie pas sacrifier la qualité. Venez découvrir la différence
            que font des ingrédients frais et un savoir-faire artisanal.
        </p>
    </div>
    <div class="images m-auto d-flex justify-content-between mt-5">
        <img class="im1" src="Asset/images/arturrro-4yzEtTQLdL4-unsplash.jpg" loading="lazy" width="300" height="200" alt="pain_presentation">
        <img class="im1" src="Asset/images/gaelle-marcel-M-K4R83Rcm0-unsplash.jpg" loading="lazy" width="300" height="200" alt="salade_presentation">
        <img class="im1" src="Asset/images/madie-hamilton-GXehL5_crJ4-unsplash.jpg" loading="lazy" width="300" height="200" alt="viande_presentation">
    </div>
    <div class="pres text-center m-auto mt-5 w-75">
        <p>Avec WALTER, l'originalité est toujours au menu !
            En plus de nos incontournables kebabs, burgers et tacos, nous vous proposons
            chaque mois une recette unique, spécialement conçue pour surprendre vos papilles.
            Que ce soit une sauce innovante, une association de saveurs inédite ou une revisite
            de vos classiques préférés, chaque création est pensée pour vous offrir une expérience
            culinaire nouvelle et excitante. Venez régulièrement découvrir nos nouvelles recettes et
            laissez vous tenter par l'audace de nos créations mensuelles.
        </p>
    </div>
</section>
<!--titre en ce moment avec image en fond-->
<div>
    <div class="image-container mt-5">
        <img src="Asset/images/Pasted_Graphic_1.png" alt="Image" loading="lazy" class="img-fluid">
        <div class="overlay-text">En ce Moment !</div>
    </div>
</div>
<!-- fin titre en ce moment avec image en fond-->

<!--carousel avec produit proposé-->
<section class="container-fluid mt-5 ">
    <div id="carouselExampleSlidesOnly" class="carousels slide custom-carousel m-auto" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="Asset/images/burger.jpg" class="d-block w-100 " loading="lazy" alt="Burger">
            </div>
            <div class="carousel-item">
                <img src="Asset/images/pizza4.jpg" class="d-block w-100 " loading="lazy" alt="Pizza">
            </div>
            <div class="carousel-item">
                <img src="Asset/images/kebab.jpg" class="d-block w-100 " loading="lazy" alt="Kebab">
            </div>
            <div class="carousel-item">
                <img src="Asset/images/Tacos2.jpg" class="d-block w-100 " loading="lazy" alt="Tacos">
            </div>
            <div class="carousel-item">
                <img src="Asset/images/kinder.jpg" class="d-block w-100 " loading="lazy" alt="Kinder">
            </div>
        </div>
    </div>
</section>
<!--fin carousel avec produit proposé-->

<!--titre Nos spécialité avec image en fond-->
<div>
    <div class="image-container mt-5">
        <img src="Asset/images/Pasted_Graphic_1.png" loading="lazy" alt="Image" class="img-fluid">
        <div class="overlay-text">Nos spécialités !</div>
    </div>
</div>
<!-- fin titre nos spécialité avec image en fond-->

<!--rond nos spécialités-->
<div class="specialite mb-5">
    <div class="images m-auto d-flex justify-content-between">
        <img class="im1" src="Asset/images/Burger3.jpg" loading="lazy" width="300" height="200" alt="pain_presentation">
        <img class="im1" src="Asset/images/plaque-pizza-u.jpg" loading="lazy" width="300" height="200" alt="salade_presentation">
        <img class="im1" src="Asset/images/assiette.jpg" loading="lazy" width="300" height="200" alt="viande_presentation">
    </div>
</div>
<!--fin rond nos spécialités-->


<!--titre Vos avis avec image en fond-->
<div>
    <div class="image-container">
        <img src="Asset/images/Pasted_Graphic_1.png" alt="Image" loading="lazy" class="img-fluid">
        <div class="overlay-text">Vos avis !</div>
    </div>
</div>

<!-- fin titre vos avis avec image en fond-->

<section class="avis">

    <!-- caroussel avis-->
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php if (isset($Avis) && !empty($Avis)): ?>
                <?php
                // Filtrer les avis qui ont un champ 'valide' égal à 1
                $avisValides = array_filter($Avis, function ($avis) {
                    return $avis->valide == 1;
                });

                // Vérifier s'il y a des avis valides après filtrage
                if (!empty($avisValides)) {
                    // Séparation des avis valides en groupes de 3 pour le carousel
                    $avisChunks = array_chunk($avisValides, 2);
                    $activeClass = 'active'; // activation de la première feuille
                    foreach ($avisChunks as $avisGroup): ?>
                        <div class="carousel-item <?= $activeClass; ?>">
                            <div class="row justify-content-center m-auto w-75">
                                <?php foreach ($avisGroup as $valide): ?>
                                    <div class="col-12 col-md-4 mb-3">
                                        <div class="card text-bg-light mb-3">
                                            <div class="card-header d-flex justify-content-center column-gap-4">
                                                <?php
                                                for ($i = 1; $i <= 5; $i++) {
                                                    if ($i <= $valide->etoiles) {
                                                        echo '<span class="star-filled">&#9733;</span>';
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <div class="card-body text-center overflow-auto">
                                                <h5 class="card-title"><?= $valide->nom ?></h5>
                                                <p class="card-text"><?= $valide->commentaire ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php $activeClass = ''; ?>
                    <?php endforeach; ?>
                <?php } else { ?>
                    <p>Aucun avis valide pour le moment.</p>
                <?php } ?>
            <?php else: ?>
                <p>Aucun avis pour le moment.</p>
            <?php endif; ?>
        </div>
    </div>
</section>