
<section class="container">
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h2 class="text-center">Mise à jour <?= $soft['nom'] ?></h2>
                    </div>
                    <div class="card-body">

                        <form action="/DashSofts/updateSoft/<?= $soft['_id'] ?>" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <input type="hidden" name="id" value="<?= $soft['_id'] ?>" />

                            <!-- Nom du soft -->
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom du soft</label>
                                <input type="text" class="form-control" id="nom" name="nom" value="<?= $soft['nom'] ?>" placeholder="Nom du soft" required>
                            </div>

                            <!-- prix du soft -->
                            <div class="mb-3">
                                <label for="nom" class="form-label">Prix du soft</label>
                                <input type="text" class="form-control" id="prix" name="prix" value="<?= $soft['prix'] ?>" placeholder="prix du soft" required>
                            </div>

                            <!-- Boutons de soumission -->
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                                <a href="/DashSofts/liste" class="btn btn-secondary">Annuler</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>