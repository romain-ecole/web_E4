<?php
// Connexion à la base de données
$host = "localhost";
$dbname = "gwwyymuy_stagehunt";
$username = "gwwyymuy_admin";
$password = "K54sU5Ql8pGJwCGzPhXj";
$conn = new mysqli($host, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

session_start();
$eleve_id = $_SESSION['eleve_id'];  // ID de l'élève connecté

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $offre_id = $_POST['offre_id'];

    // Vérifier si l'élève a déjà postulé
    $sql = "SELECT * FROM candidatures WHERE eleve_id = ? AND offre_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $eleve_id, $offre_id); // i pour integers (eleve_id et offre_id)
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Insérer la candidature
        $sql = "INSERT INTO candidatures (eleve_id, offre_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $eleve_id, $offre_id);
        $stmt->execute();

        echo "Candidature enregistrée avec succès.";
        header('Location: offres-stage.php');
        exit();
    } else {
        echo "Vous avez déjà candidaté à cette offre.";
    }

    // Fermer la connexion préparée
    $stmt->close();
}

// Fermer la connexion MySQLi
$conn->close();
?>
