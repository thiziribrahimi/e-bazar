<div class="container mt-4">
    <h2>Mon Espace Personnel</h2>
    <p>Bienvenue <?= htmlspecialchars($_SESSION['user_email']) ?></p>

    <div class="card shadow-sm mb-5 border-success">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0"> Mes Achats</h4>
        </div>
        <div class="card-body">
            <?php if (empty($boughtAnnonces)): ?>
                <p class="text-muted">Vous n'avez encore rien acheté.</p>
            <?php else: ?>
                <table class="table table-hover">
                    <thead><tr><th>Photo</th><th>Titre</th><th>Prix</th><th>Action</th></tr></thead>
                    <tbody>
                        <?php foreach($boughtAnnonces as $annonce): ?>
                        <tr>
                            <td>
                                <?php if($annonce['photo']): ?>
                                    <img src="assets/uploads/<?= htmlspecialchars($annonce['photo']) ?>" style="height: 40px;">
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($annonce['title']) ?></td>
                            <td class="fw-bold"><?= htmlspecialchars($annonce['price']) ?> €</td>
                            <td>
                               <button class="btn btn-sm btn-warning btn-reception" data-id="<?= $annonce['id'] ?>">
                               Confirmer la réception
                               </button>
                           </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <div class="card shadow-sm mb-5 border-primary">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Mes ventes en cours</h4>
            <a href="index.php?page=add" class="btn btn-sm btn-light text-primary fw-bold">+ Déposer</a>
        </div>
        <div class="card-body">
            <?php if (empty($activeAnnonces)): ?>
                <p class="text-muted">Aucune annonce en ligne.</p>
            <?php else: ?>
                <table class="table table-hover">
                    <thead><tr><th>Photo</th><th>Titre</th><th>Prix</th><th>Action</th></tr></thead>
                    <tbody>
                        <?php foreach($activeAnnonces as $annonce): ?>
                        <tr>
                            <td>
                                <?php if($annonce['photo']): ?>
                                    <img src="assets/uploads/<?= htmlspecialchars($annonce['photo']) ?>" style="height: 40px;">
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($annonce['title']) ?></td>
                            <td class="fw-bold"><?= htmlspecialchars($annonce['price']) ?> €</td>
                            <td>
                                <a href="index.php?page=detail&id=<?= $annonce['id'] ?>" class="btn btn-sm btn-info text-white">Voir</a>
                                <a href="index.php?page=delete&id=<?= $annonce['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <div class="card shadow-sm mb-5 bg-light">
        <div class="card-header">
            <h4 class="mb-0 text-secondary">Objets vendus (Historique)</h4>
        </div>
        <div class="card-body">
            <?php if (empty($soldAnnonces)): ?>
                <p class="text-muted">Vous n'avez encore rien vendu.</p>
            <?php else: ?>
                <table class="table table-hover">
                    <thead><tr><th>Photo</th><th>Titre</th><th>Prix Final</th><th>Statut</th></tr></thead>
                    <tbody>
                        <?php foreach($soldAnnonces as $annonce): ?>
                        <tr>
                            <td>
                                <?php if($annonce['photo']): ?>
                                    <img src="assets/uploads/<?= htmlspecialchars($annonce['photo']) ?>" style="height: 40px; opacity: 0.6;">
                                <?php endif; ?>
                            </td>
                            <td class="text-decoration-line-through"><?= htmlspecialchars($annonce['title']) ?></td>
                            <td class="fw-bold text-success">+ <?= htmlspecialchars($annonce['price']) ?> €</td>
                            <td><span class="badge bg-secondary">VENDU</span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>