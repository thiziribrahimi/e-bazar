<div class="row mt-4">
    <div class="col-md-6">
        <div class="card shadow-sm">
            
            <?php 
            $photos = [];
            if (!empty($annonce['all_photos'])) {
                $photos = $annonce['all_photos'];
            } elseif (!empty($annonce['photo'])) {
                $photos[] = $annonce['photo'];
            }
            ?>

            <?php if (empty($photos)): ?>
                <img src="https://via.placeholder.com/800x600?text=Pas+de+photo" 
                     class="img-fluid rounded" 
                     alt="Image par défaut">
            
            <?php elseif (count($photos) === 1): ?>
                <img src="assets/uploads/<?= htmlspecialchars($photos[0]) ?>" 
                     class="img-fluid rounded" 
                     alt="Photo du produit"
                     style="width: 100%; max-height: 500px; object-fit: contain; background: #f8f9fa;">

            <?php else: ?>
                <div id="carouselAnnonce" class="carousel slide" data-bs-ride="carousel">
                    
                    <div class="carousel-indicators">
                        <?php foreach($photos as $index => $photo): ?>
                            <button type="button" data-bs-target="#carouselAnnonce" data-bs-slide-to="<?= $index ?>" 
                                    class="<?= $index === 0 ? 'active' : '' ?>" aria-current="true"></button>
                        <?php endforeach; ?>
                    </div>

                    <div class="carousel-inner rounded">
                        <?php foreach($photos as $index => $photo): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <img src="assets/uploads/<?= htmlspecialchars($photo) ?>" 
                                     class="d-block w-100" 
                                     alt="Photo <?= $index + 1 ?>"
                                     style="height: 500px; object-fit: contain; background: #333;">
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselAnnonce" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Précédent</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselAnnonce" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Suivant</span>
                    </button>
                </div>
            <?php endif; ?>

        </div>
    </div> 

    <div class="col-md-6">
        <span class="badge bg-secondary mb-2"><?= htmlspecialchars($annonce['category_name'] ?? 'Divers') ?></span>
        <h1><?= htmlspecialchars($annonce['title']) ?></h1>
        <h2 class="text-primary fw-bold my-3"><?= htmlspecialchars($annonce['price']) ?> €</h2>
        
        <p class="text-muted">Vendu par : <?= htmlspecialchars($annonce['seller_email'] ?? 'Inconnu') ?></p>
        
        <div class="p-3 bg-light rounded border">
            <h5>Description</h5>
            <p><?= nl2br(htmlspecialchars($annonce['description'])) ?></p>
        </div>
        
        <div class="mt-3">
            <strong>Mode de livraison :</strong> <?= htmlspecialchars($annonce['delivery_mode'] ?? 'Non spécifié') ?>
        </div>

        <div class="mt-4">
            <?php if (isset($_SESSION['user_id'])): ?>
                
                <?php if ($_SESSION['user_id'] == $annonce['user_id']): ?>
                    <div class="alert alert-warning">C'est votre annonce.</div>
                <?php else: ?>
                    <a href="index.php?page=buy&id=<?= $annonce['id'] ?>" class="btn btn-success btn-lg w-100 shadow">
                        Acheter cet article
                    </a>
                <?php endif; ?>

            <?php else: ?>
                <div class="alert alert-info text-center">
                    <a href="index.php?page=login" class="fw-bold">Connectez-vous</a> pour acheter.
                </div>
            <?php endif; ?>
        </div>
        
        <div class="mt-3">
            <a href="index.php?page=home" class="btn btn-outline-secondary">← Retour aux annonces</a>
        </div>
    </div> 
</div>