<?php
//set de la timezone en france
date_default_timezone_set('Europe/Paris');
//appel des fichiers utiles
require 'elements/header.php';
require_once("functions.php");
require_once("data/config.php");
//définition des variables
$title = "Nous contacter";
$heure = $_POST['heure'] ?? date('G');
$jour = (int)($_POST['jour'] ?? date('N') - 1);
$creneaux = CRENEAUX[$jour];
$ouvert = in_creneaux($heure, $creneaux);
$color = $ouvert ? "green" : "red";
?>

<div class="row">
    <div class="col-md-8">
    <h2>Nous contacter</h2>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam eveniet similique blanditiis iusto voluptas illo accusantium aperiam quas mollitia! Nobis optio provident tenetur ad ipsam quibusdam impedit voluptatibus doloribus rerum.</p>
    </div>
    <div class="col-md-4">
        <h2>Horraires d'ouverture</h2>
        <ul>
            <?php //se fie au jour selectionné, par défaut le jour courrant, sinon celui selectionné ?>
            <?php if ($ouvert): ?>
            <div class="alert alert-success">
                Le magasin est ouvert
            </div>
            <?php else: ?>
            <div class="alert alert-danger">
                Le magasin est fermé
            </div>
            <?php endif ?>
            <?php //boucle permettant d'afficher la liste des jours et le jour courrant en couleur selon l'ouverture (la couleur change aussi en fonction de la date selectionnée manuellement ?>
            <?php foreach(JOURS as $k => $jour): ?>
                <li <?php if ($k + 1 === (int)date('N')): ?>
                    style="color:<?= $color ?>">
                <?php endif ?>
                <?= "<strong>" . $jour . "</strong> ".creneaux_html(CRENEAUX[$k]); ?></li>
            <?php endforeach; ?>
            <?php //formulaire de choix de la date, envoyé par POST pour éviter les modifications et l'affichage des variables dans l'URL?>
            <form action="" method="POST">
                <div class="form-group">
                    <?= select('jour', $jour, JOURS) ?>
                </div>
                <div class="form-group">
                    <input class="form-control" type="number" name="heure" value="<?= $heure ?>">
                </div>
                <button class="btn btn-primary" type="submit"> Vérifier l'horraire</button>
            </form>
        </ul>
    </div>
</div>
<?php //appel du footer ?>
<?php require 'elements/footer.php'; ?>