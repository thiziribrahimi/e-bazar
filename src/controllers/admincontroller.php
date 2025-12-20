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

    // 1. Récupérer toutes les catégories
    $categories = getAllCategories($pdo);
    
    // 2. Récupérer tous les utilisateurs (sauf l'admin lui-même)
    // On suppose que l'admin a l'ID 1 ou un rôle 'admin'
    $sqlUsers = "SELECT * FROM users WHERE role != 'admin' ORDER BY id DESC";
    $users = $pdo->query($sqlUsers)->fetchAll();

    // 3. Récupérer toutes les annonces
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
?>