<section class="container">
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h2 class="text-center">Mise à jour <?= $snack->nom ?></h2>
                    </div>
                    <div class="card-body">

                        <form action="/DashSnack/updateSnack/<?= $snack->id ?>" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <input type="hidden" name="id" value="<?= $snack->id ?>" />

                            <!-- Nom de la salade -->
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom du snack</label>
                                <input type="text" class="form-control" id="nom" name="nom" value="<?= $snack->nom ?>" placeholder="Nom du snack" required>
                            </div>

                            <!-- prix -->
                            <div class="mb-3">
                                <label for="age" class="form-label">Prix</label>
                                <input type="number" class="form-control" id="prix" name="prix" value="<?= $snack->prix ?>" placeholder="Prix" required>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" value="<?= $snack->description ?>" rows="4" placeholder="Description du snack" required><?= $snack->description ?></textarea>
                            </div>

                            <!-- Boutons de soumission -->
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                                <a href="/DashSnack/liste" class="btn btn-secondary">Annuler</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>