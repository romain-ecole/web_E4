<?php 
require_once "functions.php";
$viandes = [
    'boeuf' => 3,
    'poulet' => 2.5
];
$accompagnements = [
    'salade' => 1,
    'tomate' => 1,
    'ognions caramélisés' => 1.5
];
$sauces = [
    'barbecue' => 0.5,
    'ketchup' => 0.5,
    'mayonaise' => 0.5
];
$title = "";
$ingredients = [];
$total = 0;
foreach (['viande', 'accompagnement', 'sauce'] as $name) {
    if (isset($_POST[$name])) {
        $liste = $name.'s';
        $choix = $_POST[$name];
        if (is_array($choix)) {
            foreach($choix as $value) {
                if (isset($$liste[$value])) {
                    $ingredients[] = $value;
                    $total += $$liste[$value];
                }
            }
        }
    }
}
require "header.php";
?>
<div class="col-md-8">
    <h1><?= $title ?></h1>
    <?php // j'ai choisis la méthode post car je veux pas que les variables puissent être modifiées ?>
    <form action="/jeu.php" method="POST">
    <h2> Choisissez votre viande</h2>
        <?php foreach($viandes as $viande => $prix): ?>
            <div class="checkbox">
                <label>
                    <?= radio('viande', $viande, $_POST) ?>
                    <?= $viande ?> - <?= $prix ?> €
                </label>
            </div>
        <?php endforeach ?>
        <h2> Choisissez vos accompagnements</h2>
        <?php foreach($accompagnements as $accompagnement => $prix): ?>
            <div class="checkbox">
                <label>
                    <?= checkbox('accompagnement', $accompagnement, $_POST) ?>
                    <?= $accompagnement ?> - <?= $prix ?> €
                </label>
            </div>
        <?php endforeach ?>
        <h2> Choisissez vos sauces</h2>
        <?php foreach($sauces as $sauce => $prix): ?>
            <div class="checkbox">
                <label>
                    <?= checkbox('sauce', $sauce, $_POST) ?>
                    <?= $sauce ?> - <?= $prix ?> €
                </label>
            </div>
        <?php endforeach ?>
        <button type="submit">Composer mon Hamburger</button>
    </form>
</div>
<?php require "footer.php"; ?>