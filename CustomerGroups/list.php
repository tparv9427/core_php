<?php
require_once '../Database.php';
require_once 'CustomerGroups.php';

$db = (new Database())->connect();
$customerGroupModel = new CustomerGroups($db);

$sql = "SELECT * FROM customer_group ORDER BY customer_group_id DESC";
$customer_groups = $db->fetchAll($sql) ?: [];

include 'grid.php';
?>
