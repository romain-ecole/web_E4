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
?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-compatible" content="IE=edge">
    <meta name="viewport" content="width-device-width initial-scale=1" /> <!--Regarder pour le zoom de la page d'accueil-->
    <link rel="stylesheet" href="style.css" />
    <title>Meub'Ebéniste - Contact</title>
    <link rel="shortcut icon" href="image temporaire" type="img/jpg" /> <!--Ajouter une image-->
</head>
<body>
    <?= GenHeader()?>
    <div class="contactez-nous">
        <h1>Contactez-nous</h1>
        <p>Un problème, une question, veuillez remplir le formulaire pour nous contactez</p>
        <form action="/page-traitement-donnees" method="post">
            <div>
                <label form="nom">Votre Prénom : </label>
                <input type="text" id="prénom" name="prénom" placeholder="Saisissez votre prénom" required>
                <label form="nom">Votre Nom : </label>
                <input type="text" id="nom" name="nom" placeholder="Saisissez votre nom" required>
            </div>
            <div>
                <label for="email">Votre adresse email : </label>
                <input type="email" id="email" name="email" placeholder="monadresse@gmail.com" required>
                <label for="email">Votre adresse postale: : </label>
                <input type="email" id="email" name="email" placeholder="monadresse@gmail.com" required>
            </div>
            <div>
                <label form="moyenpaie">Moyen de Paiement</label>
                <select name="sujet" id="sujet" required>
                    <option value="" disabled selected hidden>--déroulez pour choisir--</option>
                    <option value="carte bancaire">Carte Bancaire</option>
                    <option value="paypal">Paypal</option>
                </select>
            </div>
            <div>
                <label for="message">Informations Paiement</label>
                <textarea id="message" name="message" placeholder="Saisissez votre message" required></textarea>
            </div>
            <div>
                <button type="submit">Envoyer mon message</button>
            </div>
        </form>
    </div>
    <?= GenFooter() ?>
</body>

