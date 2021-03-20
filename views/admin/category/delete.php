<?php

use App\Auth;
use App\Connection;
use App\Table\CategoryTable;

Auth::check();

$pdo = Connection::getPDO();
$cat_table = new CategoryTable($pdo);
$cat_table->delete($params['id']);
header('Location: ' . $router->url('admin_categories') . '?delete=1');
?>