<?php
$css = 'food';
?>
<div class="container mt-5 mb-5 users-container">
    <h2 class="mb-4 text-center">Gestion des Utilisateurs</h2>


    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user->nom ?></td>
                        <td><?= $user->prenom ?></td>
                        <td><?= $user->email ?></td>
                        <td><?= $user->role ?></td>
                        <td>
                            <div class="d-flex justify-content-between">
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                <form action="/DashUser/deleteUser" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <input type="hidden" name="id" value="<?= $user->id ?>">
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