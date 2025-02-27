<?php
    session_start();

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $exit = true;
    $host = "localhost";
    $dbname = "gwwyymuy_ecom";
    $username = "gwwyymuy_admin";
    $password = "K54sU5Ql8pGJwCGzPhXj";
    $connexion = new mysqli($host, $username, $password, $dbname);

    if ($connexion->connect_error) {
        die("Échec de la connexion : ".$connexion->connect_error);
        $exit = false;
    }

    if (isset($_POST["prod"])) {
        $requete = mysqli_query($connexion,'SELECT `PRODSTOCK` FROM `PRODUITS` WHERE `PRODNUM` = '.$_POST["prod"].';');
        $results = mysqli_fetch_all($requete, MYSQLI_ASSOC);

        if (isset($_POST['Qte'.$_POST['prod']])) {
            $_SESSION['panier'][$_POST['prod']] = $_SESSION['panier'][$_POST['prod']] - $_POST['Qte'.($_POST['prod'])];
            mysqli_query($connexion, 'UPDATE `PRODUITS` SET `PRODSTOCK` = '.($results["prodStock"] + $_POST['Qte'.($_POST['prod'])]).' WHERE `PRODNUM` = '.$_POST['prod']);
        }
    }

    if ($exit) {
        session_destroy();
        header('Location: ../Accueil.php');
        exit;
    }
?>
