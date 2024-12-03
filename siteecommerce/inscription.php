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

    echo ("Connexion réussie");
    echo ("<meta charset=\"UTF8\">");
    echo ("Le formulaire a été reçu<br><br>");
    //<DEBUG>
    echo ("Vous vous appelez ".$_REQUEST['nom']." ".
        $_REQUEST['prenom']." <br>et vous êtes nés le ".
        $_REQUEST['date_naissance']." <br>votre mot de passe est ".
        $_REQUEST['password']." <br>le telephone ".
        $_REQUEST['telephone']." <br>et votre email est ".
        $_REQUEST['email']." lol<br>");
    //</DEBUG>

    if ($_REQUEST['prenom'] != '' && $connexion) {
        $requete = 'insert into CLIENTS (CLTPNOM, CLTNOM, CLTPASS, CLTNAISS, CLTTEL, CLTMAIL, CLTADRESSE, CLTPAYMETHOD, CLTINFOBANQUE) 
        values(" '.$_REQUEST['prenom'].' ",
            " '.$_REQUEST['nom'].' ",
            " '.$_REQUEST['password'].' ",
            " '.$_REQUEST['date_naissance'].' ",
            " '.$_REQUEST['telephone'].' ",
            " '.$_REQUEST['email'].' ",
            " '.$_REQUEST['adress'].' ",
            " '.$_REQUEST['paiemethod'].' ",
            " '.$_REQUEST['coord'].' ")';

        $resultatRequete = $connexion->prepare($requete);
        //<DEBUG>
        if ($resultatRequete) {
            echo ("Données Envoyées !");
        } else {
            echo ("la connection à échouée");
        }
        //</DEBUG>
    }
?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-compatible" content="IE=edge">
    <meta name="viewport" content="width-device-width initial-scale=1" /> <!--Regarder pour le zoom de la page d'accueil-->
    <link rel="stylesheet" href="style.css" />
    <title>Meub'Ebéniste - Inscription </title>
    <link rel="shortcut icon" href="image temporaire" type="img/jpg" /> <!--Ajouter une image-->
    <script language="javascript">
        function vide(form)
        {
            if (form.prenom.value == '')
                alert('Saisissez votre prénom.');
            else
            if (form.nom.value == '')
                alert('Saisissez votre nom.');
            else
            if (form.password.value == '')
                alert('Saisissez votre mot de passe.');
            else
            if (form.date_naissance.value == '')
                alert('Saisissez votre date de naissance.');
            else
            if (form.telephone.value == '')
                alert('Saisissez votre numéro de téléphone.');
            else
            if (form.email.value == '')
                alert('Saisissez votre adresse mail.');
            else
            if (form.adress.value == '')
                alert('Saisissez votre adresse postale')
            else
            if (form.paiemethod.value == '')
                alert('Saisissez votre moyen de paiement')
            else
                form.submit();
        }
    </script>
</head>
<body>
    <?= GenHeader()?>
    <div class="contactez-nous">
        <h1>Inscription</h1>
        <form action="inscription.php" method="post">
            <div>
                <label form="nom">Votre Prénom* : </label>
                <input type="text" id="prenom" name="prenom" placeholder="Saisissez votre prénom">
                <label form="nom">Votre Nom* : </label>
                <input type="text" id="nom" name="nom" placeholder="Saisissez votre nom">
                <label form="nom">Votre Mot de passe* : </label>
                <input type="text" id="password" name="password" placeholder="Saisissez votre mot de passe">
                <label form="nom">Votre date de naissance* : </label>
                <input type="text" id="date_naissance" name="date_naissance" placeholder="Saisissez votre date de naissance JJ/MM/AAAA">
                <label form="nom">Votre numéro de Téléphone* : </label>
                <input type="text" id="telephone" name="telephone" placeholder="Saisissez votre numéro de Téléphone : ">
                <label form="nom">Votre adresse email* :</label>
                <input type="text" id="email" name="email" placeholder="monadresse@gmail.com">
                <label form="nom">Votre adresse postale* :</label>
                <input type="text" id="adress" name="adress" placeholder="monadresse@gmail.com">
            </div>
            <div>
                <label form="moyenpaie">Moyen de Paiement* :</label>
                <select name="paiemethod" id="paiemethod" required>
                    <option value="" disabled selected hidden>--déroulez pour choisir--</option>
                    <option value="carte">Carte Bancaire</option>
                    <option value="paypal">Paypal</option>
                </select>
                <label form="nom">Vos Coordonées bancaires :</label>
                <input type="text" id="coord" name="coord" placeholder="monadresse@gmail.com">
            </div>
            <div>
                <input type="button" id="button" name="monBouton" value="S'inscrire" onclick="vide(this.form)">
            </div>
        </form>
    </div>
    <?= GenFooter() ?>
</body>
