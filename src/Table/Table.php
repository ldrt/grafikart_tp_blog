<?php
namespace App\Table;

use PDO;
use App\Model\{Post, Category};
use App\Table\Exception\NotFoundException;
use Exception;

abstract class Table {
    protected $pdo;
    protected $table = null;
    protected $class = null;

    public function __construct(PDO $pdo) 
    {
        if($this->table === null) {
            throw new Exception("La class '". get_class($this) ."' n'a pas de propriété '\$table'");
        }
        if($this->class === null) {
            throw new Exception("La class '". get_class($this) ."' n'a pas de propriété '\$class'");
        }
        $this->pdo =$pdo;
    }
    
    public function find(int $id) : Post | Category
    {
        $query = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE id = :id');
        $query->execute(['id' => $id]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch();
        if($result === false){
            throw new NotFoundException($this->table, $id);
        }
        return $result;
    }

    /**
     * Check if value exists in a table
     * @param string $field Fiel to search 
     * @param mixed $value Value associated to the field
     */
    public function exists (string $field, $value, ?int $except = null) : bool
    {
        $sql = "SELECT COUNT(id) FROM {$this->table} WHERE $field = ?";
        $params = [$value];
        if($except !== null) { 
            $sql .= " AND id != ?";
            $params[] = $except;
        }
        $query = $this->pdo->prepare($sql);
        $query->execute($params);
        return (int) $query->fetch(PDO::FETCH_NUM)[0] > 0;
    }

    public function all() : array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
        return $this->pdo->query($sql, PDO::FETCH_CLASS, $this->class)->fetchAll();
    }
    
    public function delete(int $id) : void
    {
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $result = $query->execute([$id]);
        if($result === false) {
            throw new Exception("Impossible de supprimer l'enregistrement $id dans la table {$this->table}");
        }
    }
    
    public function create(array $fields) : int
    {
        $sqlFields = [];
        foreach($fields as $key => $value) {
            $sqlFields[] = "$key = :$key";
        }
        $query = $this->pdo->prepare("INSERT INTO {$this->table} SET " . implode(', ', $sqlFields));
        $result = $query->execute($fields);
        if($result === false) {
            throw new Exception("Impossible de créer l'enregistrement dans la table {$this->table}");
        }
        return (int) $this->pdo->lastInsertId();
    }
    
    public function update(array $fields, int $id) : void
    {
        $sqlFields = [];
        foreach($fields as $key => $value) {
            $sqlFields[] = "$key = :$key";
        }
        $query = $this->pdo->prepare("UPDATE {$this->table} SET " . implode(', ', $sqlFields) . " WHERE id = :id");
      
        $result = $query->execute(array_merge($fields, ["id" => $id]));
        if($result === false) {
            throw new Exception("Impossible de modifier l'enregistrement dans la table {$this->table}");
        }
    }
}

?>