<?php
// Démarrer la session
session_start();

// Activer l'affichage des erreurs PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
$host = "localhost";
$dbname = "gwwyymuy_stagehunt";
$username = "gwwyymuy_admin";
$password = "K54sU5Ql8pGJwCGzPhXj";

// Créer une connexion MySQLi
$conn = new mysqli($host, $username, $password, $dbname);

$role = $_POST['role'];

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);
    
    // Récupérer les données de connexion
    switch ($role) {
                case 'eleve':
                    $sql = "SELECT * FROM ELEVE WHERE MAILUTILISATEUR = ?";
                    break;
                case 'professeur':
                    $sql = "SELECT * FROM PROFESSEUR WHERE MAILUTILISATEUR = ?";
                    break;
                case 'entreprise':
                    $sql = "SELECT * FROM ORGANISATION WHERE MAILUTILISATEUR = ?";
                    break;
    }
    
    // Requête SQL pour rechercher l'utilisateur dans la base de données
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Vérifier si l'utilisateur existe et si le mot de passe correspond
    if ($user && ($password == $user['MDPUTILISATEUR'])) {
        // Connexion réussie, démarrer la session utilisateur
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
        exit;
    } else {
        $error_message = "Email ou mot de passe incorrect.";
        header('Location: index.html');
    }
}
// Fermer la connexion
$conn->close();
?>