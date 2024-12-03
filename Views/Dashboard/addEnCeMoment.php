<?php
echo '<link rel="stylesheet" href="/Asset/css/dashburger.css">';
?>

<section class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="text-center">Ajoute en ce moment accueil</h2>
                </div>
                <div class="card-body">
                    <form action="/DashEnCeMoment/ajoutEnCeMoment" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <label for="img">Télécharger une image :</label>
                        <input type="file" name="img" id="img" required>
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