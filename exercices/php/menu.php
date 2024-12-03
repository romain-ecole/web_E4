<?php require 'elements/header.php' require_once('functions.php');
$title = 'Notre menu'
$menu = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'menu.tsv');
$lignes = explode(PHP_EOL, $menu);
foreach ($lignes as $k => $ligne) {
    $lignes[$k] = explode('\t', trim($ligne));
}

?>

<h1>Menu</h1>

<?php foreach($lignes as $ligne): ?>
    <?php if (count($ligne) === 1): ?>
        <h2><?= $lignes[0];?></h2>
    <?php else: ?>
        <div class="col">
            <div class="col.sm-8">
                <P>
                    <strong><?= $lignes[0]; ?></strong><br>
                    <?= $lignes[1]; ?>
                </P>
            </div>
            <div class="col-sm-4">
                <strong><?= number_format($lignes[2], 2, ',', ' '); ?></strong>
            </div>
        </div>
    <?php endif ?>
<?php endforeach; ?>


<?php require 'elements/footer.php'; ?>
