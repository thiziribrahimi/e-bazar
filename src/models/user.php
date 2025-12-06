<?php


// Fonction pour insérer un nouvel utilisateur
function createUser($pdo, $email, $password) {
    $sql = "INSERT INTO users (email, password, role) VALUES (:email, :password, 'user')";
    $stmt = $pdo->prepare($sql);
    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    return $stmt->execute([
        'email' => $email,
        'password' => $hashedPassword
    ]);
}

// Fonction pour récupérer un utilisateur par son email (pour le login)
function getUserByEmail($pdo, $email) {
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    return $stmt->fetch();
}
?>