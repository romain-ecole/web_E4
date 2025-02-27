<?php
    include_once("functions.php");
    session_start();

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $tableauRempli = false;
    $acc = 0;
    $host = "localhost";
    $dbname = "gwwyymuy_ecom";
    $username = "gwwyymuy_admin";
    $password = "K54sU5Ql8pGJwCGzPhXj";
    $connexion = new mysqli($host, $username, $password, $dbname);

    if ($connexion->connect_error) {
        die("Échec de la connexion : ".$connexion->connect_error);
    } else {
        /*<DEBUG>
        echo ("DEBUG : Connexion à la base de données réussie !<br>");
        //</DEBUG>*/
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Meub'Ebéniste - Panier</title>
    <link rel="stylesheet" href="style.css" />
</head>
    <body>
        <?= GenHeader()?>
        <?php
        //<DEBUG>
        var_dump($_SESSION['panier']);
        //</DEBUG>
        foreach($_SESSION['panier'] as $key)
        {
            if (isset($_SESSION['panier'][$key]))
            {
                if ($_SESSION['panier'][$key] !== 0)
                {
                $tableauRempli = true;
                }
            }
        }
        //<DEBUG>
        var_dump($tableauRempli);
        //</DEBUG>
        if ($tableauRempli && $connexion)
        {
            if (isset($_POST['remove']) && $_POST['remove'] === '') {

                $requete2 = mysqli_query($connexion,'SELECT `PRODSTOCK` FROM `PRODUITS` WHERE `PRODNUM` = '.$_POST["remove"].';');
                $return = "Vous venez de supprimer ".$_POST["removeQte"]." ".$requete2['PRODNOM']." de votre panier.";
                print "<div class='alert alert-success'> ".$return."</div>";
                $_POST['remove'] = '';
            }
        ?>
        <table id="tableProd">
            <tr>
                <td id="lignehaut">Image du produit</td>
                <td id="lignehaut">Numéro produit</td>
                <td id="lignehaut">Nom du produit</td>
                <td id="lignehaut">Poid du produit</td>
                <td id="lignehaut">Dimensions du produit</td>
                <td id="lignehaut">Coût du produit</td>
                <td id="lignehaut">Quantité achetée</td>
                <td id="lignehaut">Prix total</td>
            </tr>
        <?php
            foreach($_SESSION['panier'] as $key)
            {
                $listeAchat = "";
                if ($_SESSION['panier'][$key] != 0)
                {
                    $requete = mysqli_query($connexion, 'SELECT * FROM `PRODUITS` WHERE `PRODNUM` = '.$key.';');
                    $results = mysqli_fetch_all($requete, MYSQLI_ASSOC);

                    print "<form action='scripts/retirerPanier.php' id='leForm".$key."' method='post'>";
                    print "<tr id='ligneCoul".($key+1) % 2 ."'>";
                    print "<td id='col1'> <img src='img/".$key.".png' height=100 witdh=100> </td>";
                    print "<td id='col2'>".$key."</td>";
                    print "<td id='col3'>".mb_convert_encoding($results['PRODNOM'], 'UTF-8', mb_list_encodings())."</td>";
                    print "<td id='col4'>".$results['PRODPOID']."Kg</td>";
                    print "<td id='col5'>".$results['PRODDIM']."</td>";
                    print "<td id='col6'>".$results['PRODCOUT']."€</td>";
                    $listeAchat = "<select name='Qte".$key."' id='Qte".$key."'>";
                    $listeAchat .= "<option value='1' selected>1</option>";
                    $k = 2;
                    while($k <= $_SESSION['panier'][$key])
                    {
                        $listeAchat .= "<option value='" . $k . "'>" . $k . "</option>";
                        $k++;
                    }
                    $listeAchat .= "</select>";
                    print "<td id='col7'>".$_SESSION['panier'][$key]."<br>".$listeAchat." height=17 witdh=17></td>";
                    print "<td id='col8'>".$results['PRODCOUT'] * $_SESSION['panier'][$key]."€ </td>";
                    $acc += $results['PRODCOUT'] * $_SESSION['panier'][$key];
                    print "</tr>";
                    print "<input type='hidden' name='prod' value='".$key."'>";
                    print "</form>";
                }
            }
            $acc2 = (int)(($acc * 1.2)/1.01);
            print "<tr id='ligneCoul".$key % 2 ."'>";
            print "<td colspan='7'> Prix total de la commande TTC </td>";
            print "<td id='col9'> $acc2 €</td>";
        ?>
            </tr>
        </table><br>
        <form action ="scripts/sessionExit.php" id="leForm" method="POST">
            <div id="bouton">
                <button type="button" id="button">Commander</button>
            </div>
        </form>
        <?php
        } else {
            print "Le panier est vide.";
        } ?>
        <?= GenFooter()?>
    </body>
</html>