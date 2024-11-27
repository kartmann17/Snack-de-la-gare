<?php
echo '<link rel="stylesheet" href="/Asset/css/dashburger.css">';
?>

<section class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="text-center">Ajouter un Burger</h2>
                </div>
                <div class="card-body">
                    <form action="/DashBurgers/ajoutBurger" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                        <!-- Nom du burger -->
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom du burger</label>
                            <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom du burger" required>
                        </div>

                        <!-- Prix Solo -->
                        <div class="mb-3">
                            <label for="prix_solo" class="form-label">Prix Solo</label>
                            <input type="text" class="form-control" id="prix_solo" name="solo" placeholder="Prix Solo">
                        </div>

                        <!-- Prix Menu -->
                        <div class="mb-3">
                            <label for="prix_menu" class="form-label">Prix Menu</label>
                            <input type="text" class="form-control" id="prix_menu" name="menu" placeholder="Prix Menu">
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Description du burger" required></textarea>
                        </div>

                        <!-- Image -->
                        <div class="mb-3">
                            <label for="img" class="form-label">Image du burger</label>
                            <input type="file" class="form-control" id="img" name="img" accept="image/*" >
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