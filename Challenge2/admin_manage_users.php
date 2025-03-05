<?php
// Connexion à la base de données
$host = "localhost";
$dbname = "stage_hunt";
$username = "root";
$password = ""; // À modifier selon tes identifiants
$conn = new mysqli($host, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Action à effectuer
$action = isset($_GET['action']) ? $_GET['action'] : 'view';

switch ($action) {
    case 'view': // Voir tous les utilisateurs
        echo "<h2>Liste des Utilisateurs</h2>";
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);
        
        echo "<table>";
        echo "<tr><th>ID</th><th>Nom</th><th>Email</th><th>Rôle</th><th>Actions</th></tr>";
        if ($result->num_rows > 0) {
            while ($user = $result->fetch_assoc()) {
                echo "<tr><td>{$user['id']}</td><td>{$user['nom']}</td><td>{$user['email']}</td><td>{$user['role']}</td>";
                echo "<td><a href='?action=modify&id={$user['id']}'>Modifier</a> | <a href='?action=delete&id={$user['id']}'>Supprimer</a></td></tr>";
            }
        }
        echo "</table>";
        break;

    case 'add': // Ajouter un utilisateur
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nom = htmlspecialchars($_POST['nom']);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $role = $_POST['role'];

            $stmt = $conn->prepare("INSERT INTO users (nom, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('ssss', $nom, $email, $password, $role);
            $stmt->execute();

            echo "Utilisateur ajouté avec succès !";
        } else {
            echo "<h2>Ajouter un Utilisateur</h2>";
            echo "<form method='post'>
                    <label>Nom : <input type='text' name='nom'></label><br>
                    <label>Email : <input type='email' name='email'></label><br>
                    <label>Mot de passe : <input type='password' name='password'></label><br>
                    <label>Rôle : <select name='role'>
                        <option value='admin'>Administrateur</option>
                        <option value='eleve'>Élève</option>
                        <option value='entreprise'>Entreprise</option>
                    </select></label><br>
                    <button type='submit'>Ajouter</button>
                </form>";
        }
        break;

    case 'modify': // Modifier un utilisateur
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nom = htmlspecialchars($_POST['nom']);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $role = $_POST['role'];

            $stmt = $conn->prepare("UPDATE users SET nom = ?, email = ?, role = ? WHERE id = ?");
            $stmt->bind_param('sssi', $nom, $email, $role, $id);
            $stmt->execute();

            echo "Utilisateur modifié avec succès !";
        } else {
            $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            echo "<h2>Modifier un Utilisateur</h2>";
            echo "<form method='post'>
                    <label>Nom : <input type='text' name='nom' value='{$user['nom']}'></label><br>
                    <label>Email : <input type='email' name='email' value='{$user['email']}'></label><br>
                    <label>Rôle : <select name='role'>
                        <option value='admin' " . ($user['role'] == 'admin' ? 'selected' : '') . ">Administrateur</option>
                        <option value='eleve' " . ($user['role'] == 'eleve' ? 'selected' : '') . ">Élève</option>
                        <option value='entreprise' " . ($user['role'] == 'entreprise' ? 'selected' : '') . ">Entreprise</option>
                    </select></label><br>
                    <button type='submit'>Modifier</button>
                </form>";
        }
        break;

    case 'delete': // Supprimer un utilisateur
        $id = $_GET['id'];
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();

        echo "Utilisateur supprimé avec succès !";
        break;
}

// Fermer la connexion
$conn->close();
?>
