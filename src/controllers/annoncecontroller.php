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
function deleteUserAnnonce($pdo) {
   
    if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
        header('Location: index.php?page=login');
        exit;
    }

    $id = $_GET['id'];
    $userId = $_SESSION['user_id'];

   
    $annonce = getAnnonceById($pdo, $id);

    if ($annonce && $annonce['user_id'] == $userId) {
        
       
        if ($annonce['photo'] && file_exists('assets/uploads/' . $annonce['photo'])) {
            unlink('assets/uploads/' . $annonce['photo']);
        }

        deleteAnnonce($pdo, $id);
    }

  
    header('Location: index.php?page=dashboard');
    exit;
}
// Afficher la page de confirmation d'achat
function buy($pdo) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php?page=login');
        exit;
    }

   
    if (!isset($_GET['id'])) { die("Erreur : ID manquant"); }
    
    $id = $_GET['id'];
    $annonce = getAnnonceById($pdo, $id);

   
    if (!$annonce || $annonce['status'] !== 'active') {
        echo "<div class='alert alert-danger'>Désolé, cet objet n'est plus disponible.</div>";
        return;
    }

   
    if ($annonce['user_id'] == $_SESSION['user_id']) {
        echo "<div class='alert alert-warning'>Vous ne pouvez pas acheter votre propre annonce !</div>";
        return;
    }

    
    require_once '../src/views/annonces/buy.php';
}


function handleBuy($pdo) {
   
    if (!isset($_SESSION['user_id']) || !isset($_POST['annonce_id'])) {
        header('Location: index.php?page=home');
        exit;
    }

    markAnnonceAsSold($pdo, $_POST['annonce_id'], $_SESSION['user_id']);

    header('Location: index.php?page=dashboard');
    exit;
}
?>