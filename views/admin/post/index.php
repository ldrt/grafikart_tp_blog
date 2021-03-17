<?php

use App\Connection;
use App\Table\PostTable;

$title = "Administration";
$pdo = Connection::getPDO();
[$posts, $pagination] = (new PostTable($pdo))->findPaginated();
$link = $router->url('admin_posts');
?>

<?php if(isset($_GET['delete'])) : ?>
<div class="alert alert-success">
    L'enregistrement a bien été supprimé
</div>
<?php endif ?>

<table class="table">
    <thead>
        <th>ID</th>
        <th>Titre</th>
        <th>Actions</th>
    </thead>
    <tbody>
    <?php foreach($posts as $post) :  ?>
        <tr>
            <td>#<?= $post->getID() ?></td>
            <td>
                <a href="<?= $router->url('admin_post', ['id' => $post->getID()]) ?>">
                    <?= htmlentities($post->getName()) ?>
                </a>
            </td>
            <td>
                <a href="<?= $router->url('admin_post', ['id' => $post->getID()]) ?>" class="btn btn-primary">
                    Editer
                </a>
                <a href="<?= $router->url('admin_post_delete', ['id' => $post->getID()]) ?>" class="btn btn-danger"
                onclick="return confirm('Voulez vous supprimer ce post ?')">
                    Supprimer
                </a>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>

<div class="d-flex justify-content-between my-4">
    <?= $pagination->previousLink($link) ?>
    <?= $pagination->nextLink($link) ?>
</div>