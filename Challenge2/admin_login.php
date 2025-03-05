<?php
// Démarrer la session
session_start();

// Activer l'affichage des erreurs PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données avec mysqli
$host = "localhost";
$dbname = "gwwyymuy_stagehunt";
$username = "gwwyymuy_admin";
$password = "K54sU5Ql8pGJwCGzPhXj";

// Créer la connexion
$conn = new mysqli($host, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    // Rechercher l'admin dans la base de données
    $sql = "SELECT * FROM UTILISATEUR WHERE MAILUTILISATEUR = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);  // "s" signifie que c'est une chaîne de caractères
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    // Vérifier le mot de passe
    if ($admin && ($password == $admin['MDPUTILISATEUR'])) {
        // Connexion réussie, démarrer la session admin
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $admin['IDUTILISATEUR'];
        $_SESSION['admin_email'] = $admin['email'];

        // Rediriger vers la page a-accueil.html
        header('Location: a_accueil.html');
        exit;
    } else {
        $error_message = "Email ou mot de passe incorrect.";
    }
}

// Fermer la connexion
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Administrateur - Stage Hunt</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <header>
        <h1>Connexion Administrateur</h1>
    </header>

    <main>
        <form action="admin_login.php" method="post">
            <label for="email">Email :</label>
            <input type="email" name="email" id="email" required>
            
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" required>
            
            <button type="submit">Se connecter</button>

            <?php
            // Afficher un message d'erreur s'il y a un problème de connexion
            if (isset($error_message)) {
                echo "<p style='color: red;'>$error_message</p>";
            }
            ?>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Stage Hunt. Tous droits réservés.</p>
    </footer>
</body>
</html>
