<?php
echo '<link rel="stylesheet" href="/Asset/css/dashburger.css">';
?>

<section class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="text-center">Ajouter un Snack</h2>
                </div>
                <div class="card-body">
                    <form action="/DashSnack/ajoutSnack" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                        <!-- Nom du burger -->
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom du snack</label>
                            <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom du snack" required>
                        </div>

                        <!-- Prix Solo -->
                        <div class="mb-3">
                            <label for="prix_solo" class="form-label">Prix </label>
                            <input type="text" class="form-control" id="prix" name="prix" placeholder="Prix ">
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Description de la salade" required></textarea>
                        </div>

                        <!-- Boutons -->
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                            <a href="/Dashboard" class="btn btn-secondary">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>