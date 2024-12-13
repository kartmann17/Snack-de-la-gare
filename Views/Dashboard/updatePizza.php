<section class="container">
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h2 class="text-center">Mise à jour <?= $pizza['nom'] ?></h2>
                    </div>
                    <div class="card-body">

                        <form action="/DashPizza/updatePizza/<?= $pizza['_id'] ?>" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <input type="hidden" name="id" value="<?= $pizza['_id'] ?>" />

                            <!-- Nom de la pizza -->
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom de la pizza</label>
                                <input type="text" class="form-control" id="nom" name="nom" value="<?= $pizza['nom'] ?>" placeholder="Nom de la pizza" required>
                            </div>

                            <!-- prix -->
                            <div class="mb-3">
                                <label for="age" class="form-label">Prix</label>
                                <input type="number" class="form-control" id="prix" name="prix" value="<?= $pizza['prix'] ?>" placeholder="Prix" required>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" value="<?= $pizza['description'] ?>" rows="4" placeholder="Description de la pizza" required><?= $pizza['description'] ?></textarea>
                            </div>

                            <!-- Boutons de soumission -->
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                                <a href="/DashPizza/liste" class="btn btn-secondary">Annuler</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>