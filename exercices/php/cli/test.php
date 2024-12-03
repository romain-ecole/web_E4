<?php
//var_dump(__DIR__);
$fichier = __DIR__ . DIRECTORY_SEvPARATOR . 'demo.txt';
$ressources = fopen($fichier, "r");
/*$size = file_put_contents($fichier, 'Salut les gens');
if (!size) {
    echo "Erreur lors de l'envoi du fichier";
} else {
    echo "Envoi du fichier";
}*/
while ($line = fgets($ressources)) {
    $k++;
    if ($k == 1230) {
        fwrite($ressources, "Salut les gens");
        break;
    }
}
fclose($ressources);

