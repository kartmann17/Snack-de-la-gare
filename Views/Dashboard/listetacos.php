<?php
$css = 'food';
?>
<div class="container mt-5 mb-5 service-container">
    <h2 class="mb-4 text-center">Gestion des Tacos</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th class="table-nom">Nom</th>
                    <th>Prix-Solo</th>
                    <th>Prix-Menu</th>
                    <th class="table-description">Description</th>
                    <th>Images</th>
                    <th class="table-actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tacos as $taco): ?>
                    <tr>
                        <td class="table-nom" title="<?= $taco->nom ?>"><?= $taco->nom ?></td>
                        <td><?= $taco->solo ?></td>
                        <td><?= $taco->menu ?></td>
                        <td class="table-description" title="<?= $taco->description ?>"><?= $taco->description ?></td>
                        <td>
                            <img src="<?= $taco->img ?>" class="img-thumbnail" alt="image de <?= $taco->nom ?>" />
                        </td>
                        <td class="table-actions">
                            <div class="d-flex">
                                <a href="/DashTacos/updateTacos/<?= $taco->_id ?>" class="btn btn-warning btn-sm me-1">Modifier</a>
                                <form action="/DashTacos/deleteTacos" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce tacos ?');">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <input type="hidden" name="id" value="<?= $taco->_id ?>">
                                    <button class="btn btn-danger btn-sm">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="text-end">
        <a href="/Dashboard" class="btn btn-secondary">Annuler</a>
    </div>
</div>