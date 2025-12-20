<?php

require_once '../src/models/annonce.php';


function showDetail($pdo) {
    if (!isset($_GET['id'])) { echo "ID manquant"; return; }
    $annonce = getAnnonceById($pdo, $_GET['id']);
    if (!$annonce) { echo "Annonce introuvable"; return; }
    require_once '../src/views/annonces/detail.php';
}


function addAnnonce($pdo) {
    if (!isset($_SESSION['user_id'])) { header('Location: index.php?page=login'); exit; }
    $categories = getAllCategories($pdo);
    require_once '../src/views/annonces/add.php';
}


function handleAddAnnonce($pdo) {
    if (!isset($_SESSION['user_id'])) { die("Accès refusé"); }

    $uploadedFiles = [];
    $errors = [];

    if (isset($_FILES['photos']) && !empty($_FILES['photos']['name'][0])) {
        
        $countFiles = count($_FILES['photos']['name']);
        
      
        if ($countFiles > 5) {
            die("Erreur : Vous ne pouvez envoyer que 5 photos maximum.");
        }

        for ($i = 0; $i < $countFiles; $i++) {
            $tmpName = $_FILES['photos']['tmp_name'][$i];
            $name    = $_FILES['photos']['name'][$i];
            $size    = $_FILES['photos']['size'][$i];
            $error   = $_FILES['photos']['error'][$i];
            $type    = $_FILES['photos']['type'][$i];

            if ($error === 0) {
               
                if ($type !== 'image/jpeg' && $type !== 'image/jpg') {
                    die("Erreur : Le fichier $name n'est pas une image JPEG.");
                }

                if ($size > 204800) {
                    die("Erreur : L'image $name dépasse 200 ko.");
                }

                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $newName = uniqid() . '_' . $i . '.' . $ext;
                
                $uploadedFiles[] = [
                    'tmp_name' => $tmpName,
                    'new_name' => $newName
                ];
            }
        }
    }

    $mainPhotoName = null;
    if (!empty($uploadedFiles)) {
        $mainPhotoName = $uploadedFiles[0]['new_name'];
    }

    $newAnnonceId = createAnnonce(
        $pdo,
        $_SESSION['user_id'],
        $_POST['category_id'],
        $_POST['title'],
        $_POST['description'],
        $_POST['price'],
        $mainPhotoName,
        $_POST['delivery'] 
    );

    if (!$newAnnonceId) {
        die("Erreur lors de l'enregistrement en base de données.");
    }

   
    foreach ($uploadedFiles as $file) {
        $destPath = 'assets/uploads/' . $file['new_name'];
        
        if (move_uploaded_file($file['tmp_name'], $destPath)) {
           
            addPhoto($pdo, $newAnnonceId, $file['new_name']);
        }
    }

    header('Location: index.php?page=home');
    exit;
}
function deleteUserAnnonce($pdo) {
   
    if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
        header('Location: index.php?page=login');
        exit;
    }

    $id = $_GET['id'];
    $userId = $_SESSION['user_id'];

   
    $annonce = getAnnonceById($pdo, $id);

    if ($annonce && $annonce['user_id'] == $userId) {
        
       
        if ($annonce['photo'] && file_exists('assets/uploads/' . $annonce['photo'])) {
            unlink('assets/uploads/' . $annonce['photo']);
        }

        deleteAnnonce($pdo, $id);
    }

  
    header('Location: index.php?page=dashboard');
    exit;
}
// Afficher la page de confirmation d'achat
function buy($pdo) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php?page=login');
        exit;
    }

   
    if (!isset($_GET['id'])) { die("Erreur : ID manquant"); }
    
    $id = $_GET['id'];
    $annonce = getAnnonceById($pdo, $id);

   
    if (!$annonce || $annonce['status'] !== 'active') {
        echo "<div class='alert alert-danger'>Désolé, cet objet n'est plus disponible.</div>";
        return;
    }

   
    if ($annonce['user_id'] == $_SESSION['user_id']) {
        echo "<div class='alert alert-warning'>Vous ne pouvez pas acheter votre propre annonce !</div>";
        return;
    }

    
    require_once '../src/views/annonces/buy.php';
}


function handleBuy($pdo) {
   
    if (!isset($_SESSION['user_id']) || !isset($_POST['annonce_id'])) {
        header('Location: index.php?page=home');
        exit;
    }

    markAnnonceAsSold($pdo, $_POST['annonce_id'], $_SESSION['user_id']);

    header('Location: index.php?page=dashboard');
    exit;
}
?>