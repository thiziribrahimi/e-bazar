# Projet e-bazar

Une plateforme de petites annonces en ligne réalisée en PHP natif avec une architecture MVC.

---

##  1. Installation Initiale

Si le projet n'est pas encore installé sur le serveur, suivez ces étapes :

### A. Base de données
1. Accédez à PhpMyAdmin sur la VM (ex: `http://192.168.76.76/phpmyadmin`).
2. Sélectionnez la base de données **`projet`** dans la colonne de gauche (base par défaut de la VM).
3. Importez le fichier **`database.sql`** situé à la racine du projet.
   * *Cela créera les tables nécessaires et le compte administrateur.*

### B. Configuration de la connexion (db.php)
Le fichier de configuration est ignoré par Git. Vous devez le créer ou le modifier directement sur le serveur.

1. Créez ou éditez le fichier : `config/db.php`
2. Insérez le code suivant (adapté à la VM) :

```php
<?php
// Configuration de la connexion à la base de données
$host = 'localhost';
$dbname = 'projet';   // Nom imposé par la VM
$username = 'projet'; // Utilisateur par défaut de la VM
$password = 'tejorp'; // Mot de passe par défaut de la VM

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
---
##  2. Procédure de Mise à Jour (Déploiement)

Voici la procédure pour mettre à jour le site sur la VM après avoir fait un `git push` :

**1. Connexion au serveur (SSH)**
```bash
ssh urouen@192.168.76.76
# Mot de passe : madrillet

2. Passage en mode Super-Utilisateur (Root)

Bash

su
# Mot de passe : rotomagus
3. Mise à jour du code

Bash

cd /var/www/html
git pull
Note : Si vous avez une erreur de permission "safe directory", lancez la commande suivante avant de refaire le pull : git config --global --add safe.directory /var/www/html

 3. Identifiants par défaut
Une fois la base de données importée, un compte administrateur est disponible :

Email : admin@bazar.com

Mot de passe : admin123
