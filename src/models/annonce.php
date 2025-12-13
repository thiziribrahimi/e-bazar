<?php


// 1. Récupérer toutes les catégories
function getAllCategories($pdo) {
    return $pdo->query("SELECT * FROM categories ORDER BY label")->fetchAll();
}

// 2. Récupérer toutes les annonces ACTIVES 
function getAllAnnonces($pdo) {
    $sql = "SELECT annonces.*, categories.label as category_name 
            FROM annonces 
            LEFT JOIN categories ON annonces.category_id = categories.id 
            WHERE annonces.status = 'active' 
            ORDER BY annonces.created_at DESC";
    
    try {
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        die("ERREUR SQL : " . $e->getMessage());
    }
}

// 3. Récupérer une annonce par ID
function getAnnonceById($pdo, $id) {
    $sql = "SELECT annonces.*, categories.label as category_name, users.email as seller_email 
            FROM annonces 
            LEFT JOIN categories ON annonces.category_id = categories.id 
            LEFT JOIN users ON annonces.user_id = users.id
            WHERE annonces.id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
}

// 4. Créer une annonce
function createAnnonce($pdo, $userId, $categoryId, $title, $description, $price, $imageName, $delivery) {
    $sql = "INSERT INTO annonces (user_id, category_id, title, description, price, photo, delivery_mode, status, created_at) 
            VALUES (:user_id, :category_id, :title, :description, :price, :photo, :delivery, 'active', NOW())";
    
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

// 5. Récupérer les annonces d'un utilisateur
function getAnnoncesByUser($pdo, $userId) {
    $sql = "SELECT annonces.*, categories.label as category_name 
            FROM annonces 
            LEFT JOIN categories ON annonces.category_id = categories.id 
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

// 7. Marquer comme vendue
function markAnnonceAsSold($pdo, $id, $buyerId) {
    $sql = "UPDATE annonces SET status = 'sold', buyer_id = :buyer_id WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        'id' => $id,
        'buyer_id' => $buyerId
    ]);
}

// 8. Mes achats
function getAnnoncesBoughtByUser($pdo, $userId) {
    $sql = "SELECT annonces.*, categories.label as category_name 
            FROM annonces 
            LEFT JOIN categories ON annonces.category_id = categories.id 
            WHERE buyer_id = :user_id 
            ORDER BY created_at DESC";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetchAll();
}
?>