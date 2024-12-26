<?php
$css = 'food';
?>
<div class="container mt-5 mb-5 service-container">
    <h2 class="mb-4 text-center">Gestion des Sauces</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th class="table-nom">Nom</th>
                    <th class="table-actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sauces as $sauce): ?>
                    <tr>
                        <td class="table-nom" title="<?= $sauce->nom ?>"><?= $sauce->nom ?></td>
                        <td class="table-actions">
                            <div class="d-flex">
                                <a href="/DashSauce/updateSauce/<?= $sauce->_id ?>" class="btn btn-warning btn-sm me-1">Modifier</a>
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                    <form action="/DashSauce/deleteSauce" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette sauce ?');" style="display: inline;">
                                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                        <input type="hidden" name="id" value="<?= $sauce->_id ?>">
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