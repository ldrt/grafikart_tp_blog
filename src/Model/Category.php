<?php
namespace App\Model;

use App\Helpers\Text;

class Category {
    private $id;
    private $name;
    private $slug;
    private $post_id;
    private $post;

    public function getID() : ?int
    {
        return $this->id;
    }

    public function getSlug() : ?string
    {
        return $this->slug;
    }

    public function getName() : ?string
    {
        return $this->name;
    }

    public function getpostID() : ?int
    {
        return $this->post_id;
    }

    public function setPost(Post $post) : void
    {
        $this->post = $post;
    }
}
?>