<?php

// Connexion à la base de données
$host = "localhost";
$dbname = "gwwyymuy_stagehunt";
$username = "gwwyymuy_admin";
$password = "K54sU5Ql8pGJwCGzPhXj";

session_start();

// Créer une connexion MySQLi
$conn = new mysqli($host, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

$entreprise_id = $_SESSION['user_id'];  // ID de l'entreprise connecté

// Récupérer les offres publiées par l'entreprise
$sql = "SELECT * FROM STAGE WHERE IDUTILISATEUR = ".$entreprise_id.";";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $entreprise_id);
$stmt->execute();
$result = $stmt->get_result();
$offres = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Offres de Stage - Stage Hunt</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <header>
        <h1>Mes Offres de Stage</h1>
        <nav>
            <ul>
                <li><a href="entreprise-publier-offre.html">Publier une Nouvelle Offre</a></li>
                <li><a href="logout.php">Se Déconnecter</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="offres-section">
            <h2>Offres publiées</h2>
            <table>
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Compétences</th>
                        <th>Description</th>
                        <th>Élèves Intéressés</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($offres as $offre): ?>
                    <tr>
                        <td><?= htmlspecialchars($offre['title']); ?></td>
                        <td><?= htmlspecialchars($offre['skills']); ?></td>
                        <td><?= htmlspecialchars($offre['description']); ?></td>
                        <td>
                            <?php
                            // Récupérer les élèves intéressés par cette offre
                            $sql = ("SELECT NOMUTILISATEUR, PRENOMUTILISATEUR FROM EFFECTUER WHERE IDSTAGE IN(SELECT IDSTAGE FROM STAGE WHERE IDUTILISATEUR = ".$_SESSION['user_id'].";");
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $offre['id']);
                            $stmt->execute();
                            $result_eleves = $stmt->get_result();
                            $eleves = $result_eleves->fetch_all(MYSQLI_ASSOC);

                            if ($eleves) {
                                foreach ($eleves as $eleve) {
                                    echo htmlspecialchars($eleve['PRENOMUTILISATEUR'] . " " . $eleve['NOMUTILISATEUR']) . "<br>";
                                }
                            } else {
                                echo "Aucun élève intéressé.";
                            }
                            ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Stage Hunt. Tous droits réservés.</p>
    </footer>
</body>
</html>

<?php
// Fermer la connexion
$conn->close();
?>
