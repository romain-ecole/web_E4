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
        var_dump($connexion->connect_error);
        $exit = false;
    }

    $results = mysqli_query($connexion,'SELECT `PRODSTOCK` FROM `PRODUITS` WHERE `PRODNUM` = '.$_POST["produit"].';');
    $result = mysqli_fetch_all($results, MYSQLI_ASSOC);
    //<DEBUG>
    echo("POST : ");
    var_dump($_POST);
    echo("produit a ajouter en stock : ");
    var_dump($result);
    echo("qte de produit a ajouter : ");
    var_dump($result[0]['PRODSTOCK'],$_POST['Qte'.($_POST['produit'])]);
    //</DEBUG>
    mysqli_query($connexion, 'UPDATE `PRODUITS` SET `PRODSTOCK` = '.($result[0]['PRODSTOCK'] - $_POST['Qte'.($_POST['produit'])]).' WHERE `PRODNUM` = '.$_POST['produit']);

    foreach ($_SESSION["panier"] as $key)
    {
        if (!isset($_SESSION['panier'][$key]))
        {
            $_SESSION['panier'][$key] = 0;
        }
        if (isset($_POST['Qte'.$key]))
        {
            $_SESSION['panier'][$key] = $_SESSION['panier'][$key] + $_POST['Qte'.($_POST['produit'])];
        }
    }

    print "<form action='' method='POST'><input type='hidden' name='add' value='".$_POST['produit']."'><input type='hidden' name='addQte' value='".$_POST['Qte'.($_POST['produit'])]."'></form>";

    if ($exit) {
        header('Location: ../tableauProduits.php');
        exit;
    }
?>