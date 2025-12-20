<div class="mt-4">
    <a href="index.php?page=home" class="text-decoration-none">← Retour à l'accueil</a>
    <h2 class="my-3">Annonces de la catégorie</h2>
    <p class="text-muted"><?= $totalAnnonces ?> résultat(s) trouvés</p>
</div>

<div class="row">
    <?php if(empty($annonces)): ?>
        <div class="col-12">
            <div class="alert alert-warning">Aucune annonce dans cette catégorie pour le moment.</div>
        </div>
    <?php else: ?>
        <?php foreach($annonces as $annonce): ?>
            <div class="col-12 mb-3">
                <div class="card shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-3">
                             <?php 
                                // Gestion de l'image (compatible ancien et nouveau système)
                                $imgSrc = "https://via.placeholder.com/300x200?text=Pas+de+photo";
                                if (!empty($annonce['photo'])) {
                                    $imgSrc = "assets/uploads/" . htmlspecialchars($annonce['photo']);
                                }
                            ?>
                            <img src="<?= $imgSrc ?>" class="img-fluid rounded-start h-100" style="object-fit: cover; min-height: 150px; width: 100%;" alt="Photo annonce">
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($annonce['title']) ?></h5>
                                <p class="card-text text-truncate"><?= htmlspecialchars($annonce['description']) ?></p>
                                <p class="card-text">
                                    <span class="fw-bold text-primary fs-5"><?= htmlspecialchars($annonce['price']) ?> €</span>
                                    <small class="text-muted ms-3">Le <?= date('d/m/Y', strtotime($annonce['created_at'])) ?></small>
                                </p>
                                <a href="index.php?page=detail&id=<?= $annonce['id'] ?>" class="btn btn-primary">Voir l'annonce</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php if ($totalPages > 1): ?>
<nav class="mt-4">
    <ul class="pagination justify-content-center">
        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
            <a class="page-link" href="index.php?page=category&id=<?= $catId ?>&p=<?= $page - 1 ?>">Précédent</a>
        </li>

        <?php for($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                <a class="page-link" href="index.php?page=category&id=<?= $catId ?>&p=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
            <a class="page-link" href="index.php?page=category&id=<?= $catId ?>&p=<?= $page + 1 ?>">Suivant</a>
        </li>
    </ul>
</nav>
<?php endif; ?>