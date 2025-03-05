<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
</head>
<body>
<?php
// Activer l'affichage des erreurs PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Informations de connexion à la base de données
$host = "localhost";
$dbname = "gwwyymuy_stagehunt";
$username = "gwwyymuy_admin";
$password = "K54sU5Ql8pGJwCGzPhXj";

// Connexion à la base de données avec MySQLi
$conn = new mysqli($host, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
} else {
    echo "Connexion à la base de données réussie !<br>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérification du rôle
    echo $_POST['role'];
    if (!isset($_POST['role']) || !in_array($_POST['role'], ['eleve', 'professeur', 'entreprise'])) {
        echo "Rôle non valide.";
        exit;
    }

    // Récupérer le rôle
    $role = $_POST['role'];

    // Variables communes (nom, prénom, email, tel, password)
    $nom = htmlspecialchars(trim($_POST['nom']));
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = (trim($_POST['password'])); // Hash du mot de passe
    $admin = false;

    // Initialiser la requête SQL et les paramètres
    $sql = '';
    $stmt = null;

    if ($role === 'eleve') {
        // Récupérer les données spécifiques aux élèves
        $classe = htmlspecialchars(trim($_POST['classe']));
        // Les champs de la table "eleve"
        $sql = "INSERT INTO ELEVE (NOMUTILISATEUR, PRENOMUTILISATEUR, MAILUTILISATEUR, CLASSEELEVE, MDPUTILISATEUR, ISADMINUTILISATEUR) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $nom, $prenom, $email, $classe, $password, $admin);

    } elseif ($role === 'professeur') {
        // Récupérer les données spécifiques aux professeurs
        $classe = htmlspecialchars(trim($_POST['classe']));
        $descprof = "à remplir";
        // Les champs de la table "professeur"
        $sql = "INSERT INTO PROFESSEUR (DESCPROF, NOMUTILISATEUR, PRENOMUTILISATEUR, MAILUTILISATEUR, CLASSEPROF, MDPUTILISATEUR, ISADMINUTILISATEUR) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $descprof, $nom, $prenom, $email, $classe, $password, $admin);

    } elseif ($role === 'entreprise') {
        // Récupérer les données spécifiques aux entreprises
        $orga = htmlspecialchars(trim($_POST['orga']));
        $siteweb = htmlspecialchars(trim($_POST['siteweb']));
        $telorga = htmlspecialchars(trim($_POST['tel']));
        $mail = filter_var(trim($_POST['mail']), FILTER_SANITIZE_EMAIL);
        $image = "null lol";

        // Gestion de l'upload du logo
        //$logo = $_FILES['logo'];
        //$target_dir = "uploads/logos/";
        //$target_file = $target_dir . basename($logo["name"]);

        // Vérification de l'upload
        //if (move_uploaded_file($logo["tmp_name"], $target_file)) {
            // Les champs de la table "entreprise"
            $sql = "INSERT INTO ORGANISATION (NOMORGA, MAILORGA, TELORGA, LOGOORGA, SITEORGA, NOMUTILISATEUR, PRENOMUTILISATEUR, MAILUTILISATEUR, MDPUTILISATEUR, ISADMINUTILISATEUR) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssssi", $orga, $email, $tel, $image, $siteweb, $nom, $prenom, $mail, $password, $admin);
        //} else {
        //    echo "Erreur lors de l'upload du logo.";
        //    exit;
        //}
    }
    if ($stmt->execute()) {
        echo "Données insérées avec succès !<br>";
        
        $_SESSION['user_logged_in'] = true;
        $_SESSION['user_id'] = $user['IDUTILISATEUR'];
        $_SESSION['user_email'] = $user['MAILUTILISATEUR'];
        
        switch ($role) {
                case 'eleve':
                    header('Location: eleve-accueil.html');
                    break;
                case 'professeur':
                    header('Location: professeur-accueil.html');
                    break;
                case 'entreprise':
                    header('Location: entreprise-accueil.html');
                    break;
        }
    } else {
        echo "Erreur lors de l'insertion des données : " . $stmt->error . "<br>";
    }
}


// Fermer la connexion
$conn->close();
?>
</body>
</html>