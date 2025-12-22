<?php

require_once '../src/models/user.php';
require_once '../src/models/annonce.php'; 


function login() {
    require_once '../src/views/auth/login.php';
}


function register() {
    require_once '../src/views/auth/register.php';
}

function logout() {
    session_destroy();
    header('Location: index.php?page=home');
    exit;
}

function dashboard($pdo) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php?page=login');
        exit;
    }

    $userId = $_SESSION['user_id'];

    $myAnnonces = getAnnoncesByUser($pdo, $userId);
    
    $activeAnnonces = [];
    $soldAnnonces = [];

    foreach ($myAnnonces as $annonce) {
        if ($annonce['status'] === 'active') {
            $activeAnnonces[] = $annonce;
        } else {
            $soldAnnonces[] = $annonce; 
        }
    }
   
    $boughtAnnonces = [];
    if (function_exists('getAnnoncesBoughtByUser')) {
        $boughtAnnonces = getAnnoncesBoughtByUser($pdo, $userId);
    }

    require_once '../src/views/auth/dashboard.php';
}


function handleRegister($pdo) {
    header('Content-Type: application/json');

    if (empty($_POST['email']) || empty($_POST['password'])) {
        echo json_encode(['status' => 'error', 'message' => 'Tous les champs sont obligatoires']);
        exit;
    }
  
    $existingUser = getUserByEmail($pdo, $_POST['email']);
    if ($existingUser) {
        echo json_encode(['status' => 'error', 'message' => 'Cet email est déjà utilisé']);
        exit;
    }
    $passwordRaw = $_POST['password']; 
    
    $res = createUser($pdo, $_POST['email'], $passwordRaw);

    if ($res) {
        echo json_encode(['status' => 'success', 'redirect' => 'index.php?page=login']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'inscription']);
    }
    exit;
}

function handleLogin($pdo) {
    header('Content-Type: application/json');
    if (empty($_POST['email']) || empty($_POST['password'])) {
        echo json_encode(['status' => 'error', 'message' => 'Veuillez remplir tous les champs.']);
        exit;
    }

    $email = $_POST['email'];
    $pass = $_POST['password'];
    
    $user = getUserByEmail($pdo, $email);
    if ($user && password_verify($pass, $user['password'])) {
      
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role']; 
    
        $redirectUrl = 'index.php?page=dashboard';

        if ($user['role'] === 'admin') {
            $redirectUrl = 'index.php?page=admin_dashboard';
        } 
       
        elseif (isset($_SESSION['redirect_url'])) {
            $redirectUrl = $_SESSION['redirect_url']; 
            unset($_SESSION['redirect_url']);
        }

        echo json_encode(['status' => 'success', 'redirect' => $redirectUrl]);
        

    } else {
        echo json_encode(['status' => 'error', 'message' => 'Email ou mot de passe incorrect']);
    }
    exit;
}
?>