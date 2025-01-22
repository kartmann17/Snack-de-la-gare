<?php
echo '<link rel="stylesheet" href="/Asset/css/food.css">';
?>
<div class="container mt-5 mb-5 service-container">
    <h2 class="mb-4 text-center">Gestion des Kebabs</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th class="table-nom">Nom</th>
                    <th>Prix-Solo</th>
                    <th>Prix-Menu</th>
                    <th>Prix-Assiette</th>
                    <th class="table-description">Description</th>
                    <th>Images</th>
                    <th class="table-actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kebabs as $kebab): ?>
                    <tr>
                        <td class="table-nom" title="<?= $kebab->nom ?>">
                            <?= $kebab->nom ?>
                        </td>
                        <td><?= isset($kebab['solo']) ? htmlspecialchars($kebab['solo']) : ''; ?></td>
                        <td><?= isset($kebab['menu']) ? htmlspecialchars($kebab['menu']) : ''; ?></td>
                        <td><?= isset($kebab['assiette']) ? htmlspecialchars($kebab['assiette']) : ''; ?></td>
                        <td class="table-description" title="<?=isset($kebab['description']) ?>"><?= isset($kebab['description']) ? htmlspecialchars($kebab['description']) : ''; ?></td>
                        <td>
                            <img src="<?= $kebab->img ?>" class="img-thumbnail" alt="image de <?= $kebab->nom ?>" />
                        </td>
                        <td class="table-actions">
                            <div class="d-flex">
                                <a href="/DashKebabs/updateKebab/<?= $kebab->_id ?>" class="btn btn-warning btn-sm me-1">Modifier</a>
                                <form action="/DashKebabs/deleteKebab" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce kebab ?');">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <input type="hidden" name="id" value="<?= $kebab->_id ?>">
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