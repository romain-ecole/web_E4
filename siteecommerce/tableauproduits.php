<?php
    include_once("functions.php");
    session_start();

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $host = "localhost";
    $dbname = "gwwyymuy_ecom";
    $username = "gwwyymuy_admin";
    $password = "K54sU5Ql8pGJwCGzPhXj";
    $connexion = new mysqli($host, $username, $password, $dbname);

    if ($connexion->connect_error) {
        die("Échec de la connexion : " . $connexion->connect_error);
    } else {
        /*<DEBUG>
        echo ("DEBUG : Connexion à la base de données réussie !<br>");
        //</DEBUG>*/
    }

    if (!isset($_SESSION['panier']))
    {
        $_SESSION['panier'] = array();
    }
    //initialisation des champs dans $_SESSION pour le pannier
    $i = 1;
    while ($i < 8)
    {
        if (!isset($_SESSION['panier'][$i-1]))
        {
            $_SESSION['panier'][$i-1] = 0;
        }
        if (isset($_REQUEST['Qte'.$i])) {
            //on ne passe ici que quand le formulaire à été envoyé
            if ($_REQUEST['Qte'.$i] !== NULL) {
                $_SESSION['panier'][$i-1] = $_REQUEST['Qte'.$i];
            }
            /*<DEBUG>
            echo ("DEBUG : Formulaire non envoyé<br>");
            //</DEBUG>*/
        }
        $i++;
    }
    /*<DEBUG>
    echo ("DEBUG : Création du champ 'panier' dans \$_SESSION et son contenu !<br>");
    if ($_SESSION['panier'][0] !== NULL)
        echo ("DEBUG : ".$_SESSION['panier'][0]);
        echo ("DEBUG : ".$_SESSION['panier'][1]);
        echo ("DEBUG : ".$_SESSION['panier'][2]);
        echo ("DEBUG : ".$_SESSION['panier'][3]);
        echo ("DEBUG : ".$_SESSION['panier'][4]);
        echo ("DEBUG : ".$_SESSION['panier'][5]);
        echo ("DEBUG : ".$_SESSION['panier'][6]);
        var_dump($_SESSION['panier']);
    //<DEBUG>*/
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Catalogue de produits</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
    <?= GenHeader()?>
    <form action = "" id="leForm" method="POST">
        <table id="tableProd">
            <tr>
                <td id="lignehaut"> Image du produit </td>
                <td id="lignehaut"> Numéro produit </td>
                <td id="lignehaut"> Nom du produit </td>
                <td id="lignehaut"> Poid du produit </td>
                <td id="lignehaut"> Dimensions du produit </td>
                <td id="lignehaut"> Coût du produit </td>
                <td id="lignehaut"> Prix du produit </td>
                <td id="lignehaut"> Mettre au panier </td>
            </tr>
            <?php
            if ($connexion)
            {
                /*<DEBUG>
                echo ("DEBUG : Entrée dans la zone php tableau<br>");
                //</DEBUG>*/
                $sql = "SELECT * FROM PRODUITS";
                $requete = mysqli_query($connexion,$sql);
                $results = mysqli_fetch_all($requete, MYSQLI_ASSOC);
                foreach($results as $row=>$donnees)
                {
                    /*</DEBUG>
                    var_dump($row,$donnees);
                    //</DEBUG>*/
                    $i = 2;
                    $listeAchat = "";
                    print "<tr id='ligneCoul".($row + 1) % 2 ."'>";
                    print "<td id='col1'><img src='img/".$donnees['PRODNUM'].".png' height=100 width=100> </td>";
                    print "<td id='col2'>".$donnees['PRODNUM']."</td>";
                    print "<td id='col3'>".mb_convert_encoding($donnees['PRODNOM'], 'UTF-8', mb_list_encodings())."</td>";
                    print "<td id='col4'>".$donnees['PRODPOID']."Kg</td>";
                    print "<td id='col5'>".$donnees['PRODDIM']."</td>";
                    print "<td id='col6'>".$donnees['PRODCOUT']."€</td>";
                    print "<td id='col7'>".$donnees['PRODPRIX']."€</td>";
                    $listeAchat = "<select name='Qte$row'".$donnees['PRODNUM']."' id='Qte$row'>";
                    $listeAchat .= "<option value='1' selected>1</option>";
                    while($i <= $donnees['PRODSTOCK'])
                    {
                        $listeAchat .= "<option value='" . $i . "'>" . $i . "</option>";
                        $i++;
                    }
                    $listeAchat .= "</select>";
                    print "<td id='col8'>" . $listeAchat . "<input type='image' id='boutonAjoutPannier' src='/img/icone.png' height=17 witdh=17></td>";
                    print "</tr>";
                }
                /*<DEBUG>
                echo ("DEBUG : Tableau généré<br>");
                //</DEBUG>*/
            } ?>
        </table>
    </form>
    <?= GenFooter() ?>
    </body>
</html>
