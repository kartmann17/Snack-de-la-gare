<section class="container">
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h2 class="text-center">Mise à jour <?= $supplement['nom'] ?></h2>
                    </div>
                    <div class="card-body">

                        <form action="/DashSupplements/updateSupplement/<?= $supplement['_id'] ?>" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <input type="hidden" name="id" value="<?= $supplement['_id'] ?>" />

                            <!-- Nom du supplement -->
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom du supplement</label>
                                <input type="text" class="form-control" id="nom" name="nom" value="<?= $supplement['nom'] ?>" placeholder="Nom de la sauce" required>
                            </div>

                            <!-- Boutons de soumission -->
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                                <a href="/DashSupplements/liste" class="btn btn-secondary">Annuler</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>