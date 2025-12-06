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
?>