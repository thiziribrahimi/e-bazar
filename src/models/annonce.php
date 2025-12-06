<?php


function getAllCategories($pdo) {
    return $pdo->query("SELECT * FROM categories ORDER BY label")->fetchAll();
}


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
// Récupérer les annonces d'un utilisateur spécifique
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
// Supprimer une annonce
function deleteAnnonce($pdo, $id) {
    $sql = "DELETE FROM annonces WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute(['id' => $id]);
}
?>