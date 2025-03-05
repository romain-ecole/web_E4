<?php
// Connexion à la base de données
$host = "localhost";
$dbname = "stage_hunt";
$username = "root";
$password = "";
$conn = new mysqli($host, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Obtenir les logs des 3 dernières heures
$sql = "SELECT * FROM logs WHERE timestamp >= NOW() - INTERVAL 3 HOUR";
$result = $conn->query($sql);

echo "<h2>Activités des Utilisateurs (dernières 3 heures)</h2>";
echo "<table><tr><th>Utilisateur</th><th>Action</th><th>Heure</th></tr>";

// Affichage des résultats
if ($result->num_rows > 0) {
    while ($log = $result->fetch_assoc()) {
        echo "<tr><td>{$log['user_id']}</td><td>{$log['action']}</td><td>{$log['timestamp']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "<tr><td colspan='3'>Aucune donnée trouvée.</td></tr></table>";
}

// Fermer la connexion
$conn->close();
?>
