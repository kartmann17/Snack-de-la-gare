<section class="container">
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h2 class="text-center">Mise à jour <?= $biere->nom ?></h2>
                    </div>
                    <div class="card-body">

                        <form action="/DashBieres/updateBiere/<?= $biere->id ?>" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <input type="hidden" name="id" value="<?= $biere->id ?>" />

                            <!-- Nom de la biere -->
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom de la biere</label>
                                <input type="text" class="form-control" id="nom" name="nom" value="<?= $biere->nom ?>" placeholder="Nom de la biere" required>
                            </div>

                            <!-- prix de la biere -->
                            <div class="mb-3">
                                <label for="nom" class="form-label">Prix de la biere</label>
                                <input type="text" class="form-control" id="prix" name="prix" value="<?= $biere->prix ?>" placeholder="prix de la biere" required>
                            </div>

                            <!-- Boutons de soumission -->
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                                <a href="/DashBieres/liste" class="btn btn-secondary">Annuler</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>