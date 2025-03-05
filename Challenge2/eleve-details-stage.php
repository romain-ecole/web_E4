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

// Récupérer l'id de l'élève
$eleve_id = $_GET['eleve_id'];

// Récupérer les détails du stage de l'élève
$sql = "SELECT s.titre, s.description, s.date_debut, s.date_fin, e.nom AS eleve_nom, e.prenom AS eleve_prenom
        FROM stages s
        JOIN eleves e ON s.eleve_id = e.id
        WHERE e.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $eleve_id); // Bind de l'ID de l'élève comme entier
$stmt->execute();
$result = $stmt->get_result();
$stage = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du stage</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Détails du stage de <?= htmlspecialchars($stage['eleve_nom']) ?> <?= htmlspecialchars($stage['eleve_prenom']) ?></h1>
    </header>

    <main>
        <section class="stage-details">
            <h2><?= htmlspecialchars($stage['titre']) ?></h2>
            <p><strong>Description :</strong> <?= htmlspecialchars($stage['description']) ?></p>
            <p><strong>Date de début :</strong> <?= htmlspecialchars($stage['date_debut']) ?></p>
            <p><strong>Date de fin :</strong> <?= htmlspecialchars($stage['date_fin']) ?></p>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Stage Hunt. Tous droits réservés.</p>
    </footer>
</body>
</html>

<?php
// Fermer la connexion à la base de données
$conn->close();
?>
