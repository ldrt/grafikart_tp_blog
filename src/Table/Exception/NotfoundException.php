<?php
namespace App\Table\Exception;

use Exception;

class NotFoundException extends Exception {
    public function __construct(string $table, $id = null)
    {
        $this->message = "Aucun enregistrement ne correspond dans la table '$table'";
    }
}