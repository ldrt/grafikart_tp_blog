<?php
namespace App\Table;

use PDO;
use App\Model\Post;
use App\PaginatedQuery;
use Exception;

class PostTable extends Table {
    protected $table = "post";
    protected $class = Post::class;

    public function delete(int $id) : void
    {
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $result = $query->execute([$id]);
        if($result === false) {
            throw new Exception("Impossible de supprimer l'enregistrement $id dans la table {$this->table}");
        }
    }

    public function findPaginated() 
    {
        $paginatedQuery = new PaginatedQuery(
            "SELECT * FROM {$this->table} ORDER BY created_at DESC",
            "SELECT COUNT(id) FROM {$this->table}",
            $this->pdo
        );

        $posts = $paginatedQuery->getItems(Post::class);
        (new CategoryTable($this->pdo))->hydratePosts($posts);
        return [$posts, $paginatedQuery];
    }

    public function findPaginatedForCategory(int $categoryID)
    {
        $qPosts = "SELECT p.* 
        FROM {$this->table} p 
        JOIN post_category pc ON pc.post_id = p.id
        WHERE pc.category_id = {$categoryID}
        ORDER BY created_at DESC";
        $qCount = "SELECT COUNT(category_id) 
        FROM post_category 
        WHERE category_id = {$categoryID}";

        $paginatedQuery = new PaginatedQuery($qPosts, $qCount);
        $posts = $paginatedQuery->getItems(Post::class);

        (new CategoryTable($this->pdo))->hydratePosts($posts);
        return [$posts, $paginatedQuery];
    }
}

?>