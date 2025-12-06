<?php

require_once '../src/models/annonce.php';

function displayHome($pdo) {
   
    $annonces = getAllAnnonces($pdo);
    require_once '../src/views/home.php';
}
?>