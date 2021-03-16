<?php

use App\Connection;
use App\Model\{Post, Category};

$id = (int) $params['id'];
$slug = $params['slug'];

$pdo = Connection::getPDO();
$query = $pdo->prepare('SELECT * FROM post WHERE id = :id');
$query->execute(['id' => $id]);
$query->setFetchMode(PDO::FETCH_CLASS, Post::class);
/** @var Post */
$post = $query->fetch();

if ($post === false) {
    new Exception("Aucun article ne correspond à l'id '$id'");
}

if ($post->getSlug() !== $slug) {
    $url = $router->url('post', ['slug' => $post->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('Location: ' . $url);
    exit();
}

$query = $pdo->prepare('SELECT c.id, c.slug, c.name FROM post_category pc
JOIN category c ON pc.category_id = c.id
WHERE pc.post_id = :id');
$query->execute(['id' => $post->getID()]);
$query->setFetchMode(PDO::FETCH_CLASS, Category::class);
/** @var Category[] */
$categories = $query->fetchAll();

?>


<h1><?= htmlentities($post->getName()) ?></h1>
<p class=text-muted><?= $post->getCreatedAt()->format('d F Y') ?></p>
<?php foreach($categories as $k => $category) : ?>
    <?php if($k > 0) : ?>
    , 
    <?php endif ?>
    <a href="<?= $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]) ?>"><?= htmlentities($category->getName()) ?></a>
<?php endforeach ?>
<p><?= $post->getFormattedContent() ?></p>
