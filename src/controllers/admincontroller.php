<?php
require_once __DIR__ . '/../models/annonce.php';
require_once __DIR__ . '/../models/user.php';

// Sécurité : Bloque l'accès si on n'est pas admin
function checkAdmin() {
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        header('Location: index.php?page=home');
        exit;
    }
}

// Affiche le tableau de bord Admin
function adminDashboard($pdo) {
    checkAdmin();
    $categories = getAllCategories($pdo);
    $sqlUsers = "SELECT * FROM users WHERE role != 'admin' ORDER BY id DESC";
    $users = $pdo->query($sqlUsers)->fetchAll();

    $sqlAnnonces = "SELECT annonces.*, users.email as seller_email 
                    FROM annonces 
                    LEFT JOIN users ON annonces.user_id = users.id 
                    ORDER BY created_at DESC";
    $annonces = $pdo->query($sqlAnnonces)->fetchAll();

    require_once __DIR__ . '/../views/admin/dashboard.php';
}

// Ajouter une catégorie
function adminAddCategory($pdo) {
    checkAdmin();
    if (!empty($_POST['label'])) {
        $stmt = $pdo->prepare("INSERT INTO categories (label) VALUES (?)");
        $stmt->execute([htmlspecialchars($_POST['label'])]);
    }
    header('Location: index.php?page=admin_dashboard');
}

// Supprimer un utilisateur
function adminDeleteUser($pdo) {
    checkAdmin();
    if (isset($_GET['id'])) {
        
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$_GET['id']]);
    }
    header('Location: index.php?page=admin_dashboard');
}


function adminDeleteAnnonce($pdo) {
    checkAdmin();
    if (isset($_GET['id'])) {
        deleteAnnonce($pdo, $_GET['id']);
    }
    header('Location: index.php?page=admin_dashboard');
}
// Renommer une catégorie
function adminEditCategory($pdo) {
    checkAdmin(); 
    
    if (isset($_POST['id']) && !empty($_POST['label'])) {
        updateCategory($pdo, $_POST['id'], $_POST['label']);
    }

    header('Location: index.php?page=admin_dashboard');
    exit;
}
?>
