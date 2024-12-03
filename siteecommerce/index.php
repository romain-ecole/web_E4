<?php
    include_once("functions.php");
    session_start();

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if (!isset($_SESSION['panier']))
    {
        $_SESSION['panier'] = array();
    }

    /*<DEBUG>*/
    echo ("DEBUG : ");
    var_dump($_SERVER['SCRIPT_NAME']);
    /*</DEBUG>*/
?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width-device-width initial-scale=1" />
    <link rel="stylesheet" href="style.css" />
    <title>Meub'Ebéniste - Accueil</title>
</head>
<body>
    <?= GenHeader()?>
    <div>
        <img id="aimg" src="img/accueil.jpg" alt="Meuble d'art" />
        <div id="titresite" style="text-align: center">Meub'Ebéniste</div>
        <div id="banniereAccueilTexte">
            <!--titre a mettre ici-->
            <p id="texte">Artisant ébéniste depuis 1982, nos ouvriers qualifiés vous proposent des meubles d'art de grande qualité <br />
                <a id="texte" style="; font-family: none; color: #f9cb9c" href="faq.php">En savoir plus sur nous.</a><br /><br />
                <a id="textelien2" href="#mtitre">D&eacute;couvrir nos produits</a></p>  <!--Ancre a placer-->
        </div>
    </div>
    <article>
        <p id="mtitre">Pendule Murale Style Louis XVI</p>
        <img id="mimg1" src="img/artPendule.png">
        <p id="mdesc">Pendule en chêne vernis, avec feuille d'or sur le cadre du balancier<br />Le mouvement fonctionne il sonne les heures et les demies.<br />De style Louis XVI original.</p>
        <p id="mprix">269,99€ TTC</p>
    </article>
    <article>
        <p id="mtitre">Table tiroir du XIXème</p>
        <img id="mimg2" src="img/artTable.png">
        <p id="mdesc">Table à thé en chêne avec plusieurs couches de vernis.<br />Moulures composées, tablier s'ouvre par le dessus.<br />De style Louis XVI sans feuille d'or.</p>
        <p id="mprix">245.99€ TTC</p>
    </article>
    <article>
        <p id="mtitre">Armoire Style Louis XV</p>
        <img id="mimg3" src="img/artArmoire.png">
        <p id="mdesc">Tout en bois massif, assortiment de différentes essences de bois. chêne, hêtre et merisier vernis.<br /> Portes moulurées, piétement aux terminaisons en rouleaux, ferrures d'origine, serrure fonctionnelle.<br />De style Louis XV</p>
        <p id="mprix">559,99€</p>
    </article>
    <p id="texteFinPage">Découvrez de nouveaux produits chaque semaines.<br />
        <a href="#textMenu"id="textelien3">Revenir à l'accueil</a></p>
    <?= GenFooter() ?>
</body>
