<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer-master/src/Exception.php';
require __DIR__ . '/PHPMailer-master/src/PHPMailer.php';
require __DIR__ . '/PHPMailer-master/src/SMTP.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>récupération du mot de passe</title>
  </head>
  <body>
    <div class="login-form">
    <h2>Mot de passe oublié</h2>
    <form method="post" class="form-inline">
        <div class="form-group mb-2">
            <label for="email" class="sr-only"><b>Email</b></label>
            <input type="email" placeholder="Entrer votre email" name="email" class="form-control-plaintext" required>
            <button type="submit" class="btn btn-success">Envoyer</button>
        </div>
    </form>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
<style>
    .login-form {
        width: 340px;
        margin: 50px auto;
    }
</style>

<?php
// Envoie du mail de réinitialisation du mot de passe avec token
if (isset($_POST['email'])) {
    $token = uniqid();
    $url = "https://iohner.sio-chopin.fr/competence/token?token=$token";
    $message = "Bonjour, voici votre lien pour la récupération du mot de passe : $url";
    $mail = new PHPMailer(true);

    try {
        $mail->setFrom('romain.iohner@iohner.sio-chopin.fr', 'Admin');
        $mail->addAddress($_POST['email']);
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'récupération de mot de passe';
        $mail->Body = $message;
        $mail->send();

        $sql = "UPDATE etudiant SET TOKEN = ? WHERE EMAIL_ETUD = ?";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([$token, $_POST['email']]);

        echo 'Mail envoyé';
    } catch (Exception $e) {
        echo "Une erreur est survenue, veuillez contacter un administrateur: {$mail->ErrorInfo}";
    }
}
