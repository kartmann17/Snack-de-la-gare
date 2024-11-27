<?php
echo '<link rel="stylesheet" href="/Asset/css/dashburger.css">';
?>
<section class="container">
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h2 class="text-center">Ajout Horaire</h2>
                    </div>
                    <div class="card-body">

                        <form action="/DashHoraire/addHoraire" method="POST">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                            <!-- Jour -->
                            <div class="mb-3">
                                <label for="jour" class="form-label">Jour</label>
                                <input type="text" class="form-control" id="jour" name="jour" placeholder="Ex : Lundi" required>
                            </div>

                            <!-- Heure de début -->
                            <div class="mb-3">
                                <label for="horaire_debut" class="form-label">Horaire ouverture matin</label>
                                <input type="text" class="form-control" id="horaire_debut" name="ouverture_M" required>
                            </div>

                            <!-- Heure Après midi  -->
                            <div class="mb-3">
                                <label for="horaire_fin" class="form-label">Horaire ouverture après-midi</label>
                                <input type="text" class="form-control" id="horaire_fin" name="ouverture_S">
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">Ajouter</button>
                                <a href="/Dashboard" class="btn btn-secondary">Annuler</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>