<?php

function getAllAnnonces($pdo) {

    $sql = "SELECT annonces.*, categories.label as category_name 
            FROM annonces 
            JOIN categories ON annonces.category_id = categories.id 
            WHERE status = 'active' 
            ORDER BY created_at DESC";
    
    try {
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}

// Récupérer une seule annonce par son ID
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
?>