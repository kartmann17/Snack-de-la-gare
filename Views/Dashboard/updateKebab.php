<section class="container">
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h2 class="text-center">Mise à jour <?= htmlspecialchars($kebab['nom'], ENT_QUOTES, 'UTF-8') ?></h2>
                    </div>
                    <div class="card-body">
                        <form action="/DashKebabs/updateKebab/<?= htmlspecialchars($kebab['_id'], ENT_QUOTES, 'UTF-8') ?>"
                              method="POST"
                              enctype="multipart/form-data">

                            <!-- CSRF Protection -->
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">

                            <!-- ID du Kebab -->
                            <input type="hidden" name="id" value="<?= htmlspecialchars($kebab['_id'], ENT_QUOTES, 'UTF-8') ?>" />

                            <!-- Nom du kebab -->
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom du kebab</label>
                                <input type="text" class="form-control" id="nom" name="nom"
                                       value="<?= htmlspecialchars($kebab['nom'], ENT_QUOTES, 'UTF-8') ?>"
                                       placeholder="Nom du kebab" >
                            </div>

                            <!-- Prix solo -->
                            <div class="mb-3">
                                <label for="solo" class="form-label">Prix solo</label>
                                <input type="number" class="form-control" id="solo" name="solo"
                                       value="<?= htmlspecialchars($kebab['solo'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                       placeholder="Prix solo">
                            </div>

                            <!-- Prix menu -->
                            <div class="mb-3">
                                <label for="menu" class="form-label">Prix Menu</label>
                                <input type="number" class="form-control" id="menu" name="menu"
                                       value="<?= htmlspecialchars($kebab['menu'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                       placeholder="Prix Menu">
                            </div>

                            <!-- Prix assiette -->
                            <div class="mb-3">
                                <label for="assiette" class="form-label">Prix Assiette</label>
                                <input type="number" class="form-control" id="assiette" name="assiette"
                                       value="<?= htmlspecialchars($kebab['assiette'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                       placeholder="Prix Assiette">
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description"
                                          rows="4"
                                          placeholder="Description du kebab"><?= htmlspecialchars($kebab['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                            </div>

                            <!-- Image actuelle -->
                            <div class="mb-3">
                                <label for="current_image" class="form-label">Image actuelle</label>
                                <div class="mb-3">
                                    <img src="<?= htmlspecialchars($kebab['img'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                         alt="Image actuelle" class="img-fluid">
                                </div>
                            </div>

                            <!-- Nouvelle image -->
                            <div class="mb-3">
                                <label for="img" class="form-label">Nouvelle image (optionnelle)</label>
                                <input type="file" class="form-control" id="img" name="img" accept="image/*">
                                <small class="form-text text-muted">Laissez ce champ vide si vous ne souhaitez pas changer l'image.</small>
                            </div>

                            <!-- Boutons -->
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                                <a href="/DashKebabs/liste" class="btn btn-secondary">Annuler</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>