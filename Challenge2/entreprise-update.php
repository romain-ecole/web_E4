<?php
// Connexion à la base de données
$host = "localhost";
$dbname = "gwwyymuy_stagehunt";
$username = "gwwyymuy_admin";
$password = "K54sU5Ql8pGJwCGzPhXj";     // À modifier selon tes identifiants
$conn = new mysqli($host, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

session_start();
$company_id = $_SESSION['company_id']; // ID de l'entreprise connecté (à récupérer via session)

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_info'])) {
        // Mise à jour des informations de l'entreprise
        $company_name = htmlspecialchars(trim($_POST['company_name']));
        $company_email = filter_var($_POST['company_email'], FILTER_SANITIZE_EMAIL);
        $company_phone = htmlspecialchars(trim($_POST['company_phone']));
        $company_address = htmlspecialchars(trim($_POST['company_address']));

        $sql = "UPDATE entreprises SET name = ?, email = ?, telephone = ?, adresse = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $company_name, $company_email, $company_phone, $company_address, $company_id);
        $stmt->execute();

        echo "Informations de l'entreprise mises à jour avec succès.";
    }

    if (isset($_POST['update_password'])) {
        // Modification du mot de passe
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Vérification du mot de passe actuel
        $sql = "SELECT password FROM entreprises WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $company_id);
        $stmt->execute();
        $stmt->bind_result($stored_password);
        $stmt->fetch();

        if (password_verify($current_password, $stored_password)) {
            if ($new_password === $confirm_password) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $sql = "UPDATE entreprises SET password = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $hashed_password, $company_id);
                $stmt->execute();

                echo "Mot de passe modifié avec succès.";
            } else {
                echo "Les nouveaux mots de passe ne correspondent pas.";
            }
        } else {
            echo "Le mot de passe actuel est incorrect.";
        }

        // Fermer la déclaration préparée
        $stmt->close();
    }
}

// Fermer la connexion
$conn->close();
?>
