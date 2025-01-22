<?php
$css = 'food';
?>

<div class="container mt-5 mb-5 service-container">
    <h2 class="mb-4 text-center">Gestion des Burgers</h2>

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
                <?php foreach ($burgers as $burger): ?>
                    <tr>
                        <td class="table-nom" title="<?= $burger->nom ?>">
                            <?= $burger->nom ?>
                        </td>
                        <td><?= $burger->solo ?></td>
                        <td><?= $burger->menu ?></td>
                        <td class="table-description" title="<?= $burger->description ?>">
                            <?= $burger->description ?>
                        </td>
                        <td>
                            <img src="<?= $burger->img ?>" class="img-thumbnail" alt="image de <?= $burger->nom ?>"/>
                        </td>
                        <td class="table-actions">
                            <div class="d-flex">
                                <a href="/DashBurgers/updateBurger/<?= $burger->_id ?>" class="btn btn-warning btn-sm me-1">Modifier</a>
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                    <form action="/DashBurgers/deleteBurger" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce burger ?');">
                                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                        <input type="hidden" name="id" value="<?= $burger->_id ?>">
                                        <button class="btn btn-danger btn-sm">Supprimer</button>
                                    </form>
                                    <?php endif;?>
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