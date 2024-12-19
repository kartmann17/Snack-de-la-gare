<?php
$css = 'dashburger';
?>

<section class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="text-center">Ajouter un Soft</h2>
                </div>
                <div class="card-body">
                    <form action="/DashSofts/ajoutSoft" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                        <!-- Nom du soft -->
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom du Soft</label>
                            <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom du Soft" required>
                        </div>

                        <!-- Prix  -->
                        <div class="mb-3">
                            <label for="prix_solo" class="form-label">Prix </label>
                            <input type="text" class="form-control" id="prix" name="prix" placeholder="Prix ">
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