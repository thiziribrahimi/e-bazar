<div class="row justify-content-center mt-4">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3>Déposer une annonce</h3>
            </div>
            <div class="card-body">
                <form action="index.php?page=handle_add" method="POST" enctype="multipart/form-data">
                    
                    <div class="mb-3">
                        <label>Catégorie</label>
                        <select name="category_id" class="form-select" required>
                            <?php foreach($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['label']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Titre (Max 30 carac.)</label>
                        <input type="text" name="title" class="form-control" maxlength="30" required>
                    </div>

                    <div class="mb-3">
                        <label>Description (Max 200 carac.)</label>
                        <textarea name="description" class="form-control" maxlength="200" rows="4" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Prix (€)</label>
                        <input type="number" name="price" class="form-control" step="0.01" required>
                    </div>
                    
                    <div class="mb-3">
                        <label>Mode de livraison</label>
                        <select name="delivery" class="form-select" required>
                            <option value="Main propre">Remise en main propre</option>
                            <option value="Envoi postal">Envoi postal</option>
                            <option value="Les deux">Les deux</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Photo</label>
                        <input type="file" name="photo" class="form-control" accept="image/jpeg, image/png">
                    </div>

                    <button type="submit" class="btn btn-success w-100">Publier</button>
                </form>
            </div>
        </div>
    </div>
</div>