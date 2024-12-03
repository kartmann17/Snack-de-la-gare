<?php
echo '<link rel="stylesheet" href="/Asset/css/food.css">';
?>

<div class="container mt-5 mb-5 service-container">
    <h2 class="mb-4 text-center">Gestion en ce moment page d'accueil </h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Images</th>
                    <th class="table-actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($encemoments as $encemoment): ?>
                    <tr>
                        <td>
                            <img src="<?= $encemoment->img ?>" alt="Image en ce moment" class="img-fluid" style="max-width: 200px; height: auto;">
                        </td>
                        <td class="table-actions">
                            <div class="d-flex">
                                <form action="/DashEnCeMoment/deleteEnCeMoment" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette image ?');">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <input type="hidden" name="id" value="<?= $encemoment->id ?>">
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