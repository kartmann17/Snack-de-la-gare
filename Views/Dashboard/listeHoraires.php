<?php
echo '<link rel="stylesheet" href="/Asset/css/food.css">';
?>

<div class="container mt-5 mb-5 horaires-container">
    <h2 class="mb-4">Gestion des Horaires</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Jour</th>
                    <th>Heure d'ouverture matin</th>
                    <th>Heure d'ouverture après-midi</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($horaires as $horaire): ?>

                    <tr>
                        <td><?= $horaire->jour ?></td>
                        <td><?= $horaire->ouverture_M ?></td>
                        <td><?= $horaire->ouverture_S ?></td>
                        <td>
                            <div class="d-flex justify-content-between">
                                <a href="/DashHoraire/updateHoraire/<?= $horaire->_id ?>" class="btn btn-warning">Modifier</a>
                                <form action="/DashHoraire/deleteHoraire/<?= $horaire->_id ?>" method="POST" onsubmit="return confirm('êtes-vous sûr de vouloir supprimer cet horaire ?');">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <input type="hidden" name="id" value="<?= $horaire->_id ?>">
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
        <a href="/dash" class="btn btn-secondary">Annuler</a>
    </div>
</div>