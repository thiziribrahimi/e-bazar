<?php
// src/controllers/homecontroller.php

// On inclut le modèle pour pouvoir parler à la base de données
require_once '../src/models/annonce.php';

function displayHome($pdo) {
    // 1. On récupère la liste des annonces
    $annonces = getAllAnnonces($pdo);

    // 2. On affiche la page (la Vue)
    require_once '../src/views/home.php';
}
?>