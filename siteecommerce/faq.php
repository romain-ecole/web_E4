<?php
    include_once("functions.php");
    session_start();

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
	<meta name="viewport" content="width-device-width initial-scale=1" /> <!--Regarder pour le zoom de la page d'accueil-->
    <link rel="stylesheet" href="style.css" />
    <title>Meub'Ebéniste - Qui somme nous ? </title>
    <link rel="shortcut icon" href="image temporaire" type="img/jpg" /> <!--Ajouter une image-->
</head>
<body>
    <?= GenHeader()?>
    <div>
        <img id="aimg" src="img/accueil.jpg" alt="Meuble d'art" />
        <div id="titresite" style="text-align: center">Meub'Ebéniste</div>
        <div id="banniereAccueilTexte">
            <p id="texte" class="zone-texte">Nous sommes des artisans passionnés, façonnant le bois avec amour et expertise pour créer des œuvres d'art intemporelles.
Chaque pièce que nous réalisons est le fruit d'un mariage entre la tradition ébéniste et l'innovation créative, incarnant ainsi l'essence même de notre métier. Notre atelier est le théâtre où le bois prend vie, transformé en des créations uniques qui allient la finesse du travail manuel à l'élégance du design. Chez nous, l'ébénisterie d'art est bien plus qu'un métier, c'est une passion transmise de génération en génération, et c'est avec un immense plaisir que nous donnons vie à vos rêves en bois<br />
        </div>
        </div>
    <p id="texteFinPage"><br />
        <a href="#textMenu"id="textelien3"</a></p>
    <?= GenFooter() ?>
</body>
</html>
