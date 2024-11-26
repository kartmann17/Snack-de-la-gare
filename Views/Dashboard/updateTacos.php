
<section class="container">
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h2 class="text-center">Mise à jour <?= $tacos->nom ?></h2>
                    </div>
                    <div class="card-body">

                        <form action="/DashTacos/updateTacos/<?= $tacos->id ?>" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <input type="hidden" name="id" value="<?= $tacos->id ?>" />

                            <!-- Nom du taco -->
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom du tacos</label>
                                <input type="text" class="form-control" id="nom" name="nom" value="<?= $tacos->nom ?>" placeholder="Nom du taco" required>
                            </div>

                            <!-- prix solo -->
                            <div class="mb-3">
                                <label for="age" class="form-label">Prix solo</label>
                                <input type="number" class="form-control" id="age" name="solo" value="<?= $tacos->solo ?>" placeholder="Prix solo" required>
                            </div>

                            <!-- Prix Menu -->
                            <div class="mb-3">
                                <label for="age" class="form-label">Prix Menu</label>
                                <input type="number" class="form-control" id="age" name="menu" value="<?= $tacos->menu ?>" placeholder="Prix Menu" required>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" value="<?= $tacos->description ?>" rows="4" placeholder="Description du tacos" required><?= $tacos->description ?></textarea>
                            </div>

                            <!-- image actuelle -->
                            <div class="mb-3">
                                <label for="current_image" class="form-label">Image actuelle</label>
                                <div class="mb-3">
                                    <img src="/Asset/Images/<?= htmlspecialchars($tacos->img, ENT_QUOTES, 'UTF-8') ?>" alt="Image actuelle" class="img-fluid">
                                </div>
                            </div>

                            <!-- URL de l'image -->
                            <div class="mb-3">
                                <label for="image" class="form-label">Nouvelle image (optionnelle)</label>
                                <input type="file" class="form-control" id="image" name="img" accept="image/*">
                                <small class="form-text text-muted">Laissez ce champ vide si vous ne voulez pas changer l'image.</small>
                            </div>


                            <!-- Boutons de soumission -->
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                                <a href="/DashTacos/liste" class="btn btn-secondary">Annuler</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>