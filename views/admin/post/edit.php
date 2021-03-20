<?php

use App\Connection;
use App\Table\PostTable;
use App\Validator;

$pdo = Connection::getPDO();
$postTable = new PostTable($pdo);
$post = $postTable->find($params['id']);

$success = false;
$errors = [];
if(!empty($_POST)) {
    Validator::lang('fr');
    $v = new Validator($_POST);
    $v->rule('required', 'name');
    $v->rule('lengthBetween', 'name', 3, 200);
    if($v->validate()) {
        $post->setName($_POST['name']);
        // ->setContent($_POST['content'])
        $postTable->update($post);
        $success = true;
    } else {
        $errors = $v->errors();
    }
}
?>

<?php if($success) : ?>
<div class="alert alert-success">
    L'article a bien été modifié
</div>
<?php endif ?>

<?php if(!empty($errors)) : ?>
<div class="alert alert-danger">
    L'article n'a pas pu être modifié, merci de corriger vos erreurs
</div>
<?php endif ?>

<h1>Editer l'article <?= htmlentities($post->getName()) ?></h1>
<form action="" method="POST">
    <div class="form-group">
        <label for="name">Titre</label>
        <input type="text" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" name="name" value="<?= htmlentities($post->getName()) ?>">
        <?php if(isset($errors['name'])) : ?>
        <div class="invalid-feeback">
            <?= implode('<br>', $errors['name']) ?>
        </div>
        <?php endif ?>
    </div>
    <button class="btn btn-primary">Modifier</button>
</form>