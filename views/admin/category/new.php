<?php

use App\HTML\Form;
use App\Connection;
use App\Model\Category;
use App\ObjectHelper;
use App\Table\CategoryTable;
use App\Validators\CategoryValidator;
use App\Auth;

Auth::check();

$errors = [];
$category = new Category();

if(!empty($_POST)) {
    $pdo = Connection::getPDO();
    $categoryTable = new CategoryTable($pdo);

    $v = new CategoryValidator($_POST, $categoryTable);
    ObjectHelper::hydrate($category, $_POST, ['name', 'slug']);
    if($v->validate()) {
        $categoryTable->create([
            'name' => $category->getName(),
            'slug' => $category->getSlug()
        ]);
        header('Location: ' . $router->url('admin_categories') . '?created=1');
        exit();
    } else {
        $errors = $v->errors();
    }
}
$form = new Form($category, $errors);
?>

<?php if(!empty($errors)) : ?>
<div class="alert alert-danger">
    La catégorie n'a pas pu être enregistré, merci de corriger vos erreurs
</div>
<?php endif ?>

<h1>Créer une catégorie</h1>
<?php require('_form.php') ?>