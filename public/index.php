<?php

session_start();


require_once '../config/db.php';


$page = $_GET['page'] ?? 'home';


// Note : On ne l'affiche pas si on demande du JSON (pour l'AJAX plus tard)
$isJson = isset($_GET['format']) && $_GET['format'] === 'json';

if (!$isJson) {
    require_once '../src/views/layout/header.php';
}


switch ($page) {

    case 'home':
        require_once '../src/controllers/homecontroller.php';
        displayHome($pdo);
        break;

    // --- GESTION UTILISATEURS ---
    case 'login':
        require_once '../src/controllers/usercontroller.php';
        login();
        break;
        
    case 'handle_login': 
        require_once '../src/controllers/usercontroller.php';
        handleLogin($pdo);
        break;

    case 'register':
        require_once '../src/controllers/usercontroller.php';
        register();
        break;
        
    case 'handle_register': 
        require_once '../src/controllers/usercontroller.php';
        handleRegister($pdo);
        break;
        
    case 'logout':
        require_once '../src/controllers/usercontroller.php';
        logout();
        break;

    default:
        echo "<div class='alert alert-danger'>Page 404 : Introuvable</div>";
        break;
}


if (!$isJson) {
    require_once '../src/views/layout/footer.php';
}
?>