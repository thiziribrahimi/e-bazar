<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-bazar - Petites annonces</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        
        body { background-color: #f8f9fa; }
        
        
        .navbar { background-color: #ffffff; border-bottom: 1px solid #e9ecef; }
        
      
        .brand-logo { color: #0d6efd; font-weight: 800; letter-spacing: -0.5px; }
       
        .card { border: none; transition: transform 0.2s, box-shadow 0.2s; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center brand-logo" href="index.php?page=home">
                <span class="fs-4 me-2"></span> e-bazar
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    
                    <li class="nav-item">
                        <a class="nav-link text-secondary fw-bold mx-2" href="index.php?page=home">Accueil</a>
                    </li>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link text-dark fw-bold mx-2" href="index.php?page=dashboard">
                                Mon Compte
                            </a>
                        </li>

                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-primary fw-bold px-4 rounded-pill shadow-sm" href="index.php?page=add">
                                + Vendre un objet
                            </a>
                        </li>

                        <li class="nav-item ms-lg-3">
                            <a class="btn btn-outline-danger btn-sm rounded-pill" href="index.php?page=logout">Déconnexion</a>
                        </li>

                    <?php else: ?>
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-outline-primary px-3 rounded-pill" href="index.php?page=login">Se connecter</a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-primary px-3 rounded-pill" href="index.php?page=register">S'inscrire</a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </nav>

    <div class="container flex-grow-1 mt-4">