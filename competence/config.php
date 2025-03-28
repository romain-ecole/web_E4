<?php 
    try 
    {
      $bdd = new PDO("mysql:host=localhost;dbname=gwwyymuy_ugo;charset=utf8", "gwwyymuy_ugo", "K54sU5Ql8pGJwCGzPhXj#");
    }
    catch(PDOException $e)
    {
      die('Erreur : '.$e->getMessage());
    }
