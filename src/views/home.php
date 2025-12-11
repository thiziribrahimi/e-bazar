<div class="text-center py-4">
    <h1>Bienvenue sur e-bazar</h1>
    <p class="lead">Les dernières bonnes affaires</p>
</div>

<div class="row">
    <?php if(empty($annonces)): ?>
        <div class="col-12">
            <div class="alert alert-info">Aucune annonce disponible pour le moment.</div>
        </div>
    <?php else: ?>
        <?php foreach($annonces as $annonce): ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <?php if (!empty($annonce['photo'])): ?>
                        <img src="assets/uploads/<?= htmlspecialchars($annonce['photo']) ?>" 
                             class="card-img-top" alt="Produit" 
                             style="height: 200px; object-fit: cover;">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/300x200?text=Pas+de+photo" 
                             class="card-img-top" alt="Pas d'image">
                    <?php endif; ?>
                    
                    <div class="card-body">
                        <span class="badge bg-secondary mb-2"><?= htmlspecialchars($annonce['category_name']) ?></span>
                        <h5 class="card-title"><?= htmlspecialchars($annonce['title']) ?></h5>
                        <p class="card-text text-primary fw-bold"><?= htmlspecialchars($annonce['price']) ?> €</p>
                        <p class="card-text text-truncate"><?= htmlspecialchars($annonce['description']) ?></p>
                    </div>
                    <div class="card-footer bg-white border-top-0">
                        <a href="index.php?page=detail&id=<?= $annonce['id'] ?>" class="btn btn-outline-primary w-100">Voir détails</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>