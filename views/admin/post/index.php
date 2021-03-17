<?php

use App\Auth;
use App\Connection;
use App\Table\PostTable;

Auth::check();

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
                <form method="POST" action="<?= $router->url('admin_post_delete', ['id' => $post->getID()]) ?>"
                onsubmit="return confirm('Voulez vous supprimer ce post ?')" style="display:inline">
                    <button type="submit" class="btn btn-danger">Supprimer</button>
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