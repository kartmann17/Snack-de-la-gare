<?php
echo '<link rel="stylesheet" href="/Asset/css/food.css">';
?>
<div class="container mt-5 mb-5 service-container">
    <h2 class="mb-4 text-center">Gestion des Snacks</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th class="table-nom">Nom</th>
                    <th>Prix</th>
                    <th class="table-description">Description</th>
                    <th class="table-actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($snacks as $snack): ?>
                    <tr>
                        <td class="table-nom" title="<?= $snack->nom ?>">
                            <?= $snack->nom ?>
                        </td>
                        <td><?= $snack->prix ?></td>
                        <td class="table-description" title="<?= $snack->description ?>">
                            <?= $snack->description ?>
                        </td>
                        <td class="table-actions">
                            <div class="d-flex">
                                <a href="/DashSnack/updateSnack/<?= $snack->_id ?>" class="btn btn-warning btn-sm me-1">Modifier</a>
                                <form action="/DashSnack/deleteSnack" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce snack ?');" style="display: inline;">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <input type="hidden" name="id" value="<?= $snack->_id ?>">
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