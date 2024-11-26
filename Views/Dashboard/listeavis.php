<?php
echo '<link rel="stylesheet" href="/Asset/css/food.css">';
?>
<div class="container mt-5 mb-5 avis-container">
    <h2 class="mb-4 text-center">Liste des Avis</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Etoiles</th>
                    <th>Nom</th>
                    <th class="col-commentaire">Commentaire</th>
                    <th class="col-actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($Avis as $avis): ?>
                    <tr>
                        <td><?= $avis->etoiles ?></td>
                        <td><?= $avis->nom ?></td>
                        <td class="text-truncate table-commentaire"><?= $avis->commentaire ?></td>
                        <td class="table-actions">
                            <div class="d-flex">
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                    <form action="/DashValideAvis/deleteAvis" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet avis ?');">
                                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                        <input type="hidden" name="id" value="<?= $avis->id ?>">
                                        <button class="btn btn-danger btn-sm me-1">Supprimer</button>
                                    </form>
                                <?php endif; ?>
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