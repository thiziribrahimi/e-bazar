<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-bazar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php?page=home">e-bazar</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
    <li class="nav-item"><a class="nav-link" href="index.php?page=home">Accueil</a></li>
    
    <?php if (isset($_SESSION['user_id'])): ?>
        <li class="nav-item">
            <span class="nav-link text-warning">Bonjour <?= htmlspecialchars($_SESSION['user_email']) ?></span>
        </li>
        <li class="nav-item"><a class="nav-link" href="index.php?page=logout">Déconnexion</a></li>
    <?php else: ?>
        <li class="nav-item"><a class="nav-link" href="index.php?page=login">Connexion</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php?page=register">Inscription</a></li>
    <?php endif; ?>
</ul>
            </div>
        </div>
    </nav>
    <div class="container">