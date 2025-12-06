<?php

require_once '../src/models/user.php';


function register() {
    require_once '../src/views/auth/register.php';
}


function handleRegister($pdo) {
    $email = $_POST['email'];
    $password = $_POST['password'];

 
    if (empty($email) || empty($password)) {
        echo "Veuillez remplir tous les champs.";
        return;
    }


    try {
        createUser($pdo, $email, $password);
        // Redirection vers le login après succès
        header('Location: index.php?page=login');
        exit;
    } catch (Exception $e) {
        echo "Erreur (Email déjà pris ?) : " . $e->getMessage();
    }
}


function login() {
    require_once '../src/views/auth/login.php';
}


function handleLogin($pdo) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $user = getUserByEmail($pdo, $email);

   
    if ($user && password_verify($password, $user['password'])) {
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_email'] = $user['email'];
        
        header('Location: index.php?page=home');
        exit;
    } else {
        echo "<div class='alert alert-danger'>Email ou mot de passe incorrect.</div>";
        login();
    }
}


function logout() {
    session_destroy();
    header('Location: index.php?page=home');
    exit;
}
?>