<?php
require_once __DIR__ . '/../models/annonce.php';

function displayHome($pdo) {
   
    $annonces = getAllAnnonces($pdo);

    
    require_once __DIR__ . '/../views/home.php';
}

function getAnnoncesJSON($pdo) {
    header('Content-Type: application/json');
    $annonces = getAllAnnonces($pdo);
    echo json_encode($annonces);
}
?>