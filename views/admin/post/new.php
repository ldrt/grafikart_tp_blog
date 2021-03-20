<?php

use App\HTML\Form;
use App\Connection;
use App\Model\Post;
use App\ObjectHelper;
use App\Table\PostTable;
use App\Validators\PostValidator;
use App\Auth;

Auth::check();

$errors = [];
$post = new Post();

if(!empty($_POST)) {
    $pdo = Connection::getPDO();
    $postTable = new PostTable($pdo);

    $v = new PostValidator($_POST, $postTable, $post->getId());
    ObjectHelper::hydrate($post, $_POST, ['name', 'content', 'slug', 'created_at']);
    if($v->validate()) {
        $postTable->createPost($post);
        header('Location: ' . $router->url('admin_post', ['id' => $post->getId()]) . '?created=1');
        exit();
    } else {
        $errors = $v->errors();
    }
}
$form = new Form($post, $errors);
?>

<?php if(!empty($errors)) : ?>
<div class="alert alert-danger">
    L'article n'a pas pu être enregistré, merci de corriger vos erreurs
</div>
<?php endif ?>

<h1>Créer un article</h1>
<?php require('_form.php') ?>