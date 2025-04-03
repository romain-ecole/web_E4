<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

    // Démarrage de la session 
    session_start();
    // Include de la base de données
    require_once '../config.php';


    // Si la session n'existe pas 
    if(!isset($_SESSION['id']))
    {
        header('Location:../index.php');
        die();
    }


    // Si les variables existent 
    if(!empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['new_password_retype'])){
        // XSS 
        $current_password = htmlspecialchars($_POST['current_password']);
        $new_password = htmlspecialchars($_POST['new_password']);
        $new_password_retype = htmlspecialchars($_POST['new_password_retype']);

        // On récupère les infos de l'utilisateur
        $check_password  = $bdd->prepare('SELECT MOT_DE_PASSE_ETUD FROM etudiant WHERE IDENTIFIANT_ETUD = :IDENTIFIANT_ETUD');
        $check_password->execute([
            "IDENTIFIANT_ETUD" => $_SESSION['id'],
        ]);
        $data_password = $check_password->fetch();

        // Si le mot de passe est le bon
        if(password_verify($current_password, $data_password['MOT_DE_PASSE_ETUD']))
        {
            // Si le mot de passe tapé est bon
            if($new_password === $new_password_retype){

                // On chiffre le mot de passe
                $cost = ['cost' => 12];
                $new_password = password_hash($new_password, PASSWORD_BCRYPT, $cost);
                // On met à jour la table utiisateurs
                $update = $bdd->prepare('UPDATE etudiant SET MOT_DE_PASSE_ETUD = :MOT_DE_PASSE_ETUD WHERE IDENTIFIANT_ETUD = :IDENTIFIANT_ETUD');
                $update->execute(array(
                    "MOT_DE_PASSE_ETUD" => $new_password,
                    "IDENTIFIANT_ETUD" => $_SESSION['id']
                ));
                // On redirige
                header('Location: ../profil.php?err=success_password');
                die();
            }
        }
        else{
            header('Location: ../profil.php?err=current_password');
            die();
        }

    }
    else{
        header('Location: ../profil.php');
        die();
    }