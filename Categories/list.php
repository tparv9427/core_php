<?php
require_once '../Database.php';
require_once 'Category.php';

$db = (new Database())->connect();
$categoryModel = new Category($db);

$sql = "SELECT * FROM category ORDER BY category_id DESC";
$categories = $db->fetchAll($sql) ?: [];

include 'grid.php';
?>
