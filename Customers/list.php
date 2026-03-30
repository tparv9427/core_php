<?php 
    require_once '../Database.php';
    require_once 'Customers.php';

    $db = (new Database())->connect();

    $sql = 'SELECT c.*, cg.group_name FROM customer c left join customer_group cg on c.customer_group_id = cg.customer_group_id ORDER BY c.customer_id DESC';
    
    $customers = $db->fetchAll($sql) ?: [];

    include 'grid.php';
    ?>