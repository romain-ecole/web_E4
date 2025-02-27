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
        die("Échec de la connexion : " . $connexion->connect_error);
        $exit = false;
    }

    $results = mysqli_query($connexion,'SELECT `PRODSTOCK` FROM `PRODUITS` WHERE `PRODNUM` = '.$_POST["prod"].';');
    $result = mysqli_fetch_all($results, MYSQLI_ASSOC);

    //si la case de quantitée des articles pour l'article selectionné est différente de NULL alors
    if (isset($_POST['Qte'.$_POST['prod']]))
    {
        //on déduit la quantitée du panier et remet la quantitée dans la bdd
        $_SESSION['panier'][$_POST['prod']] = $_SESSION['panier'][$_POST['prod']] - $_POST['Qte'.$_POST['prod']];
        mysqli_query($connexion, 'UPDATE `PRODUITS` SET `PRODSTOCK` = '.($result[0]['PRODSTOCK'] + $_POST['Qte'.($_POST['prod'])]).' WHERE `PRODNUM` = '.$_POST['prod'].';');
    }

    print "<form action='' method='POST'><input type='hidden' name='remove' value='".$_POST['prod']."'><input type='hidden' name='removeQte' value='".$_POST['Qte'.($_POST['prod'])]."'></form>";

    if ($exit) {
        header('Location: ../panier.php');
        exit;
    }
?>