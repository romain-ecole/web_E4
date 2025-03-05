<?php

session_start();

// Connexion à la base de données
$host = "localhost";
$dbname = "gwwyymuy_stagehunt";
$username = "gwwyymuy_admin";
$password = "K54sU5Ql8pGJwCGzPhXj";

// Activer l'affichage des erreurs PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Créer une connexion MySQLi
$conn = new mysqli($host, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Assumer que l'identifiant du professeur est récupéré via session ou authentification
$professeur_id = $_SESSION['user_id'];  // Remplace par la session ou l'ID dynamique du professeur

$sql = "SELECT CLASSEPROF FROM PROFESSEUR WHERE IDUTILISATEUR = ?";
$stms = $conn->prepare($sql);
$stms->bind_param("i", $professeur_id);
$stms->execute();
$resultClasse = $stms->get_result();
$classeData = $resultClasse->fetch_assoc();
$classe = $classeData['CLASSEPROF'] ?? '';

// Récupérer les élèves du professeur
if ($classe == "SIO All") {
    $sql = "SELECT * FROM ELEVE";
    $stmt = $conn->prepare($sql);
}   else {
    $sql = "SELECT * FROM ELEVE WHERE CLASSEELEVE = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $classe);
}

$eleves = [];

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $eleves = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "Erreur lors de l'exécution : " . $stmt->error;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classe du Professeur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Liste des élèves de votre classe</h1>
    </header>

    <main>
        <section class="students-list">
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Classe</th>
                        <th>Stage Détails</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($eleves) > 0): ?>
                        <?php foreach ($eleves as $eleve): ?>
                            <tr>
                                <td><?= htmlspecialchars($eleve['NOMUTILISATEUR']) ?></td>
                                <td><?= htmlspecialchars($eleve['PRENOMUTILISATEUR']) ?></td>
                                <td><?= htmlspecialchars($eleve['CLASSEELEVE']) ?></td>
                                <td>
                                    <?php //if ($eleve['stage_titre']): ?>
                                        <!--<a href="eleve-details-stage.php?eleve_id=<?= $eleve['IDUTILISATEUR'] ?>">Voir le stage : <?= htmlspecialchars($eleve['stage_titre']) ?></a> -->
                                    <?php //else: ?>
                                        Pas de stage attribué
                                    <?php //endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">Aucun élève dans la classe pour le moment.</td>
                        </tr>
                    <?php endif; ?>
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
