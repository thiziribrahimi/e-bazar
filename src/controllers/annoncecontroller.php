<?php

require_once '../src/models/annonce.php';

function showDetail($pdo) {
   
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo "Aucun identifiant d'annonce spécifié.";
        return;
    }

    $id = $_GET['id'];
    $annonce = getAnnonceById($pdo, $id);

    if (!$annonce) {
        echo "Annonce introuvable.";
        return;
    }

    require_once '../src/views/annonces/detail.php';
}
?>