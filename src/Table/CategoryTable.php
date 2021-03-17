<?php
namespace App\Table;

use PDO;
use App\Table\Table;
use App\Model\Category;
use App\Model\Post;

class CategoryTable extends Table {
    protected $table = "category";
    protected $class = Category::class;

    /**
     * @param Post[] $posts
     */
    public function hydratePosts (array $posts) : void
    {
        $postsByID = [];
        foreach($posts as $post) {
            $postsByID[$post->getID()] = $post;
        }
        $elements = implode(',', array_keys($postsByID));
        $categories = $this->pdo->query("SELECT c.*, pc.post_id
            FROM post_category pc
            JOIN category c ON c.id =pc.category_id
            WHERE pc.post_id IN ($elements)")
            ->fetchAll(PDO::FETCH_CLASS, $this->class);
        foreach($categories as $category) {
            $postsByID[$category->getpostID()]->addCategory($category);
        }
    }
}

?>