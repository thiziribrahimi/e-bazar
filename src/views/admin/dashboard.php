<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-danger">Interface Administrateur</h1>
        <a href="index.php" class="btn btn-outline-secondary">
            Retour au site
        </a>
    </div>

    <ul class="nav nav-tabs" id="adminTab" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#categories">Catégories</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#users">Utilisateurs</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#annonces">Annonces</button>
        </li>
    </ul>

    <div class="tab-content border border-top-0 p-4 bg-white shadow-sm" id="myTabContent">
        
        <div class="tab-pane fade show active" id="categories">
            <div class="row">
                <div class="col-md-6">
                    <h4>Ajouter une catégorie</h4>
                    <form action="index.php?page=admin_add_category" method="POST" class="d-flex gap-2">
                        <input type="text" name="label" class="form-control" placeholder="Nom de la catégorie" required>
                        <button type="submit" class="btn btn-success">Ajouter</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <h4>Liste des catégories</h4>
<ul class="list-group">
    <?php foreach($categories as $cat): ?>
        <li class="list-group-item">
            <form action="index.php?page=admin_edit_category" method="POST" class="d-flex justify-content-between align-items-center gap-2">
                <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                
                <input type="text" name="label" class="form-control form-control-sm" 
                       value="<?= htmlspecialchars($cat['label']) ?>" required>
                
                <button type="submit" class="btn btn-sm btn-primary">Renommer</button>
            </form>
        </li>
    <?php endforeach; ?>
</ul>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="users">
            <table class="table table-striped">
                <thead><tr><th>ID</th><th>Email</th><th>Rôle</th><th>Action</th></tr></thead>
                <tbody>
                    <?php foreach($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><span class="badge bg-info"><?= $user['role'] ?></span></td>
                        <td>
                            <a href="index.php?page=admin_delete_user&id=<?= $user['id'] ?>" 
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Êtes-vous sûr ? Cela supprimera aussi ses annonces.')">
                               Bannir / Supprimer
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade" id="annonces">
            <table class="table table-sm">
                <thead><tr><th>Photo</th><th>Titre</th><th>Vendeur</th><th>Prix</th><th>Action</th></tr></thead>
                <tbody>
                    <?php foreach($annonces as $annonce): ?>
                    <tr>
                        <td>
                             <?php 
                                $img = !empty($annonce['photo']) ? $annonce['photo'] : ''; 
                                if($img): ?>
                                <img src="assets/uploads/<?= htmlspecialchars($img) ?>" style="height: 30px;">
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="index.php?page=detail&id=<?= $annonce['id'] ?>" target="_blank">
                                <?= htmlspecialchars($annonce['title']) ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($annonce['seller_email'] ?? '?') ?></td>
                        <td><?= htmlspecialchars($annonce['price']) ?> €</td>
                        <td>
                            <a href="index.php?page=admin_delete_annonce&id=<?= $annonce['id'] ?>" 
                               class="btn btn-sm btn-warning"
                               onclick="return confirm('Supprimer cette annonce ?')">
                               Supprimer
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
