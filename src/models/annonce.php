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
    $annonce = $stmt->fetch();

    if ($annonce) {
      
        $sqlPhotos = "SELECT filename FROM photos WHERE annonce_id = :id";
        $stmtPhotos = $pdo->prepare($sqlPhotos);
        $stmtPhotos->execute(['id' => $id]);
        
        
        $annonce['all_photos'] = $stmtPhotos->fetchAll(PDO::FETCH_COLUMN); 
    }

    return $annonce;
}

// 4. Créer une annonce
function createAnnonce($pdo, $userId, $categoryId, $title, $description, $price, $imageName, $delivery) {
   
    $sql = "INSERT INTO annonces (user_id, category_id, title, description, price, photo, delivery_mode, status, created_at) 
            VALUES (:user_id, :category_id, :title, :description, :price, :photo, :delivery, 'active', NOW())"; 
    $stmt = $pdo->prepare($sql);
    $res = $stmt->execute([
        'user_id' => $userId,
        'category_id' => $categoryId,
        'title' => $title,
        'description' => $description,
        'price' => $price,
        'photo' => $imageName, 
        'delivery' => $delivery
    ]);

    
    if ($res) {
        return $pdo->lastInsertId();
    }
    return false;
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
// Fonction pour ajouter une photo liée à une annonce
function addPhoto($pdo, $annonceId, $filename) {
    $sql = "INSERT INTO photos (annonce_id, filename) VALUES (:annonce_id, :filename)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        'annonce_id' => $annonceId,
        'filename' => $filename
    ]);
}

// 9. Récupérer les catégories avec le nombre d'annonces actives
function getCategoriesWithCounts($pdo) {
    $sql = "SELECT c.*, COUNT(a.id) as count_annonces 
            FROM categories c 
            LEFT JOIN annonces a ON c.id = a.category_id AND a.status = 'active'
            GROUP BY c.id 
            ORDER BY c.label";
    return $pdo->query($sql)->fetchAll();
}

// 10. Récupérer les N dernières annonces (pour l'accueil)
function getRecentAnnonces($pdo, $limit = 4) {
    $sql = "SELECT annonces.*, categories.label as category_name 
            FROM annonces 
            LEFT JOIN categories ON annonces.category_id = categories.id 
            WHERE annonces.status = 'active' 
            ORDER BY annonces.created_at DESC 
            LIMIT :limit";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

// 11. Récupérer les annonces d'une catégorie avec PAGINATION
function getAnnoncesByCategoryPaginated($pdo, $categoryId, $page, $limit) {
    $offset = ($page - 1) * $limit;
    
    $sql = "SELECT annonces.*, categories.label as category_name 
            FROM annonces 
            LEFT JOIN categories ON annonces.category_id = categories.id 
            WHERE annonces.status = 'active' AND category_id = :cat_id
            ORDER BY annonces.created_at DESC 
            LIMIT :limit OFFSET :offset";
            
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':cat_id', $categoryId, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

// 12. Compter le total d'annonces dans une catégorie (pour calculer le nombre de pages)
function countAnnoncesByCategory($pdo, $categoryId) {
    $sql = "SELECT COUNT(*) FROM annonces WHERE status = 'active' AND category_id = :cat_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['cat_id' => $categoryId]);
    return $stmt->fetchColumn();
}
// 13. Mettre à jour une catégorie (Admin)
function updateCategory($pdo, $id, $label) {
    $sql = "UPDATE categories SET label = :label WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        'label' => $label,
        'id' => $id
    ]);
}
?>
