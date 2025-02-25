<?php
$css = 'menu';
?>

<!-- Section Burgers -->
<h2>Nos Burgers</h2>
<div class="menu-container">
    <div class="burgers">
        <?php foreach ($burgers as $burger): ?>
            <div class="burger-item">
                <h3><?= htmlspecialchars($burger['nom']); ?></h3>
                <h4 class="price">
                    Solo: <?= htmlspecialchars($burger['solo']); ?>€ | Menu: <?= htmlspecialchars($burger['menu']); ?>€
                </h4>
                <p><?= htmlspecialchars($burger['description']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="band">
        <h2>Le menu comprend frites et boisson au choix</h2>
    </div>
</div>

<!-- Section Pizza -->
<h2>Nos Pizzas</h2>
<div class="menu-container">
    <div class="pizza mt-5">
        <?php foreach ($pizzas as $pizza): ?>
            <div class="pizza-item">
                <h3><?= htmlspecialchars($pizza['nom']); ?> <?= htmlspecialchars($pizza['prix']); ?> €</h3>
                <p><?= htmlspecialchars($pizza['description']); ?></p>
            </div>
        <?php endforeach; ?>
        <div class="space"></div>
    </div>
</div>

<!-- Section Tacos -->
<section>
    <h2>Nos Tacos</h2>
    <div class="menu-container mt-5">
        <div class="burgers">
            <?php foreach ($tacos as $taco): ?>
                <div class="tacos-item">
                    <h3>
                        <?= htmlspecialchars($taco['nom']); ?>
                        Solo: <?= htmlspecialchars($taco['solo']); ?>€ | Menu: <?= htmlspecialchars($taco['menu']); ?>€
                    </h3>
                </div>
            <?php endforeach; ?>

            <h2 class="mt-5 color">Nos Viandes</h2>
            <div class="container">
                <div class="row">
                    <!-- Viandes colonne gauche -->
                    <div class="col-md-6">
                        <?php foreach ($viande as $index => $viand): ?>
                            <?php if ($index % 2 == 0): ?>
                                <div class="viande-item">
                                    <h3><?= htmlspecialchars($viand['nom']); ?></h3>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <!-- Viandes colonne droite -->
                    <div class="col-md-6">
                        <?php foreach ($viande as $index => $viand): ?>
                            <?php if ($index % 2 != 0): ?>
                                <div class="viande-item">
                                    <h3><?= htmlspecialchars($viand['nom']); ?></h3>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="color">Nos Sauces</h2>
        <div class="container text-center w-75">
            <h4 class="mb-5">
                <?php foreach ($sauce as $sauc): ?>
                    <span class="sauce-item"><?= htmlspecialchars($sauc['nom']); ?>,</span>
                <?php endforeach; ?>
            </h4>
        </div>

        <h2 class="mt-5 color">Suppléments</h2>
        <div class="container text-center w-75">
            <h4 class="mb-5">
                <?php foreach ($supplements as $supplement): ?>
                    <span class="sauce-item"><?= htmlspecialchars($supplement['nom']); ?>,</span>
                <?php endforeach; ?>
            </h4>
        </div>
    </div>
</section>

<!-- Section Kebabs -->
<section>
    <h2>Nos Kebabs</h2>
    <?php
// Tri des données par ID
usort($kebabs, function ($a, $b) {
    return strcmp((string)$a['_id'], (string)$b['_id']); // Comparaison lexicographique des IDs
});
?>

<div class="menu-container mt-5 text-center">
    <?php if (!empty($kebabs) && count($kebabs) >= 3): ?>
        <div class="kebab-item mt-5">
            <h3>
                <?= htmlspecialchars($kebabs[0]['nom'] ?? 'Nom non disponible'); ?> :<?= htmlspecialchars($kebabs[0]['solo'] ?? 'Prix non disponible'); ?>€
            </h3>
            <h3>
                <?= htmlspecialchars($kebabs[1]['nom'] ?? 'Nom non disponible'); ?> :<?= htmlspecialchars($kebabs[1]['menu'] ?? 'Prix non disponible'); ?>€
            </h3>
            <h3>
                <?= htmlspecialchars($kebabs[2]['nom'] ?? 'Nom non disponible'); ?> :<?= htmlspecialchars($kebabs[2]['assiette'] ?? 'Prix non disponible'); ?>€
            </h3>

            <?php if (!empty($kebabs[3])): ?>
                <p class="description">
                    <?= htmlspecialchars($kebabs[3]['nom'] ?? 'Nom non disponible'); ?> :<?= htmlspecialchars($kebabs[3]['description'] ?? 'Description non disponible'); ?>
                </p>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <p>Aucune donnée à afficher.</p>
    <?php endif; ?>


        <div class="vide"></div>

        <h2 class="color mt-5">Nos Sauces</h2>
        <div class="container text-center w-75">
            <h4 class="mt-5">
                <?php foreach ($sauce as $sauc): ?>
                    <span class="sauce-item"><?= htmlspecialchars($sauc['nom']); ?>,</span>
                <?php endforeach; ?>
            </h4>
        </div>
    </div>
</section>

<!-- Section salades -->
<h2>Nos Salades</h2>
<div class="menu-container ">
    <div class="pizza mt-5">
        <?php foreach ($salades as $salade): ?>
            <div class="pizza-item">
                <h3><?= htmlspecialchars($salade['nom']); ?> <?= htmlspecialchars($salade['prix']); ?> €</h3>
                <p><?= htmlspecialchars($salade['description']); ?></p>
            </div>
        <?php endforeach; ?>
        <div class="space"></div>
    </div>
</div>


<!-- Section Nos Snack -->
<h2>Nos Snacks</h2>
<div class="menu-container">
    <div class="pizza mt-5">
        <?php foreach ($snack as $snac): ?>
            <div class="pizza-item">
                <h3><?= htmlspecialchars($snac['nom']); ?> <?= htmlspecialchars($snac['prix']); ?> €</h3>
                <p><?= htmlspecialchars($snac['description']); ?></p>
            </div>
        <?php endforeach; ?>
        <div class="space"></div>
    </div>
</div>

<!-- Section Boissons -->
<section>
    <h2>Nos Boissons</h2>
    <div class="menu-container text-center">
        <!-- Softs -->
        <div class="bands mt-5">
            <h2>Nos Softs</h2>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?php foreach ($soft as $index => $sof): ?>
                    <?php if ($index % 2 == 0): ?>
                        <div class="soft-item">
                            <h3><?= htmlspecialchars($sof['nom']); ?></h3>
                            <p class="price"><?= htmlspecialchars($sof['prix']); ?></p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="col-md-6">
                <?php foreach ($soft as $index => $sof): ?>
                    <?php if ($index % 2 != 0): ?>
                        <div class="soft-item">
                            <h3><?= htmlspecialchars($sof['nom']); ?></h3>
                            <p class="price"><?= htmlspecialchars($sof['prix']); ?></p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Vins -->
        <div class="band mt-5">
            <h2>Nos Vins</h2>
        </div>
        <?php foreach ($vins as $vin): ?>
            <div class="vins-item text-center">
                <h3><?= htmlspecialchars($vin['nom']); ?></h3>
                <h4 class="price">Prix: <?= htmlspecialchars($vin['prix']); ?>€</h4>
            </div>
        <?php endforeach; ?>

        <!-- Bières -->
        <div class="band mt-5">
            <h2>Nos Bières</h2>
        </div>
        <?php foreach ($bieres as $biere): ?>
            <div class="biere-item text-center mb-5">
                <h3><?= htmlspecialchars($biere['nom']); ?></h3>
                <h4 class="price">Prix: <?= htmlspecialchars($biere['prix']); ?>€</h4>
            </div>
        <?php endforeach; ?>
    </div>
</section>