<?php
echo '<link rel="stylesheet" href="/Asset/css/food.css">';
?>
<div class="container mt-5 mb-5 service-container">
    <h2 class="mb-4 text-center">Gestion des Viandes</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th class="table-nom">Nom</th>
                    <th class="table-actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($viandes as $viande): ?>
                    <tr>
                        <td class="table-nom" title="<?= $viande->nom ?>"><?= $viande->nom ?></td>
                        <td class="table-actions">
                            <div class="d-flex">
                                <a href="/DashViande/updateViande/<?= $viande->id ?>" class="btn btn-warning btn-sm me-1">Modifier</a>
                                <form action="/DashViande/deleteViande" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette viande ?');" style="display: inline;">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <input type="hidden" name="id" value="<?= $viande->id ?>">
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