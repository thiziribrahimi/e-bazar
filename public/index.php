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
        require_once '../src/views/home.php';
        break;

    case 'login':
        echo "<h2>Page de connexion (à faire)</h2>";
        break;

    case 'register':
        echo "<h2>Page d'inscription (à faire)</h2>";
        break;

    default:
        echo "<div class='alert alert-danger'>Page 404 : Introuvable</div>";
        break;
}


if (!$isJson) {
    require_once '../src/views/layout/footer.php';
}
?>