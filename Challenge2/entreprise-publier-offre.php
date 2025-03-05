<?php
// Connexion à la base de données
$host = "localhost";
$dbname = "gwwyymuy_stagehunt";
$username = "gwwyymuy_admin";
$password = "K54sU5Ql8pGJwCGzPhXj";    // À modifier selon tes identifiants

// Créer une connexion avec MySQLi
$conn = new mysqli($host, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $orga = $_SESSION['user_id'];
    $title = htmlspecialchars(trim($_POST['title']));
    $desc = htmlspecialchars(trim($_POST['desc']));
    $place = $_POST['option'];
    $lieu = htmlspecialchars(trim($_POST['lieu']));
    if ($_POST['type-stage'] == "developpement") {
        $option = "SLAM";
    } else {
        $option = "SISR";
    }
    if ($_POST['lecture'] == "lecture") {
        $statut = true;
    } else {
        $option = false; //option par défaut dans le html
    }
    if ($_POST['statut'] == "visible") {
        $statut = true; //option par défaut dans le html
    } else {
        $option = false;
    }
    
    // Récupérer l'ID de l'entreprise depuis la session (si elle est connectée)
    session_start();
    $entreprise_id = $_SESSION['entreprise_id'];  // Assurez-vous que la session stocke bien cet ID

    // Insertion de l'offre dans la base de données
    $sql = "INSERT INTO STAGE (IDUTILISATEUR, TITRESTAGE, DESCSTAGE, PLACESTAGE, OPTIONSTAGE, LIEUSTAGE, LECTURESEULESTAGE, STATUTSTAGE) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Lier les paramètres à la requête
    $stmt->bind_param("ississii", $orga, $title, $desc, $place, $option, $lieu, $lectureseulle, $statut);

    // Exécuter la requête
    if ($stmt->execute()) {
        echo "Offre publiée avec succès.";
        header('Location: entreprise-voir-offres.php'); // Redirige vers la page de consultation des offres
        exit();
    } else {
        echo "Erreur lors de la publication de l'offre.";
    }

    // Fermer la déclaration
    $stmt->close();
}

// Fermer la connexion
$conn->close();
?>
