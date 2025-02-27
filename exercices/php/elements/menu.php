<?php
if (!function_exists('nav_item')) {

    function nav_item (string $lien, string $titre, string $linkClass = ''): string 
    {
        $classe = 'nav-item';
        if ($_SERVER['SCRIPT_NAME'] === $lien) {
            $classe .= ' active';
        }
        return <<<HTML
        <li class="$classe">
            <a class="$linkClass" href="$lien">$titre</a>
        </li>
HTML;
    }

}
?>

<?= nav_item('/webE4/exercices/php/index.php', 'Accueil',''); ?>
<?= nav_item('/webE4/exercices/php/contact.php', 'Contact',''); ?>