<?php

use objets\personnages;

require "personnages.php";

$gandalf = new personnages('Gandalf');

$merlin = new personnages('Merlin');

echo $merlin->attaquer($gandalf);

//-------------------------------------

require "form.php";

$form = new form($_POST);

?>

<form action="#" method="POST">
    <?php
        echo $form->input('username');
        echo $form->input('password');
        echo $form->submit();
    ?>
</form>
