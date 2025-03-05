<?php
session_start(); // Assurer que l'utilisateur est connecté

// Connexion à la base de données
$host = "localhost";
$dbname = "gwwyymuy_stagehunt";
$username = "gwwyymuy_admin";
$password = "K54sU5Ql8pGJwCGzPhXj";

// Créer une connexion MySQLi
$conn = new mysqli($host, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Vérifier si l'utilisateur est bien connecté (par exemple via session)
if (!isset($_SESSION['professeur_id'])) {
    header("Location: login.php");
    exit;
}

// Récupérer l'ID du professeur depuis la session
$professeur_id = $_SESSION['professeur_id'];

// Récupérer les données du formulaire
$nom = htmlspecialchars(trim($_POST['nom']));
$prenom = htmlspecialchars(trim($_POST['prenom']));
$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
$telephone = htmlspecialchars(trim($_POST['telephone']));
$classe = htmlspecialchars(trim($_POST['classe']));
$password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

// Préparer la requête SQL pour la mise à jour
$sql = "UPDATE professeur SET nom = ?, prenom = ?, email = ?, telephone = ?, classe = ?" . ($password ? ", password = ?" : "") . " WHERE id = ?";

// Créer une préparation de requête SQLi
$stmt = $conn->prepare($sql);

// Vérifier si le mot de passe doit être mis à jour
if ($password) {
    // Lier les paramètres avec mot de passe
    $stmt->bind_param("ssssssi", $nom, $prenom, $email, $telephone, $classe, $password, $professeur_id);
} else {
    // Lier les paramètres sans mot de passe
    $stmt->bind_param("sssssi", $nom, $prenom, $email, $telephone, $classe, $professeur_id);
}

// Exécuter la requête SQL
if ($stmt->execute()) {
    echo "Modifications enregistrées avec succès!";
    header("Location: professeur-parametres.php"); // Rediriger après mise à jour
    exit;
} else {
    echo "Erreur lors de la mise à jour des informations.";
}

// Fermer la connexion et la préparation
$stmt->close();
$conn->close();
?>
