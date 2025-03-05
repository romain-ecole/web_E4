<?php
// Connexion à la base de données avec les identifiants spécifiques
$host = "localhost";
$dbname = "gwwyymuy_stagehunt";
$username = "gwwyymuy_admin";
$password = "K54sU5Ql8pGJwCGzPhXj";
$conn = new mysqli($host, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

$action = isset($_GET['action']) ? $_GET['action'] : 'view';

switch ($action) {
    case 'view': // Voir toutes les offres
        echo "<h2>Liste des Offres de Stage</h2>";
        $sql = "SELECT * FROM offers";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table><tr><th>ID</th><th>Titre</th><th>Entreprise</th><th>Actions</th></tr>";
            while ($offer = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$offer['id']}</td>
                        <td>{$offer['title']}</td>
                        <td>{$offer['company']}</td>
                        <td>
                            <a href='?action=approve&id={$offer['id']}'>Approuver</a> | 
                            <a href='?action=modify&id={$offer['id']}'>Modifier</a> | 
                            <a href='?action=delete&id={$offer['id']}'>Supprimer</a>
                        </td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "Aucune offre disponible.";
        }
        break;

    case 'approve': // Approuver une offre
        $id = (int) $_GET['id'];
        $stmt = $conn->prepare("UPDATE offers SET approved = 1 WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "Offre approuvée avec succès !";
        } else {
            echo "Erreur lors de l'approbation de l'offre.";
        }
        $stmt->close();
        break;

    case 'modify': // Modifier une offre
        $id = (int) $_GET['id'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = htmlspecialchars(trim($_POST['title']));
            $company = htmlspecialchars(trim($_POST['company']));

            $stmt = $conn->prepare("UPDATE offers SET title = ?, company = ? WHERE id = ?");
            $stmt->bind_param("ssi", $title, $company, $id);
            if ($stmt->execute()) {
                echo "Offre modifiée avec succès !";
            } else {
                echo "Erreur lors de la modification de l'offre.";
            }
            $stmt->close();
        } else {
            $stmt = $conn->prepare("SELECT * FROM offers WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $offer = $result->fetch_assoc();

            echo "<form method='post'>
                    <label>Titre : <input type='text' name='title' value='{$offer['title']}'></label><br>
                    <label>Entreprise : <input type='text' name='company' value='{$offer['company']}'></label><br>
                    <button type='submit'>Modifier</button>
                </form>";
            $stmt->close();
        }
        break;

    case 'delete': // Supprimer une offre
        $id = (int) $_GET['id'];
        $stmt = $conn->prepare("DELETE FROM offers WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "Offre supprimée avec succès !";
        } else {
            echo "Erreur lors de la suppression de l'offre.";
        }
        $stmt->close();
        break;
}

// Fermer la connexion
$conn->close();
?>
