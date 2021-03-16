<?php
namespace App\Model;

use App\Helpers\Text;

class Category {
    private $id;
    private $name;
    private $slug;

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
}
?>