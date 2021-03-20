<?php

use App\HTML\Form;
use App\Validator;
use App\Connection;
use App\Table\PostTable;
use App\Validators\PostValidator;

$pdo = Connection::getPDO();
$postTable = new PostTable($pdo);
$post = $postTable->find($params['id']);

$success = false;
$errors = [];
if(!empty($_POST)) {
    Validator::lang('fr');
    $v = new PostValidator($_POST, $postTable, $post->getId());
    if($v->validate()) {
        $post->setName($_POST['name'])
            ->setContent($_POST['content'])
            ->setSlug($_POST['slug'])
            ->setCreatedAt($_POST['created_at']);
        $postTable->update($post);
        $success = true;
    } else {
        $errors = $v->errors();
    }
}
$form = new Form($post, $errors);
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
    <?= $form->input('name', 'Titre'); ?>
    <?= $form->input('slug', 'URL'); ?>
    <?= $form->textarea('content', 'Contenu'); ?>
    <?= $form->input('created_at', 'Date de création'); ?>
    
    
    <button class="btn btn-primary">Modifier</button>
</form>