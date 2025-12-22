<?php


// Fonction pour insérer un nouvel utilisateur
function createUser($pdo, $email, $password) {
    // Par défaut, le rôle est 'user'
    $sql = "INSERT INTO users (email, password, role) VALUES (:email, :password, 'user')";
    $stmt = $pdo->prepare($sql);
    
    // Hachage du mot de passe pour la sécurité
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    return $stmt->execute([
        'email' => $email,
        'password' => $hashedPassword
    ]);
}

// Fonction OBLIGATOIRE pour la connexion (handleLogin)
function getUserByEmail($pdo, $email) {
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    return $stmt->fetch();
}
