<div class="container mt-4">
    <h2>Mon Espace Personnel</h2>
    <p>Bienvenue <?= htmlspecialchars($_SESSION['user_email']) ?></p>

    <div class="row mt-4">
        <div class="col-12 mb-5">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Mes ventes en cours</h4>
                    <a href="index.php?page=add" class="btn btn-sm btn-light text-primary">+ Déposer une annonce</a>
                </div>
                <div class="card-body">
                    <?php if (empty($activeAnnonces)): ?>
                        <p class="text-muted">Vous n'avez aucune annonce en cours.</p>
                    <?php else: ?>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>Titre</th>
                                    <th>Prix</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($activeAnnonces as $annonce): ?>
                                <tr>
                                    <td>
                                        <?php if($annonce['photo']): ?>
                                            <img src="assets/uploads/<?= htmlspecialchars($annonce['photo']) ?>" alt="Img" style="height: 50px; width: 50px; object-fit: cover;">
                                        <?php else: ?>
                                            <span class="text-muted">Aucune</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($annonce['title']) ?></td>
                                    <td class="fw-bold"><?= htmlspecialchars($annonce['price']) ?> €</td>
                                    <td><?= date('d/m/Y', strtotime($annonce['created_at'])) ?></td>
                                    <td>
                                        <a href="index.php?page=detail&id=<?= $annonce['id'] ?>" class="btn btn-sm btn-info text-white">Voir</a>
                                        <a href="index.php?page=delete&id=<?= $annonce['id'] ?>" 
   class="btn btn-sm btn-danger"
   onclick="return confirm('Êtes-vous sûre de vouloir supprimer cette annonce ?');">
   Supprimer
</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-12">
            <h4 class="text-success">Historique de mes ventes</h4>
            <div class="alert alert-secondary">
                Les objets que vous aurez vendus apparaîtront ici.
            </div>
        </div>
    </div>
</div>