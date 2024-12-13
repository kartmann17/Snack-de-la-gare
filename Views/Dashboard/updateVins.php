<section class="container">
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h2 class="text-center">Mise à jour <?= $vins['nom'] ?></h2>
                    </div>
                    <div class="card-body">

                        <form action="/DashVins/updateVins/<?= $vins['_id'] ?>" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <input type="hidden" name="id" value="<?= $vins['_id'] ?>" />

                            <!-- Nom du vins -->
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom du vins</label>
                                <input type="text" class="form-control" id="nom" name="nom" value="<?= $vins['nom'] ?>" placeholder="Nom du vins" required>
                            </div>

                            <!-- prix du vins -->
                            <div class="mb-3">
                                <label for="nom" class="form-label">Prix du vins</label>
                                <input type="text" class="form-control" id="prix" name="prix" value="<?= $vins['prix'] ?>" placeholder="prix du vins" required>
                            </div>

                            <!-- Boutons de soumission -->
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                                <a href="/DashVins/liste" class="btn btn-secondary">Annuler</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>