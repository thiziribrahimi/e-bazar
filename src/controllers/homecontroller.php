<?php
require_once __DIR__ . '/../models/annonce.php';

function displayHome($pdo) {
    // 1. Récupérer les catégories avec le compteur
    $categories = getCategoriesWithCounts($pdo);
    
    // 2. Récupérer les 4 dernières annonces
    $lastAnnonces = getRecentAnnonces($pdo, 4);

    require_once __DIR__ . '/../views/home.php';
}


function displayCategory($pdo) {
    if (!isset($_GET['id'])) { header('Location: index.php?page=home'); exit; }
    
    $catId = (int)$_GET['id'];
    $page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
    if ($page < 1) $page = 1;
    $limit = 10; 
    
    $annonces = getAnnoncesByCategoryPaginated($pdo, $catId, $page, $limit);
    $totalAnnonces = countAnnoncesByCategory($pdo, $catId);
    
    $totalPages = ceil($totalAnnonces / $limit);

    require_once __DIR__ . '/../views/annonces/category.php';
}

function getAnnoncesJSON($pdo) {
    header('Content-Type: application/json');
    $annonces = getAllAnnonces($pdo); 
    echo json_encode($annonces);
}
?>