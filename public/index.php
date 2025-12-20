<?php

session_start();

require_once '../config/db.php';

$page = $_GET['page'] ?? 'home';

// Liste des pages qui ne nécessitent pas le header/footer (AJAX ou actions pures)
$apiRoutes = [
    'api_annonces',         
    'api_confirm_receipt',  
    'handle_login',         
    'handle_register',      
    'handle_add',          
    'handle_buy'            
];

// On affiche le layout (header + footer) uniquement si ce n'est pas une route API
$showLayout = !in_array($page, $apiRoutes);

if ($showLayout) {
    require_once '../src/views/layout/header.php';
}

switch ($page) {

    case 'home':
        require_once '../src/controllers/homecontroller.php';
        displayHome($pdo); 
        break;
// --- ROUTES ADMINISTRATEUR ---
    case 'admin_dashboard':
        require_once '../src/controllers/admincontroller.php';
        adminDashboard($pdo);
        break;

    case 'admin_add_category':
        require_once '../src/controllers/admincontroller.php';
        adminAddCategory($pdo);
        break;

    case 'admin_delete_user':
        require_once '../src/controllers/admincontroller.php';
        adminDeleteUser($pdo);
        break;

    case 'admin_delete_annonce':
        require_once '../src/controllers/admincontroller.php';
        adminDeleteAnnonce($pdo);
        break;
    // --- NOUVEAU CASE AJOUTÉ ICI ---
    case 'category':
        require_once '../src/controllers/homecontroller.php';
        displayCategory($pdo);
        break;
    // -------------------------------

    case 'api_annonces': 
        require_once '../src/controllers/homecontroller.php';
        getAnnoncesJSON($pdo);
        break;

    case 'login':
        require_once '../src/controllers/usercontroller.php';
        login();
        break;

    case 'register':
        require_once '../src/controllers/usercontroller.php';
        register();
        break;

    case 'logout':
        require_once '../src/controllers/usercontroller.php';
        logout();
        break;

    case 'dashboard':
        require_once '../src/controllers/usercontroller.php';
        dashboard($pdo);
        break;

    case 'handle_login': 
        require_once '../src/controllers/usercontroller.php';
        handleLogin($pdo);
        break;

    case 'handle_register': 
        require_once '../src/controllers/usercontroller.php';
        handleRegister($pdo);
        break;

    case 'detail':
        require_once '../src/controllers/annoncecontroller.php';
        showDetail($pdo);
        break;

    case 'add':
        require_once '../src/controllers/annoncecontroller.php';
        addAnnonce($pdo);
        break;

    case 'buy':
        require_once '../src/controllers/annoncecontroller.php';
        buy($pdo);
        break;

    case 'delete':
        require_once '../src/controllers/annoncecontroller.php';
        deleteUserAnnonce($pdo);
        break;

    case 'handle_add':
        require_once '../src/controllers/annoncecontroller.php';
        handleAddAnnonce($pdo);
        break;

    case 'handle_buy':
        require_once '../src/controllers/annoncecontroller.php';
        handleBuy($pdo);
        break;
    
    case 'api_confirm_receipt':
        require_once '../src/controllers/annoncecontroller.php';
        confirmReceiptAJAX($pdo);
        break;

    default:
        echo "<div class='container mt-5'><div class='alert alert-danger'>Page 404 : Introuvable</div></div>";
        break;
}

if ($showLayout) {
    require_once '../src/views/layout/footer.php';
}

?>