<?php

session_start();

// Activer l'affichage des erreurs PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

$eleve_id = $_SESSION['user_id'];  // ID de l'élève connecté

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $offre_id = $_POST['offre_id'];

    // Vérifier si l'élève a déjà postulé
    $place = 0;
    $sql = "SELECT * FROM STAGE WHERE PLACESTAGE > ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $place); // i pour integers (eleve_id et offre_id)
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
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stage Hunt - Offres de Stage</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Offres de Stage</h1>
        <p>Sélectionnez votre spécialité pour afficher les offres correspondantes</p>
    </header>

    <main>
        <div class="filter-buttons">
            <button id="btn-slam" class="filter-btn">SLAM</button>
            <button id="btn-sr" class="filter-btn">SISR</button>
        </div>

        <section id="offre-list" class="offer-list">
            <!-- SLAM offers -->
            <div class="offer-item" data-type="slam">
                <h3>Stage en Développement Web (SLAM)</h3>
                <p><strong>Entreprise :</strong> DevCorp</p>
                <p><strong>Compétences :</strong> PHP, JavaScript, HTML/CSS</p>
                <p><strong>Description :</strong> Développement de sites web dynamiques avec PHP et MySQL.</p>
            </div>

            <div class="offer-item" data-type="slam">
                <h3>Développeur Logiciel (SLAM)</h3>
                <p><strong>Entreprise :</strong> SoftTech</p>
                <p><strong>Compétences :</strong> C#, .NET, UML</p>
                <p><strong>Description :</strong> Développement de logiciels de gestion pour entreprises.</p>
            </div>

            <!-- Système Réseau offers -->
            <div class="offer-item" data-type="sr">
                <h3>Administrateur Réseau Junior (Système Réseau)</h3>
                <p><strong>Entreprise :</strong> NetworkSolutions</p>
                <p><strong>Compétences :</strong> Cisco, Routing, Firewall</p>
                <p><strong>Description :</strong> Gestion et configuration des réseaux d'entreprise.</p>
            </div>

            <div class="offer-item" data-type="sr">
                <h3>Technicien Réseaux (Système Réseau)</h3>
                <p><strong>Entreprise :</strong> GlobalNet</p>
                <p><strong>Compétences :</strong> VLAN, Switches, Routing</p>
                <p><strong>Description :</strong> Configuration des réseaux locaux et gestion des infrastructures.</p>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Stage Hunt. Tous droits réservés.</p>
    </footer>

    <script>
        const btnSlam = document.getElementById('btn-slam');
        const btnSr = document.getElementById('btn-sr');
        const offers = document.querySelectorAll('.offer-item');

        // Event listener for SLAM button
        btnSlam.addEventListener('click', () => {
            offers.forEach(offer => {
                if (offer.getAttribute('data-type') === 'slam') {
                    offer.style.display = 'block';
                } else {
                    offer.style.display = 'none';
                }
            });
        });

        // Event listener for Système Réseau button
        btnSr.addEventListener('click', () => {
            offers.forEach(offer => {
                if (offer.getAttribute('data-type') === 'sr') {
                    offer.style.display = 'block';
                } else {
                    offer.style.display = 'none';
                }
            });
        });

        // Display all offers on load
        window.onload = () => {
            offers.forEach(offer => offer.style.display = 'block');
        };
    </script>
</body>
</html>

