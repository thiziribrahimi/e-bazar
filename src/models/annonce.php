<?php
// src/models/annonce.php

// 1. Récupérer toutes les catégories (pour le formulaire de dépôt)
function getAllCategories($pdo) {
    return $pdo->query("SELECT * FROM categories ORDER BY label")->fetchAll();
}

// 2. Récupérer les annonces actives (pour la page d'accueil)
function getAllAnnonces($pdo) {
    $sql = "SELECT annonces.*, categories.label as category_name 
            FROM annonces 
            JOIN categories ON annonces.category_id = categories.id 
            WHERE status = 'active' 
            ORDER BY created_at DESC";
    try {
        return $pdo->query($sql)->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}

// 3. Récupérer une seule annonce par ID (pour la page détail et achat)
function getAnnonceById($pdo, $id) {
    $sql = "SELECT annonces.*, categories.label as category_name, users.email as seller_email 
            FROM annonces 
            JOIN categories ON annonces.category_id = categories.id 
            JOIN users ON annonces.user_id = users.id
            WHERE annonces.id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
}

// 4. Créer une annonce (Dépôt)
function createAnnonce($pdo, $userId, $categoryId, $title, $description, $price, $imageName, $delivery) {
    $sql = "INSERT INTO annonces (user_id, category_id, title, description, price, photo, delivery_mode, status) 
            VALUES (:user_id, :category_id, :title, :description, :price, :photo, :delivery, 'active')";
    
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        'user_id' => $userId,
        'category_id' => $categoryId,
        'title' => $title,
        'description' => $description,
        'price' => $price,
        'photo' => $imageName,
        'delivery' => $delivery
    ]);
}

// 5. Récupérer les annonces d'un utilisateur (pour le Dashboard - Mes Ventes)
function getAnnoncesByUser($pdo, $userId) {
    $sql = "SELECT annonces.*, categories.label as category_name 
            FROM annonces 
            JOIN categories ON annonces.category_id = categories.id 
            WHERE user_id = :user_id 
            ORDER BY created_at DESC";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetchAll();
}

// 6. Supprimer une annonce
function deleteAnnonce($pdo, $id) {
    $sql = "DELETE FROM annonces WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute(['id' => $id]);
}

// 7. Marquer une annonce comme vendue (Achat)
function markAnnonceAsSold($pdo, $id, $buyerId) {
    $sql = "UPDATE annonces SET status = 'sold', buyer_id = :buyer_id WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        'id' => $id,
        'buyer_id' => $buyerId
    ]);
}
// Récupérer les objets que j'ai achetés
function getAnnoncesBoughtByUser($pdo, $userId) {
    $sql = "SELECT annonces.*, categories.label as category_name 
            FROM annonces 
            JOIN categories ON annonces.category_id = categories.id 
            WHERE buyer_id = :user_id 
            ORDER BY created_at DESC";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetchAll();
}
?>