<?php
require_once '../Database.php';
require_once 'ProductMedia.php';

$db = (new Database())->connect();
$productMediaModel = new ProductMedia($db);

$sql = "SELECT m.*, p.name AS product_name 
        FROM product_media m
        LEFT JOIN product p ON m.product_id = p.product_id
        ORDER BY m.product_media_id DESC";
$product_medias = $db->fetchAll($sql) ?: [];

include 'grid.php';
?>
