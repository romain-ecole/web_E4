<?php
require_once 'elements/header.php';
$error = ''; $success = '';
if (!empty($_POST['email'])) {
    $email = $_POST['email'];
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $file = __DIR__ . DIRECTORY_SEPARATOR . 'emails' . DIRECTORY_SEPARATOR . date('Y-m-d') . '.txt';
        file_put_contents($file, $email . PHP_EOL, FILE_APPEND);
        $success = 'votre email a bien été enregistré';
        $email = '';
    } else {
        $error = 'Email non valide';
    }
}
else {
    $email = '';
}
?>
<h1>S'inscrire à la newletter</h1>
<p>trop bi1 ma newletter</p>
<?php if ($error !== ''):?>
    <div class="alert alert-danger">
        <?= $error ?>
    </div>
<?php elseif ($success !== ''): ?>
    <div class="alert alert-success">
        <?= $success ?>
    </div>
<?php endif ?>
<?php if ?>
<form action="newletter.php" method="POST" class = form-inline">
    <div class="form-group">
        <input type="email" name="email" placeholder="Entrez votre adresse e-mail" required class="form-control" value="<?= htmlentities($email); ?>">
    </div>
    <button type="submit" class="btn btn-primary">S'inscrire</button>
</form>



<?php require_once 'elements/footer.php'; ?>