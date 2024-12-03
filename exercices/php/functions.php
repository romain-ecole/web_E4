<?php

//cette fonction permet de génerer un élément du menu utilisés dans la fonction nav_menu()
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

//cette fonction permet de génerer la liste des éléments du menu utilisés dans le Header et le Footer
function nav_menu (string $linkClass = ''): string
{
    return 
        nav_item('/index.php', 'Accueil', $linkClass) .
        nav_item('/contact.php', 'Contact', $linkClass);
        nav_item('/menu.php', 'Menu', $linkClass);
}

//cette fonction permet de créer les composants checkbox pour les choix utilisateurs
function checkbox (string $name, string $value, array $data): string {
    $attributes = '';
    if (isset($data[$name]) && in_array($value, $data[$name])) {
        $attributes .= 'checked';
    }
    return <<<HTML
    <input type="checkbox" name="{$name}[]" value="$value">
HTML;
}

//cette fonction permet de créer les composants radio pour les choix utilisateurs
function radio (string $name, string $value, array $data): string {
    $attributes = '';
    if (isset($data[$name]) && $value === $data[$name]) {
        $attributes .= 'checked';
    }
    return <<<HTML
    <input type="checkbox" name="{$name}[]" value="$value" $attributes>
HTML;
}

//cette fonction permet d'afficher la liste des horraires d'ouverture et de fermeture par jour
function creneaux_html(array $creneaux) {
    if (empty($creneaux)) {
        return 'Fermé';
    }
    $phrases = [];
    foreach ($creneaux as $creneau) {
        $phrases[] = "de <strong>{$creneau[0]}h</strong> à <strong>{$creneau[1]}h</strong>";
    }
    return "Ouvert ".implode(" et ", $phrases);
}

//fonction permettant de vérifier si le magasin est ouvert
function in_creneaux(int $heures, array $creneaux): bool {
    foreach ($creneaux as $creneau) {
        $debut = $creneau[0];
        $fin = $creneau[1];
        if ($heures >= $debut && $heures < $fin) {
            return true;
        }
    }
    return false;
}

//fonction permettant d'ajouter l'attribut selected sur le jour actif de la semaine et ainsi qu'il apparaisse par défaut
function select(string $name, $value, array $options): string {
    $html_options = [];
    foreach($options as $k => $option) {
        $attributes = $k == $value ? ' selected' : '';
        $html_options[] = "<option value='$k'{$attributes}>{$option}</option>";
    }
    return "<select class='form-control' name='$name'" . implode($html_options) . "</select>";
}