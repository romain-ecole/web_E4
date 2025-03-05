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

// Simuler l'ID de l'utilisateur connecté (ici c'est une démo, donc à remplacer par une session utilisateur)
$user_id = 1;  // Exemple : l'ID de l'élève connecté

// Récupérer les candidatures auxquelles l'élève a montré un intérêt
$sql = "SELECT c.id, o.title, o.company, c.status, c.date_applied 
        FROM candidatures c
        JOIN offers o ON c.offer_id = o.id
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);  // L'ID de l'utilisateur doit être un entier
$stmt->execute();
$result = $stmt->get_result();
$candidatures = $result->fetch_all(MYSQLI_ASSOC);

// Fermer la connexion préparée
$stmt->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Candidatures - Stage Hunt</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <header>
        <h1>Mes Candidatures</h1>
        <nav>
            <ul>
                <li><a href="dashboard.php">Tableau de bord</a></li>
                <li><a href="offers.php">Voir les offres</a></li>
                <li><a href="candidature.php">Mes Candidatures</a></li>
                <li><a href="logout.php">Se Déconnecter</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="candidatures-section">
            <h2>Candidatures auxquelles vous avez porté un intérêt</h2>
            <?php if (count($candidatures) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Offre de Stage</th>
                            <th>Entreprise</th>
                            <th>Statut</th>
                            <th>Date de Candidature</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($candidatures as $candidature): ?>
                            <tr>
                                <td><?= htmlspecialchars($candidature['title']) ?></td>
                                <td><?= htmlspecialchars($candidature['company']) ?></td>
                                <td><?= htmlspecialchars($candidature['status']) ?></td>
                                <td><?= date("d/m/Y", strtotime($candidature['date_applied'])) ?></td>
                                <td>
                                    <a href="view_offer.php?id=<?= $candidature['id'] ?>">Voir Offre</a> |
                                    <a href="withdraw_application.php?id=<?= $candidature['id'] ?>">Retirer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Vous n'avez encore porté intérêt à aucune candidature.</p>
            <?php endif; ?>
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
