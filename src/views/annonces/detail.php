<div class="row mt-4">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <img src="assets/uploads/default.jpg" class="img-fluid rounded" alt="Photo du produit">
        </div>
    </div>

    <div class="col-md-6">
        <span class="badge bg-secondary mb-2"><?= htmlspecialchars($annonce['category_name']) ?></span>
        <h1><?= htmlspecialchars($annonce['title']) ?></h1>
        <h2 class="text-primary fw-bold my-3"><?= htmlspecialchars($annonce['price']) ?> €</h2>
        
        <p class="text-muted">Vendu par : <?= htmlspecialchars($annonce['seller_email']) ?></p>
        
        <div class="p-3 bg-light rounded border">
            <h5>Description</h5>
            <p><?= nl2br(htmlspecialchars($annonce['description'])) ?></p>
        </div>

        <div class="mt-4">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="index.php?page=buy&id=<?= $annonce['id'] ?>" class="btn btn-success btn-lg w-100">
                    Acheter cet article
                </a>
            <?php else: ?>
                <div class="alert alert-info">
                    <a href="index.php?page=login">Connectez-vous</a> pour contacter le vendeur ou acheter.
                </div>
            <?php endif; ?>
        </div>
        
        <div class="mt-3">
            <a href="index.php?page=home" class="btn btn-outline-secondary">← Retour aux annonces</a>
        </div>
    </div>
</div>