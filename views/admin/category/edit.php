<?php

use App\HTML\Form;
use App\Connection;
use App\ObjectHelper;
use App\Table\CategoryTable;
use App\Validators\CategoryValidator;
use App\Auth;

Auth::check();

$pdo = Connection::getPDO();
$categoryTable = new CategoryTable($pdo);
$category = $categoryTable->find($params['id']);

$success = false;
$errors = [];
if(!empty($_POST)) {
    $v = new CategoryValidator($_POST, $categoryTable, $category->getId());
    ObjectHelper::hydrate($category, $_POST, ['name', 'slug']);
    if($v->validate()) {
        $categoryTable->update([
            'name' => $category->getName(),
            'slug' => $category->getSlug()
        ], $category->getId());
        $success = true;
    } else {
        $errors = $v->errors();
    }
}
$form = new Form($category, $errors);
?>

<?php if(isset($_GET['created'])) : ?>
<div class="alert alert-success">
    La catégorie a bien été créée
</div>
<?php endif ?>

<?php if($success) : ?>
<div class="alert alert-success">
    La catégorie a bien été modifiée
</div>
<?php endif ?>

<?php if(!empty($errors)) : ?>
<div class="alert alert-danger">
    La catégorie n'a pas pu être modifiée, merci de corriger vos erreurs
</div>
<?php endif ?>

<h1>Editer la catégorie <?= htmlentities($category->getName()) ?></h1>
<?php require('_form.php') ?>