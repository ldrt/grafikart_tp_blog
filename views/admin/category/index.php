<?php

use App\Auth;
use App\Connection;
use App\Table\CategoryTable;

Auth::check();

$title = "Administration: Catégories";
$pdo = Connection::getPDO();
$link = $router->url('admin_categories');
$items = (new CategoryTable($pdo))->all();
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
        <th>Slug</th>
        <th>
            <a href="<?= $router->url('admin_category_new') ?>" class="btn btn-primary">Créer une catégorie</a>
        </th>
    </thead>
    <tbody>
    <?php foreach($items as $item) :  ?>
        <tr>
            <td>#<?= $item->getID() ?></td>
            <td>
                <a href="<?= $router->url('admin_category', ['id' => $item->getID()]) ?>">
                    <?= htmlentities($item->getName()) ?>
                </a>
            </td>
            <td><?= $item->getSlug() ?></td>
            <td>
                <a href="<?= $router->url('admin_category', ['id' => $item->getID()]) ?>" class="btn btn-primary">
                    Editer
                </a>
                <form method="POST" action="<?= $router->url('admin_category_delete', ['id' => $item->getID()]) ?>"
                onsubmit="return confirm('Voulez vous supprimer cette catégorie ?')" style="display:inline">
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </a>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>