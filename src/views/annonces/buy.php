<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card shadow border-success">
            <div class="card-header bg-success text-white">
                <h4> Confirmation d'achat</h4>
            </div>
            <div class="card-body">
                <h5 class="card-title">Vous êtes sur le point d'acheter :</h5>
                <h3 class="text-primary"><?= htmlspecialchars($annonce['title']) ?></h3>
                
                <div class="alert alert-light border text-center my-3">
                    Prix à payer : <span class="fw-bold fs-4"><?= htmlspecialchars($annonce['price']) ?> €</span>
                </div>

                <form action="index.php?page=handle_buy" method="POST">
                    <input type="hidden" name="annonce_id" value="<?= $annonce['id'] ?>">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Choisissez le mode de livraison :</label>
                        <select name="delivery_choice" class="form-select" required>
                            <option value="">-- Choisir --</option>
                            <option value="<?= htmlspecialchars($annonce['delivery_mode']) ?>">
                                <?= htmlspecialchars($annonce['delivery_mode']) ?> (Proposé par le vendeur)
                            </option>
                            <option value="Autre">Autre arrangement</option>
                        </select>
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" required id="confirm">
                        <label class="form-check-label text-muted" for="confirm">
                            Je m'engage à régler la somme au vendeur.
                        </label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg">Valider l'achat</button>
                        <a href="index.php?page=detail&id=<?= $annonce['id'] ?>" class="btn btn-outline-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>