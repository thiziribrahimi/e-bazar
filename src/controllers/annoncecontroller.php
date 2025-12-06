<?php

require_once '../src/models/annonce.php';


function showDetail($pdo) {
    if (!isset($_GET['id'])) { echo "ID manquant"; return; }
    $annonce = getAnnonceById($pdo, $_GET['id']);
    if (!$annonce) { echo "Annonce introuvable"; return; }
    require_once '../src/views/annonces/detail.php';
}


function addAnnonce($pdo) {
    if (!isset($_SESSION['user_id'])) { header('Location: index.php?page=login'); exit; }
    $categories = getAllCategories($pdo);
    require_once '../src/views/annonces/add.php';
}


function handleAddAnnonce($pdo) {
    if (!isset($_SESSION['user_id'])) { die("Accès refusé"); }

    
    $imageName = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $imageName = uniqid() . '.' . $ext;
        
        move_uploaded_file($_FILES['photo']['tmp_name'], 'assets/uploads/' . $imageName);
    }

    createAnnonce(
        $pdo,
        $_SESSION['user_id'],
        $_POST['category_id'],
        $_POST['title'],
        $_POST['description'],
        $_POST['price'],
        $imageName,
        $_POST['delivery'] 
    );

    header('Location: index.php?page=home');
    exit;
}
?>