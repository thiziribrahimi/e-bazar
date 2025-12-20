<div class="text-center py-5 bg-white mb-4 rounded shadow-sm">
    <h1 class="display-4 fw-bold text-primary">Bienvenue sur e-bazar</h1>
    <p class="lead text-muted">Trouvez la bonne affaire parmi nos catégories</p>
</div>

<h3 class="mb-3 border-bottom pb-2">Parcourir par catégorie</h3>
<div class="row mb-5">
    <?php foreach($categories as $cat): ?>
    <div class="col-md-3 mb-3">
        <div class="card h-100 text-center hover-shadow border-primary">
            <div class="card-body d-flex flex-column justify-content-center">
                <h5 class="card-title text-primary"><?= htmlspecialchars($cat['label']) ?></h5>
                <p class="card-text text-muted"><?= $cat['count_annonces'] ?> annonce(s)</p>
                <a href="index.php?page=category&id=<?= $cat['id'] ?>" class="btn btn-sm btn-outline-primary stretched-link">Voir les biens</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<h3 class="mb-3 border-bottom pb-2">Les dernières nouveautés</h3>
<div class="row">
    <?php if(empty($lastAnnonces)): ?>
        <div class="col-12"><div class="alert alert-info">Aucune annonce récente.</div></div>
    <?php else: ?>
        <?php foreach($lastAnnonces as $annonce): ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <?php 
                        $imgSrc = !empty($annonce['photo']) ? "assets/uploads/" . htmlspecialchars($annonce['photo']) : "https://via.placeholder.com/300x200?text=Pas+de+photo";
                    ?>
                    <img src="<?= $imgSrc ?>" class="card-img-top" alt="Produit" style="height: 180px; object-fit: cover;">
                    
                    <div class="card-body">
                        <span class="badge bg-secondary mb-2"><?= htmlspecialchars($annonce['category_name']) ?></span>
                        <h6 class="card-title text-truncate"><?= htmlspecialchars($annonce['title']) ?></h6>
                        <p class="text-primary fw-bold"><?= htmlspecialchars($annonce['price']) ?> €</p>
                    </div>
                    <div class="card-footer bg-white border-top-0">
                        <a href="index.php?page=detail&id=<?= $annonce['id'] ?>" class="btn btn-sm btn-outline-primary w-100">Voir détails</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>