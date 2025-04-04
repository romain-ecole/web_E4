<?php

mail("romain.iohner@iohner.sio-chopin.fr", $_POST['object'], $_POST['message']);

header('Location: ../profil.php');